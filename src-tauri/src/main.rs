//! Studio Clipper — Tauri shell.
//!
//! Spawns two PHP sidecars (HTTP server + job worker) pointing at the
//! bundled app/, waits for the port, opens the window to it, and kills
//! both children on exit.

use std::net::{TcpListener, TcpStream};
use std::path::PathBuf;
use std::process::{Child, Command, Stdio};
use std::sync::{Arc, Mutex};
use std::time::{Duration, Instant};
use tauri::{Manager, RunEvent, WebviewUrl, WebviewWindowBuilder};

/* ------------------------------------------------------------------ */

#[derive(Clone)]
struct Spec {
    program: PathBuf,
    args: Vec<String>,
}

fn spawn(spec: &Spec, app_dir: &PathBuf, data_dir: &PathBuf) -> std::io::Result<Child> {
    Command::new(&spec.program)
        .args(&spec.args)
        .current_dir(app_dir)
        .env("CC_DATA_DIR", data_dir)
        .env(
            "PATH",
            format!(
                "{}/bin:/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:/usr/sbin:/sbin",
                app_dir.display()
            ),
        )
        .stdin(Stdio::null())
        .stdout(Stdio::null())
        .stderr(Stdio::null())
        .spawn()
}

type Children = Arc<Mutex<Vec<(Spec, Child)>>>;

/* ------------------------------------------------------------------ */

fn php_binary() -> Option<PathBuf> {
    if let Ok(p) = std::env::var("CC_PHP_BIN") {
        if !p.is_empty() && PathBuf::from(&p).is_file() {
            return Some(PathBuf::from(p));
        }
    }
    let mut candidates: Vec<PathBuf> = Vec::new();
    if let Ok(exe) = std::env::current_exe() {
        if let Some(dir) = exe.parent() {
            // Bundled: Contents/Resources/sidecar/(php | php/bin/php)
            let res = dir.join("../Resources");
            candidates.push(res.join("sidecar/php"));
            candidates.push(res.join("sidecar/php/bin/php"));
        }
    }
    // Dev checkout: <repo>/sidecar/…
    let repo = PathBuf::from(env!("CARGO_MANIFEST_DIR")).join("..");
    candidates.push(repo.join("sidecar/php"));
    candidates.push(repo.join("sidecar/php/bin/php"));
    for c in &candidates {
        if c.is_file() {
            return Some(c.clone());
        }
    }
    // Dev fallback: LocalWP lightning-services php (newest installed).
    if let Ok(home) = std::env::var("HOME") {
        let base =
            PathBuf::from(home).join("Library/Application Support/Local/lightning-services");
        if let Ok(rd) = std::fs::read_dir(&base) {
            let mut hits: Vec<PathBuf> = rd
                .filter_map(|e| {
                    let p = e.ok()?.path().join("bin/darwin/bin/php");
                    p.is_file().then_some(p)
                })
                .collect();
            hits.sort();
            if let Some(p) = hits.pop() {
                return Some(p);
            }
        }
    }
    None
}

fn app_dir() -> Option<PathBuf> {
    if let Ok(p) = std::env::var("CC_APP_DIR") {
        if !p.is_empty() && PathBuf::from(&p).is_dir() {
            return Some(PathBuf::from(p));
        }
    }
    if let Ok(exe) = std::env::current_exe() {
        if let Some(dir) = exe.parent() {
            let cand = dir.join("../Resources/app");
            if cand.is_dir() {
                return Some(cand);
            }
        }
    }
    let cand = PathBuf::from(env!("CARGO_MANIFEST_DIR")).join("../app");
    if cand.is_dir() {
        return Some(cand);
    }
    None
}

fn data_dir() -> PathBuf {
    if let Ok(p) = std::env::var("CC_DATA_DIR") {
        if !p.is_empty() {
            return PathBuf::from(p);
        }
    }
    let home = std::env::var("HOME").unwrap_or_else(|_| "/tmp".into());
    PathBuf::from(home).join("Library/Application Support/studio-clipper")
}

fn free_port() -> Option<u16> {
    TcpListener::bind("127.0.0.1:0")
        .ok()?
        .local_addr()
        .ok()
        .map(|a| a.port())
}

fn wait_ready(port: u16, timeout: Duration) -> bool {
    let deadline = Instant::now() + timeout;
    while Instant::now() < deadline {
        if TcpStream::connect(("127.0.0.1", port)).is_ok() {
            return true;
        }
        std::thread::sleep(Duration::from_millis(120));
    }
    false
}

fn kill_children(children: &Children) {
    let mut guard = children.lock().unwrap();
    for (_, c) in guard.iter_mut() {
        let _ = Command::new("/bin/kill")
            .args(["-TERM", &c.id().to_string()])
            .status();
    }
    std::thread::sleep(Duration::from_millis(1200));
    for (_, c) in guard.iter_mut() {
        let _ = c.kill();
        let _ = c.wait();
    }
    guard.clear();
}

/* ------------------------------------------------------------------ */

fn main() {
    tauri::Builder::default()
        .setup(|app| {
            let children: Children = Arc::new(Mutex::new(Vec::new()));
            app.manage(children.clone());

            let Some(php) = php_binary() else {
                return Err(
                    "PHP runtime tidak ditemukan (bundle sidecar atau install LocalWP).".into(),
                );
            };
            let Some(dir) = app_dir() else {
                return Err("Folder app/ tidak ditemukan.".into());
            };
            let data = data_dir();
            let _ = std::fs::create_dir_all(&data);
            let Some(port) = free_port() else {
                return Err("Tidak ada port bebas.".into());
            };

            let server = Spec {
                program: php.clone(),
                args: vec![
                    "-S".into(),
                    format!("127.0.0.1:{}", port),
                    "-t".into(),
                    dir.join("public").to_string_lossy().to_string(),
                    dir.join("server/router.php").to_string_lossy().to_string(),
                ],
            };
            let worker = Spec {
                program: php,
                args: vec![dir.join("server/worker.php").to_string_lossy().to_string()],
            };

            let srv = spawn(&server, &dir, &data);
            let wrk = spawn(&worker, &dir, &data);
            match (srv, wrk) {
                (Ok(a), Ok(b)) => {
                    let mut g = children.lock().unwrap();
                    g.push((server.clone(), a));
                    g.push((worker.clone(), b));
                }
                _ => return Err("Gagal menjalankan PHP sidecar.".into()),
            }

            // Respawn monitor — worker may die on fatal pipeline errors.
            let mon = children.clone();
            let dir_m = dir.clone();
            let data_m = data.clone();
            std::thread::spawn(move || loop {
                std::thread::sleep(Duration::from_secs(2));
                let mut guard = mon.lock().unwrap();
                for i in (0..guard.len()).rev() {
                    let dead = !matches!(guard[i].1.try_wait(), Ok(None));
                    if dead {
                        let (spec, _) = guard.remove(i);
                        if let Ok(c) = spawn(&spec, &dir_m, &data_m) {
                            guard.push((spec, c));
                        }
                    }
                }
            });

            if !wait_ready(port, Duration::from_secs(15)) {
                return Err("PHP server tidak merespons dalam 15 detik.".into());
            }

            let url =
                WebviewUrl::External(format!("http://127.0.0.1:{}/", port).parse().unwrap());
            WebviewWindowBuilder::new(app, "main", url)
                .title("Studio Clipper")
                .inner_size(1280.0, 800.0)
                .min_inner_size(1024.0, 640.0)
                .build()?;

            Ok(())
        })
        .build(tauri::generate_context!())
        .expect("error building Studio Clipper")
        .run(|app, event| {
            if let RunEvent::ExitRequested { .. } = event {
                if let Some(children) = app.try_state::<Children>() {
                    kill_children(children.inner());
                }
            }
        });
}

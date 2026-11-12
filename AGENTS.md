# AGENTS.md — Studio Clipper

App macOS standalone hasil port theme WordPress `studio-inspirasi-chat`
(sumber: `~/Local Sites/concat-chat/app/public/wp-content/themes/studio-inspirasi-chat`).
Frontend (Alpine.js + vanilla JS) dipertahankan; backend WP digantikan
static PHP + shim API WordPress di atas SQLite. Logo = clapperboard
emerald sama seperti Studio Inspirasi.

## Lingkungan
- macOS 12.7.6 (Monterey), Intel x86_64.
- PHP runtime: **LocalWP** `~/Library/Application Support/Local/lightning-services/php-8.3.36+0/bin/darwin/bin/php` (PHP 8.3 CLI) — dipakai dev. JANGAN disalin — dylibs-nya bikin dyld hang saat direlokasi.
- Static PHP untuk bundle: build via `tools/spc` (StaticPHP v3) → `tools/build-php.sh`.
- Rust stable (cargo 1.93), Xcode CLT, Node 22 via nvm (`~/.nvm/versions/node/v22.23.4/bin`).

## Perintah
- Dev tanpa Tauri: `tools/dev.sh` → http://127.0.0.1:8788 (+ worker di background; `CC_DATA_DIR` default `/tmp/studioclipper-dev`)
- Smoke test shim/DB: `tools/smoke.sh`
- Lint semua PHP: `for f in app/{inc,server,views,public}/*.php app/public/*.php; do php -l "$f"; done`
- Tauri dev: `cd src-tauri && cargo run` (fallback PHP = LocalWP, app = `../app`)
- Build: `npm run tauri build` → `.app`/`.dmg` di `src-tauri/target/release/bundle/`
- Build PHP statis: `tools/build-php.sh` → `sidecar/php` (butuh ~30–60 mnt pertama kali)

## Arsitektur
```
StudioClipper.app (Tauri)
└── src-tauri/src/main.rs ── spawn 2 proses php ── kill saat quit
     ├── php -S 127.0.0.1:<port bebas> -t app/public app/server/router.php
     └── php app/server/worker.php   (daemon: reap + claim cc_jobs 'queued')
```
- `app/server/compat.php` — shim ~50 API WP: `WP_Error`, `$wpdb` facade PDO-SQLite, options+transients (`cc_options`), REST registry (`register_rest_route`/`WP_REST_Request`/`cc_rest_dispatch`), `wp_remote_*`→curl, sanitize/esc, hooks, auth stubs (single admin uid=1), `wp_salt`→`CC_DATA_DIR/secret`.
- `app/server/bootstrap.php` — ABSPATH=`app/`, `CC_DATA_DIR` (default `~/Library/Application Support/studio-clipper`), AUTH_KEY dsb dari secret, buka `app.db`, require 12 inc, `do_action('init')`+`do_action('rest_api_init')`.
- `app/server/router.php` — `/`→index.php, `/concat/v1/*`→REST, `/uploads/*`→file di `CC_DATA_DIR/uploads`, selainnya static via php -S.
- `app/inc/db.php` — SATU-SATUNYA file inc yang diedit signifikan (DDL SQLite). Prefix tabel kosong → `cc_sessions`/`cc_messages`/`cc_jobs`/`cc_options`. Datetime = string UTC (`current_time` shim → gmdate).
- Cron = no-op (wp_schedule_single_event/spawn_cron no-op); `cc_rest_edl_review` me-requeue job ke status 'queued' yang dijemput worker.
- `wp_upload_dir()` shim → `CC_DATA_DIR/uploads` + `/uploads` (streaming di router).
- Media stream & thumb memakai HMAC `wp_salt('nonce')` + whitelist ekstensi + `CC_Tools::read_allowed` — tidak berubah.
- Secrets (API key/token) terenkripsi AES-256-CTR pakai AUTH_KEY|SECURE_AUTH_KEY dari file `secret`.
- `cc_path_to_url()` — fungsi HILANG di theme asli (fatal bila kepanggil); di-shim di compat.php → `cc_media_url`.

## Konvensi & catatan
- Nama produk "Studio Clipper"; identifier `app.studioclipper`; window 1280×800 (min 1024×640); icon clapperboard emerald (`src-tauri/icons/`).
- ffmpeg/yt-dlp di `app/bin` adalah x86_64 — belum universal (perlu arm64 ffmpeg untuk build M-series).
- PHP LocalWP tidak bisa dipindah (dyld hang) — bundle wajib static PHP (`sidecar/php`).
- `views/` murni HTML+Alpine (guard `ABSPATH` saja) — tidak boleh dipanggil langsung via URL (di luar docroot).
- Ringkasan perubahan ditulis di `logs/`.

# Port awal: theme WP `studio-inspirasi-chat` → Studio Clipper

Tanggal: 2026-11-12

## Ringkasan

Seluruh theme WordPress `studio-inspirasi-chat` dipindahkan ke repo
`studio-clipper-app/` sebagai aplikasi macOS standalone (Tauri + PHP
sidecar + SQLite), sesuai plan `plan-21533fdb19f7236f.md`. Nama produk
"Studio Clipper", logo clapperboard emerald sama dengan Studio Inspirasi.

## Yang dibuat/diubah

- `app/` — copy dari theme: `inc/` (12 file), `views/`, `public/assets/`, `public/vendor/`, `bin/` (ffmpeg/ffprobe/yt-dlp x86_64).
- `app/server/compat.php` — shim ~50 API WordPress: `WP_Error`, facade `$wpdb` PDO-SQLite, options+transients, registry REST, `wp_remote_*`→curl, sanitize/escaping, hooks, auth stubs, `wp_salt`, `cc_path_to_url` (fungsi hilang di theme asli).
- `app/server/bootstrap.php` — konstanta, secret, koneksi SQLite, require semua inc, fire `init`+`rest_api_init`.
- `app/server/router.php` — front controller `php -S`: `/`, `/concat/v1/*`, `/uploads/*`, static.
- `app/server/worker.php` — daemon job queue (reap + claim `queued`).
- `app/inc/db.php` — satu-satunya inc yang diedit signifikan: DDL MySQL/dbDelta → SQLite + tabel `cc_options`.
- `app/public/index.php` — shell markup pengganti front-page/header/footer; `CC_DATA` dengan restUrl relatif, nonce kosong.
- `app/public/vendor/` — Alpine.js 3.14.1 + Lucide 0.469.0 vendored (offline, tanpa CDN).
- `app/public/assets/js/chat.js` — hapus `X-WP-Nonce`, judul fallback "Studio Clipper".
- `app/views/sidebar.php` — branding "Studio Clipper".
- `src-tauri/` — shell Tauri 2: dynamic port, spawn server+worker, health check, kill saat exit; productName "Studio Clipper", identifier `app.studioclipper`, icon clapperboard.
- `tools/` — `dev.sh`, `smoke.sh`, `smoke.php`, `build-php.sh`, `spc` (StaticPHP v3).
- `AGENTS.md` — dokumentasi lingkungan/perintah/arsitektur.

## Verifikasi yang sudah lulus

- `php -l` semua file PHP — clean.
- `tools/smoke.sh` — shim+DB: insert/select/update, prepare, options, transients (incl. expiry), WP_Error → ALL OK.
- `php -S`: `/` 200 (title "Studio Clipper"), `/concat/v1/{status,settings,sessions}` 200, assets CSS/JS/vendor 200, route asing 404, DELETE session 200/404.
- Worker: claim job `queued` → settle `failed` (Studio Inspirasi editor tidak jalan — expected).
- Media stream: file valid 200, Range 206, di luar root 403, sig rusak 403/410.
- Tauri dev: spawn server (port bebas) + worker; REST merespons lewat instance Tauri.

## Catatan / known issues

- PHP LocalWP tidak bisa direlokasi (dyld hang) → bundle WAJIB static PHP; dev pakai `CC_PHP_BIN` fallback di `main.rs`.
- Build static PHP via `tools/spc` sedang berjalan (x86_64 dulu; arm64 menyusul untuk universal).
- ffmpeg/yt-dlp di `app/bin` x86_64 only — perlu arm64 untuk universal.
- End-to-end pipeline terhadap Studio Inspirasi sungguhan belum diuji.

## Update: static PHP + release bundle (2026-11-12 malam)

- `tools/spc` build sukses (~38 mnt): **PHP 8.3.36 static x86_64** → `sidecar/php` (17 MB). `otool -L` hanya libSystem/frameworks; semua ext (curl, dom, mbstring, openssl, pdo_sqlite, posix, sqlite3, tokenizer, xml*, zlib) built-in; smoke test spc lulus.
- **Build fix:** curl gagal link `_ASN1_STRING_get_length` — Apple Clang menyisipkan `-I/usr/local/include` (mendahului `-isystem`), sehingga header Homebrew **openssl@4 (4.1.0)** terpakai padahal link ke libcrypto 3.6.5 lokal. Fix: sembunyikan sementara symlink `/usr/local/include/openssl` selama build.
- `build-php.sh` diperbaiki: jalankan `spc` dari `tools/` (cache dir) + copy ke `sidecar/php`.
- `tools/dev.sh` & `tools/smoke.sh` kini prefer `sidecar/php` bila ada.
- **Orphan fix:** `kill -TERM`/SIGKILL ke app membiarkan 2 sidecar yatim (ExitRequested Tauri tidak jalan untuk sinyal). Ditambahkan watchdog `cc_sidecar_watchdog()` di bootstrap: tiap proses menulis `CC_DATA_DIR/run/<name>.pid`; saat `posix_getppid()===1` (reparent ke launchd = parent mati), proses membunuh sibling via pid-file lalu exit. Worker cek tiap loop (~500 md), server cek per request. Terverifikasi: kill -TERM app → kedua sidecar mati <3 dtk, pid-file terbersih.
- `npm run tauri build` sukses → `Studio Clipper_0.1.0_x64.dmg` (77 MB). Bundle: `Resources/sidecar/php` (+x), `Resources/app/` lengkap (inc/public/server/views/bin), CFBundleName "Studio Clipper", identifier `app.studioclipper`.
- Verified di bundle: spawn 2 sidecar, server di port bebas, `/`+REST+assets 200, title "Studio Clipper", `~/Library/Application Support/studio-clipper/` (app.db WAL, secret, logs, run/) terbentuk.
- **Universal:** belum — mesin ini Intel; arm64 perlu build di Apple Silicon (spc native-only) lalu `lipo`. ffmpeg/yt-dlp juga x86_64-only.

## Update: bugfix browse-flicker + watchdog (2026-11-12 malam)

- **Laporan:** klik Browse → popup file-explorer flicker & tidak tampil.
- **Penyebab (2 lapis):**
  1. `x-transition.opacity` di semua `.cc-ovl` — kombinasi opacity+transform
     transition yang glitch di WebKit/WKWebView (Alpine #2827, WebKit bug
     238067). Dihapus dari keempat overlay di `views/modals.php`.
  2. `ctlBrowseTo` catch → `browseOpen=false` instan saat `/control/folder`
     error (mis. path di luar read_roots) → popup menutup tanpa jejak.
     Sekarang error tampil DI DALAM modal (`ctl.browse.error` + `<p>` baru).
- **Watchdog fix:** `exit(0)` di dalam router `php -S` hanya mengakhiri
  request, TIDAK membunuh proses server (terbukti via uji — server tetap
  respons 200). Diganti `posix_kill(getmypid(), 15)`; orphan server kini
  benar-benar mati. Terverifikasi: proses ppid=1 mati sendiri saat request
  berikutnya; `kill -TERM` app → kedua sidecar mati <3 dtk.
- Rebuild `Studio Clipper_0.1.0_x64.dmg` — bundle terverifikasi berisi fix,
  `/` + `/control/folder` 200, exit bersih.
- Catatan debug: entry `logs/watchdog.log` sementara sudah dihapus lagi.

## Update: bugfix "Route tidak ditemukan" — double-slash REST (2026-11-12 malam)

- **Laporan:** modal browse sudah tampil, tapi tombol panah-atas tidak
  berfungsi + tertulis "Route tidak ditemukan".
- **Penyebab:** `CC_DATA.restUrl` = `/concat/v1/` (trailing slash) dan
  `ccApi` menambahkan `'/control/folder'` (leading slash) → request ke
  `/concat/v1//control/folder`. Nginx di WP asli menormalkan `//`; router
  `php -S` kami tidak → `cc_rest_dispatch` gagal match → 404
  `rest_no_route`. Dampaknya ke SEMUA call REST, bukan cuma browse.
  Up-button disabled karena `browse.parent` kosong di state error.
- **Fix (2 lapis, server-side — frontend tidak disentuh):**
  1. `app/server/router.php`: collapse `preg_replace('#/+#','/',$uri)`
     setelah rawurldecode — menormalkan URI masuk seperti nginx.
  2. `app/server/compat.php` (`cc_rest_dispatch`): normalisasi `$path`
     dengan cara sama sebelum route matching — pertahanan ekstra.
- **Catatan verifikasi:** pengujian bundle sebelumnya sempat menyesatkan
  — ada 2 mount DMG stale (`/Volumes/Studio Clipper 1`, `2`) sehingga
  `cp` menyalin .app lama dan menunjukkan 404. Setelah unmount semua &
  re-attach dmg baru, isi bundle terbukti sudah berisi fix.
- **Verified di bundle baru (extract → launch → ps child PID → port):**
  - `/concat/v1//status` → 200 (JSON status)
  - `/concat/v1//control/folder` → 200 (`path`,`parent`,`dirs`,`files`;
    `parent` terisi → tombol atas aktif)
  - `/concat/v1/control/folder` (single slash) → 200 identik
  - `/` → 200; 2 sidecar spawn; `kill -TERM` → nol proses sisa.
- Perilaku up-arrow: tiap `ctlBrowseTo(parent)` kini sukses → modal
  render folder induk dengan `parent` baru → bisa naik terus sampai root.

## Update: bugfix "Method tidak diizinkan" — multi-method REST route (2026-11-12 malam)

- **Laporan:** Settings → tab Folder → klik Simpan → "Method tidak
  diizinkan".
- **Penyebab:** `/settings` didaftarkan DUA kali di `inc/rest.php`
  (GET → `cc_rest_settings_get`, POST → `cc_rest_settings_save`).
  Dispatcher `cc_rest_dispatch` me-return 405 pada entry pertama yang
  cocok path-nya (GET) tanpa mengecek registrasi berikutnya — WP asli
  menggabungkan semua method untuk satu route path. Dampak: SEMUA POST
  ke path yang juga punya GET twin (saat ini hanya `/settings`) 405.
- **Fix di `app/server/compat.php`:**
  1. `cc_rest_dispatch`: method mismatch → `continue` ke registrasi
     berikutnya; flag `$path_matched` → return 405 hanya bila tidak ada
     registrasi method yang cocok (semantik WP asli).
  2. `register_rest_route`: normalisasi `methods` — split string koma
     (`'POST, PUT'` / konstanta `WP_REST_Server::EDITABLE`) menjadi list
     uppercase flat.
- **Verified (dev :8788 + bundle baru diextract):**
  - `POST //settings` → `{"ok":true}` (sebelumnya 405); GET → 200 data
    tersimpan; DELETE → 405 tetap benar; unknown path → 404.
  - `POST //settings/test` & `//sessions/1/rename` mencapai handler (400
    validasi, bukan 405).
  - Bundle: 2 sidecar spawn, `kill -TERM` → nol proses sisa.
- `tools/smoke.sh` → ALL OK.

## Update: bugfix YouTube URL — "File video tidak ditemukan" (2026-11-12 malam)

- **Laporan:** Jalankan dengan sumber `youtube.com/watch?v=…` → error
  "File video tidak ditemukan".
- **Akar masalah (2):**
  1. `wp_normalize_path` shim meng-collapse `//` → `https://youtube.com/…`
     rusak jadi `https:/youtube.com/…` → `cc_control_is_yt` (regex
     `^https?://`) gagal → jatuh ke `file_exists` → error. WP asli
     mempertahankan scheme stream wrapper. **Ini regresi shim** — semua
     URL YouTube penuh ikut rusak.
  2. Input user tanpa skema (`youtube.com/…` — hasil copy browser) —
     di WP asli pun akan gagal, tapi UX memang mengharapkannya jalan.
- **Fix:**
  1. `compat.php`: `wp_normalize_path` kini pakai `wp_is_stream` (baru
     di-shim) — scheme `xxx://` dipertahankan; collapse `/+` memakai
     lookbehind `(?<=.)` seperti WP (leading `//` network share aman).
  2. `inc/rest.php` (`cc_rest_control_run`): prepend `https://` bila
     `file` cocok `(www.)?(youtube.com|youtu.be)/…` tanpa skema.
- **Verifikasi:**
  - Unit: `https://…` utuh, `/a//b`→`/a/b`, `//share` utuh.
  - E2E dev: POST `file=youtube.com/watch?v=x` → `{"ok":true,"job_id":2}`
    (payload tersimpan canonical `https://…` → worker `is_yt` → yt-dlp).
    File lokal hilang → tetap `cc_file` 400.
  - **E2E bundle (data real user):** job "Studio Clipper Test 1"
    status `done` — worker mengunduh video YT via `app/bin/yt-dlp` dan
    pipeline berjalan sampai selesai.
- `tools/smoke.sh` → ALL OK. Rebuild dmg 77.12 MB.
- Insiden uji: pid-detection `pgrep|head -1` mengambil app user
  (/Applications, pid 794) bukan instance uji /tmp → curl test membuat
  job "yt" stray (job 2, juga `done` — reuse cache unduhan) dan
  `kill -TERM` menutup app user. Pelajaran: filter ppid spesifik child
  dari pid yang baru di-spawn, bukan pgrep global.

## Update: ikon app baru (2026-11-12 malam)

- Sumber: `~/Downloads/studio-clipper-logo.png` (512×512 RGBA,
  clapperboard emerald — desain baru dari user) disalin ke
  `app-icon.png` di root repo untuk regenerasi mendatang.
- `npx tauri icon app-icon.png -o src-tauri/icons` → semua ukuran
  diperbarui (32/64/128/256/512 PNG, `icon.icns`, `icon.ico`,
  Square*/StoreLogo, Android/iOS set).
- Rebuild dmg (76.96 MB) — `Resources/icon.icns` di bundle md5-identik
  dengan ikon baru. Dock/Finder akan pakai ikon baru setelah reinstall.

## Update: bugfix judul proses menimpa tombol stop (2026-11-12 malam)

- **Laporan:** panel Processes — judul job panjang ("Studio Clipper 2
  Download dari YouTube") tumpang tindih dengan tombol stop merah.
- **Penyebab:** `.truncate` (overflow+ellipsis+nowrap) dipakai sebagai
  flex item di `.cc-proc-title` tanpa `min-width: 0`. Di Chrome,
  `overflow:hidden` otomatis mengecilkan min-content flex item; di
  WKWebView (WebKit Monterey) tidak — item tetap selebar konten lalu
  meluber di bawah tombol `.cc-cancel`.
- **Fix:** tambah `min-width: 0` ke utility `.truncate` di
  `app/public/assets/css/app.css` — mencakup semua pemakaian
  (processes, projects, templates, library, modals, cc-flex1 combos).
- Rebuild dmg 76.96 MB; CSS ter-verify di dalam bundle.

## Update: bugfix judul proses tumpang tindih — ronde 2 (2026-11-12 malam)

- Fix pertama (`min-width:0` di `.truncate`) TIDAK cukup — masih overlap.
- Repro headless dibuat: skrip Swift + `WKWebView.takeSnapshot` → PNG
  (wkshot) — rendering WKWebView asli tanpa UI, iterasi varian CSS cepat.
- **Akar masalah sebenarnya:** di dalam `<button>` (`cc-proc-btn`),
  WebKit TIDAK meng-clamp item kolom-flex (`.cc-proc-title`) ke lebar
  content-box tombol — item tetap selebar max-content sehingga `.truncate`
  di dalamnya tidak pernah menyusut. Tombolnya sendiri bounded benar
  (varian `overflow:hidden` pada button memotong tepat di tepi tombol).
- **Fix (terverifikasi via snapshot WKWebView):**
  - `.cc-proc-title { max-width: 100%; }` — clamp ke lebar tombol.
  - `.cc-proc-title .truncate { flex: 1; }` — isi sisa ruang + ellipsis.
- Pemakaian `.truncate` lain (projects/templates/library/detail) aman —
  containernya `<td>`/`<div>`, bukan `<button>`.
- Rebuild dmg 76.96 MB; CSS ter-verify di bundle.

## Update: bugfix audio player SFX merosot ke bawah baris (2026-11-12 malam)

- **Laporan:** tabel Sound Effects — `<audio controls>` di kolom Preview
  merosot ke bawah, keluar dari batas bawah baris.
- **Akar masalah:** `<td class="cc-t-actions">` memakai `display:flex`.
  td non-table-cell di WebKit dibungkus anonymous table cell — interaksi
  baseline/tinggi baris pada tabel `border-collapse` membuat konten
  flex-nya turun melewati border baris (repro minimal WKWebView tidak
  konsisten memicu — bergantung konteks tinggi sel lain).
- **Fix (bulletproof secara struktur):**
  - `views/library.php`: td kolom Preview pakai class baru `cc-t-audio`
    (bukan `cc-t-actions`) → kembali jadi table-cell murni.
  - `app.css`: `.cc-t-audio { text-align:right; white-space:nowrap }` +
    `.cc-lib-audio { display:block; height:2rem; max-width:16rem;
    margin-left:auto; }` — elemen block dalam sel `vertical-align:middle`
    tidak bisa meluber keluar sel.
  - `td.cc-t-actions` lain (tombol pensil di Projects/Templates) tidak
    diubah — kecil dan tidak menunjukkan gejala.
- Verifikasi snapshot WKWebView: audio ter-center dalam sel.
- Rebuild dmg 76.96 MB.

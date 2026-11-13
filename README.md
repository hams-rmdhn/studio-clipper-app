# Studio Clipper

Aplikasi desktop macOS untuk mengendalikan **Studio Inspirasi** (video editor
desktop) — port standalone dari theme WordPress `studio-inspirasi-chat`.
Tanpa WordPress, tanpa server web: satu `.app` dengan PHP + SQLite di dalamnya.

**Landing page:** https://hams-rmdhn.github.io/studio-clipper-app/
[Download `Studio Clipper_0.1.0_x64.dmg`](https://github.com/hams-rmdhn/studio-clipper-app/releases/latest)

## Yang berubah vs theme asli

| WordPress | Studio Clipper |
|---|---|
| WP runtime + MySQL | PHP 8.3.36 **static** + SQLite (`compat.php` shim ~50 API WP) |
| Apache/nginx | `php -S` sidecar di dalam `.app` (port bebas, 127.0.0.1) |
| WP-Cron | `worker.php` daemon — antrian job `cc_jobs` |
| Browser | Tauri (WKWebView), window 1280×800 |
| Auth WP + nonce | Single-admin stub + HMAC `wp_salt` untuk media stream |

Seluruh logika pipeline (`inc/*.php`) dipertahankan apa adanya — hanya
`inc/db.php` yang ditulis ulang untuk DDL SQLite.

## Fitur

- **Dashboard** — Create New, Projects, Templates, B-Rolls, Sound Effects,
  Settings + panel Processes (job berjalan + antrian review)
- **Pipeline deterministik** — template → ganti video → trim segmen →
  caption → serah ke Studio Inspirasi / ekspor via API
- **Multi-segmen** — satu run = banyak proyek `{judul}-001`, `-002`, …
- **Momen Terbaik (AI)** — dari URL YouTube (dengan/tanpa `https://`):
  unduh video+caption via yt-dlp, AI memilih momen terbaik, snap ke batas kalimat
- **Library** — jelajah koleksi B-Roll (thumbnail+preview) & SFX (audio player)
- **Caption** — style diwarisi dari template, satu lane `Captions` rapi

## Instalasi

1. Unduh DMG dari [Releases](https://github.com/hams-rmdhn/studio-clipper-app/releases/latest) → drag `Studio Clipper.app` ke Applications.
2. App **unsigned**: klik kanan → **Open** → Open anyway
   (atau `xattr -dr com.apple.quarantine "/Applications/Studio Clipper.app"`).
3. Di Studio Inspirasi: **Settings › Automation** → aktifkan *Scripts and apps*
   (token `automation.json` terbaca otomatis), atau isi token di Settings › Studio Inspirasi.
4. Isi API key OpenAI/OpenRouter di **Settings › Agen AI**.

Data app disimpan di `~/Library/Application Support/studio-clipper/`
(`app.db` SQLite, `secret`, `logs/`, `uploads/`). Workspace pipeline default
`~/concat-chat-projects/` — sama seperti versi theme.

## Arsitektur

```
Studio Clipper.app (Tauri / WKWebView)
└── src-tauri/src/main.rs ── spawn 2 sidecar PHP ── kill saat quit
     ├── php -S 127.0.0.1:<port> -t app/public app/server/router.php
     │    ├── /            → index.php (UI Alpine.js)
     │    ├── /concat/v1/* → REST API (registry ala register_rest_route)
     │    └── /uploads/*   → file di CC_DATA_DIR/uploads
     └── php app/server/worker.php  (reap + claim cc_jobs 'queued')
          → pipeline inc/* → ffmpeg/yt-dlp di app/bin → JSON-RPC ke Studio Inspirasi
```

- `app/server/compat.php` — shim WP-API: `WP_Error`, `$wpdb`→PDO-SQLite,
  options/transients (`cc_options`), REST registry + `WP_REST_Request`,
  `wp_remote_*`→curl, sanitize/esc, hooks, auth stubs, `wp_salt`→secret file.
- `app/server/bootstrap.php` — `CC_DATA_DIR`, secret-derived salts, buka `app.db`,
  require 12 `inc/*`, `do_action('init')` + `do_action('rest_api_init')`,
  watchdog `cc_sidecar_watchdog` (sidecar mati sendiri bila orphaned).
- `app/server/router.php` — front controller `php -S` (normalisasi `//`,
  static passthrough, REST dispatch).
- `app/server/worker.php` — daemon job: settle timed-out jobs + claim queue.

## Struktur repo

```
app/            kode PHP — inc/ (pipeline), server/, public/ (UI+vendor), views/, bin/
sidecar/php     PHP 8.3.36 static x86_64 (17 MB, hanya link libSystem)
src-tauri/      shell Rust: spawn/monitor sidecar, window, ikon
tools/          build-php.sh (static build via spc), dev.sh, smoke.sh/php
logs/           catatan perubahan per tanggal
```

## Build dari source

Butuh: macOS, Rust stable, Node **22** (jangan 24+), Xcode CLT.

```bash
npm install
npm run tauri dev          # dev mode (PHP fallback: LocalWP bila sidecar/php kosong)
npm run tauri build        # → .app + .dmg di src-tauri/target/release/bundle/
```

Utility:

```bash
tools/dev.sh               # php -S di :8788 + worker (uji di browser, tanpa Tauri)
tools/smoke.sh             # smoke test shim/DB → ALL OK
tools/build-php.sh         # rebuild static PHP via StaticPHP (~40 mnt pertama)
npx tauri icon app-icon.png -o src-tauri/icons   # regenerate ikon
```

## Keterbatasan

- **x86_64 saja** — binary ffmpeg/yt-dlp/PHP semuanya Intel; Apple Silicon
  belum diuji (universal build = arm64 static PHP + arm64 media binaries + `lipo`).
- App unsigned — belum ada Developer ID / notarisasi.
- Butuh Studio Inspirasi berjalan dengan Automation aktif untuk pipeline nyata.

## Binary

`app/bin/yt-dlp` (public domain) dan `app/bin/ffmpeg` (GPL — static build
martin-riedl.de). `sidecar/php` dibangun via
[static-php-cli](https://github.com/crazywhalecc/static-php-cli).

## Lisensi

GPL-3.0 — mewarisi lisensi theme sumber `studio-inspirasi-chat`
(Copyright © 2026 Studio Inspirasi).

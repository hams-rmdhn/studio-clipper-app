# 2026-11-13 — Ikon baru + rewrite landing page (v0.1.1)

## Ikon
- `app-icon.png` diganti dengan ikon clapperboard teal baru
  (`~/Downloads/studio-clipper-icon.png`, 512×499 → di-pad transparan ke
  512×512 via NSBitmapImageRep agar tidak distorsi).
- `npx tauri icon app-icon.png` — seluruh set `src-tauri/icons/` diregenerate
  (icns 140 KB, termasuk android/ios/Square*).
- `docs/icon.png` diperbarui ke ikon baru.

## Landing page (`docs/index.html`)
- Semua referensi WordPress/port theme dihapus — halaman sekarang fokus ke
  fitur & use case.
- Hero: "Kontrol penuh Studio Inspirasi dari satu dashboard."
- Seksi fitur dipertahankan (pipeline, multi-segmen/AI Moments, YouTube,
  library, processes, offline & privat).
- Seksi baru "Buat apa saja dengan Studio Clipper?": klip dakwah/podcast,
  repurposing YouTube, produksi batch dari template, kurasi aset.
- Stack section: deskripsi kartu SQLite diubah (tidak lagi menyebut shim WP-API).
- Versi di tag hero & nama DMG instalasi → 0.1.1.

## Versi & build
- Bump 0.1.0 → 0.1.1 di `package.json`, `Cargo.toml`, `tauri.conf.json`
  (+ `Cargo.lock`).
- `npm run tauri build` → `Studio Clipper_0.1.1_x64.dmg` (77 MiB).
  Bundling sempat gagal sekali ("Resource busy" — stale interstitial DMG);
  beres setelah `hdiutil detach` lalu build ulang.
- Diverifikasi: `icon.icns` di dalam DMG = ikon baru (md5 cocok),
  `CFBundleShortVersionString` = 0.1.1, resources `app/` + `sidecar/` ter-bundle.

#!/usr/bin/env bash
# Build static PHP CLI untuk sidecar bundle → sidecar/php
# Butuh tools/spc (StaticPHP v3) + toolchain (jalankan `tools/spc doctor` dulu).
# x86_64 saja — build arm64 di Mac Apple Silicon, lalu lipo untuk universal.
set -euo pipefail
cd "$(dirname "$0")"

EXTS="curl,dom,mbstring,openssl,pdo_sqlite,posix,sqlite3,tokenizer,xml,xmlreader,xmlwriter,zlib"
./spc build "$EXTS" --build-cli --dl-with-php=8.3 --dl-prefer-binary "$@"

cd ..
mkdir -p sidecar
cp tools/buildroot/bin/php sidecar/php
chmod +x sidecar/php
echo "→ sidecar/php"
sidecar/php -v | head -2

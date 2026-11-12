#!/usr/bin/env bash
# Dev run — php -S + worker without Tauri (browser at localhost:8788).
set -euo pipefail
cd "$(dirname "$0")/.."

PHP_BIN="${CC_PHP_BIN:-}"
if [ -z "$PHP_BIN" ] && [ -x sidecar/php ]; then
  PHP_BIN="sidecar/php"
fi
if [ -z "$PHP_BIN" ]; then
  PHP_BIN=$(ls -d "$HOME/Library/Application Support/Local/lightning-services/php-"*/bin/darwin/bin/php 2>/dev/null | sort | tail -1)
fi
if [ -z "$PHP_BIN" ]; then
  echo "PHP tidak ditemukan — set CC_PHP_BIN." >&2
  exit 1
fi

export CC_DATA_DIR="${CC_DATA_DIR:-/tmp/studioclipper-dev}"
mkdir -p "$CC_DATA_DIR/logs"

"$PHP_BIN" app/server/worker.php &
WORKER_PID=$!
trap 'kill -TERM "$WORKER_PID" 2>/dev/null; wait "$WORKER_PID" 2>/dev/null' EXIT

echo "PHP    : $PHP_BIN"
echo "Data   : $CC_DATA_DIR"
echo "Server : http://127.0.0.1:8788"
exec "$PHP_BIN" -S 127.0.0.1:8788 -t app/public app/server/router.php

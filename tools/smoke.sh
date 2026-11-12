#!/usr/bin/env bash
# Smoke test shim + DB layer.
set -euo pipefail
cd "$(dirname "$0")/.."
PHP_BIN="${CC_PHP_BIN:-}"
if [ -z "$PHP_BIN" ] && [ -x sidecar/php ]; then
  PHP_BIN="sidecar/php"
fi
if [ -z "$PHP_BIN" ]; then
  PHP_BIN=$(ls -d "$HOME/Library/Application Support/Local/lightning-services/php-"*/bin/darwin/bin/php 2>/dev/null | sort | tail -1)
fi
exec "$PHP_BIN" tools/smoke.php

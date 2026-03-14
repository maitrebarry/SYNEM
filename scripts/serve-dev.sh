#!/usr/bin/env bash
set -euo pipefail

# Dev server for SYNEM with larger upload limits.
# Why: `php artisan serve` uses the CLI php.ini (often upload_max_filesize=2M, post_max_size=8M).
# This script overrides those limits without requiring sudo.

# Always run from the project root (so ./artisan is found even if invoked from another directory)
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_DIR"

HOST="${HOST:-127.0.0.1}"
PORT="${PORT:-8000}"

port_in_use(){
  local port="$1"
  if command -v ss >/dev/null 2>&1; then
    ss -ltn 2>/dev/null | awk '{print $4}' | grep -E "[:\.]${port}$" -q
    return $?
  fi
  if command -v lsof >/dev/null 2>&1; then
    lsof -iTCP:"$port" -sTCP:LISTEN -t >/dev/null 2>&1
    return $?
  fi
  # No tool available; assume free.
  return 1
}

if port_in_use "$PORT"; then
  echo "Error: Failed to listen on $HOST:$PORT (Address already in use)." >&2
  echo "Try one of these:" >&2
  echo "  - Use another port: PORT=8001 $0" >&2
  echo "  - Find & stop the process: ss -ltnp | grep :$PORT" >&2
  echo "    (or) lsof -iTCP:$PORT -sTCP:LISTEN" >&2
  exit 1
fi

# Prefer XAMPP PHP when available (same env as Apache), else fall back to system PHP.
DEFAULT_PHP="php"
if [ -x "/opt/lampp/bin/php" ]; then
  DEFAULT_PHP="/opt/lampp/bin/php"
elif command -v php8.3 >/dev/null 2>&1; then
  DEFAULT_PHP="php8.3"
fi

PHP_BIN="${PHP_BIN:-$DEFAULT_PHP}"

exec "$PHP_BIN" \
  -d upload_max_filesize=128M \
  -d post_max_size=128M \
  -d max_file_uploads=50 \
  -d max_execution_time=300 \
  -d max_input_time=300 \
  ./artisan serve --host="$HOST" --port="$PORT"


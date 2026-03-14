#!/usr/bin/env bash
set -euo pipefail

# Convenience wrapper so you can run from project root:
#   ./serve-dev.sh
# It delegates to the real script in ./scripts.

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
exec bash "$SCRIPT_DIR/scripts/serve-dev.sh" "$@"

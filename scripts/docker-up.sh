#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
docker compose --profile operator up -d
echo "Ready: http://laravel-tenant-kit.test:8080/login"

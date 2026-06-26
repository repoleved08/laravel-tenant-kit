#!/usr/bin/env bash
# =============================================================================
# Laravel Tenant Kit — Docker (Linux/macOS)
#
# First time:  ./scripts/docker-setup.sh
# Daily:       ./scripts/docker-up.sh
# After JS:    npm run build
# Stop:        docker compose down
#
# Hosts: 127.0.0.1 laravel-tenant-kit.test demo.laravel-tenant-kit.test
# Login: admin@laravel-tenant-kit.test / password
# URL:   http://laravel-tenant-kit.test:8080
# =============================================================================
set -euo pipefail
cd "$(dirname "$0")/.."

echo "Starting Docker stack (+ api-operator)..."
docker compose --profile operator up -d --build

echo "Preparing .env..."
docker compose exec -T app cp .env.docker .env
docker compose exec -T app php artisan key:generate --force

echo "Running migrations & seed..."
docker compose exec -T app php artisan migrate --seed --force

echo "Building frontend assets..."
docker compose --profile build run --rm node

echo "Clearing caches..."
docker compose exec -T app php artisan view:clear
docker compose exec -T app php artisan config:clear

echo ""
echo "Done!"
echo "  Central:  http://laravel-tenant-kit.test:8080/login"
echo "  Admin:    http://laravel-tenant-kit.test:8080/admin"
echo "  Operator: http://127.0.0.1:8100/health"
echo ""
echo "Login: admin@laravel-tenant-kit.test / password"
echo "Daily: ./scripts/docker-up.sh"

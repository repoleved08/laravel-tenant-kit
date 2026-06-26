# =============================================================================
# Laravel Tenant Kit — Docker (Windows)
#
# ▶ أول مرة (setup كامل):
#     .\scripts\docker-setup.ps1
#
# ▶ كل يوم (تشغيل):
#     .\scripts\docker-up.ps1
#     — أو: docker compose --profile operator up -d
#
# ▶ بعد تعديل JS/CSS:
#     npm run build
#
# ▶ إيقاف:
#     docker compose down
#
# Hosts (C:\Windows\System32\drivers\etc\hosts):
#   127.0.0.1 laravel-tenant-kit.test
#   127.0.0.1 demo.laravel-tenant-kit.test
#
# الدخول: admin@laravel-tenant-kit.test / password
# الموقع: http://laravel-tenant-kit.test:8080
# الشات:  /dashboard أو /admin (زر أسفل يمين الصفحة)
# =============================================================================

$ErrorActionPreference = "Stop"
$Root = Split-Path $PSScriptRoot -Parent
Set-Location $Root

Write-Host "Starting Docker stack (+ api-operator)..." -ForegroundColor Cyan
docker compose --profile operator up -d --build

Write-Host "Preparing .env..." -ForegroundColor Cyan
docker compose exec -T app cp .env.docker .env
docker compose exec -T app php artisan key:generate --force

Write-Host "Running migrations & seed..." -ForegroundColor Cyan
docker compose exec -T app php artisan migrate --seed --force

Write-Host "Building frontend assets..." -ForegroundColor Cyan
docker compose --profile build run --rm node

Write-Host "Clearing caches..." -ForegroundColor Cyan
docker compose exec -T app php artisan view:clear
docker compose exec -T app php artisan config:clear

Write-Host ""
Write-Host "Done!" -ForegroundColor Green
Write-Host "  Central:  http://laravel-tenant-kit.test:8080/login" -ForegroundColor Green
Write-Host "  Admin:    http://laravel-tenant-kit.test:8080/admin" -ForegroundColor Green
Write-Host "  Demo:     http://demo.laravel-tenant-kit.test:8080/login" -ForegroundColor Green
Write-Host "  Operator: http://127.0.0.1:8100/health" -ForegroundColor Green
Write-Host ""
Write-Host "Login: admin@laravel-tenant-kit.test / password" -ForegroundColor Yellow
Write-Host "Daily: .\scripts\docker-up.ps1" -ForegroundColor Yellow

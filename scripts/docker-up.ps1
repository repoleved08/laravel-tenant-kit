# تشغيل يومي — Laravel Tenant Kit + api-operator
$ErrorActionPreference = "Stop"
$Root = Split-Path $PSScriptRoot -Parent
Set-Location $Root

if (-not (docker info 2>$null)) {
    Write-Host "Docker Desktop is not running. Start it, wait ~1 min, then run this script again." -ForegroundColor Red
    exit 1
}

Write-Host "Starting stack..." -ForegroundColor Cyan
docker compose --profile operator up -d

$ok = $false
foreach ($i in 1..30) {
    try {
        $code = (curl.exe -s -o NUL -w "%{http_code}" -H "Host: laravel-tenant-kit.test" http://127.0.0.1:8080/login 2>$null)
        if ($code -eq "200") { $ok = $true; break }
    } catch {}
    Start-Sleep -Seconds 2
}

Write-Host ""
if ($ok) {
    Write-Host "Ready!" -ForegroundColor Green
} else {
    Write-Host "Stack started but site not responding yet. Wait 30s and try:" -ForegroundColor Yellow
}
Write-Host "  http://laravel-tenant-kit.test:8080/login" -ForegroundColor Green
Write-Host "  (use :8080 — required if Laragon is not on port 80)" -ForegroundColor Yellow
Write-Host "Login: admin@laravel-tenant-kit.test / password" -ForegroundColor Yellow

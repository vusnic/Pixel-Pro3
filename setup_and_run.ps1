$ErrorActionPreference = "Stop"
$env:Path = "C:\php;C:\ProgramData\ComposerSetup\bin;$env:Path"
Set-Location 'C:\Users\assad\OneDrive\Desktop\Pixel Pro3\Site PXP 3\pixelpro3-main'

function Check-Command {
    param ([string]$Name, [string]$Command)
    if (-not (Get-Command $Command -ErrorAction SilentlyContinue)) {
        Write-Error "❌ $Name is NOT installed or not in PATH.`nPlease follow the instructions in MANUAL_SETUP.md to install it first."
        return $false
    }
    Write-Host "✅ $Name is installed." -ForegroundColor Green
    return $true
}

Write-Host "Checking requirements..." -ForegroundColor Cyan

$php = Check-Command "PHP" "php"
$composer = Check-Command "Composer" "composer"

if (-not $php -or -not $composer) {
    exit 1
}

# 2. Project Setup
Write-Host "`n🚀 Starting Project Setup..." -ForegroundColor Cyan

if (-not (Test-Path ".env")) {
    Write-Host "Creating .env file..."
    Copy-Item ".env.example" ".env"
}

Write-Host "📦 Installing PHP dependencies (Composer)..."
cmd /c "composer install --no-interaction"
if ($LASTEXITCODE -ne 0) { Write-Error "Composer install failed" }

Write-Host "🔑 Generating App Key..."
cmd /c "php artisan key:generate"

Write-Host "📦 Installing Node dependencies..."
cmd /c "npm install"

# 3. Run Servers
Write-Host "`n🌐 Starting servers..." -ForegroundColor PageUp
Write-Host "----------------------------------------------"
Write-Host "Local Site: http://localhost:8000" -ForegroundColor Green
Write-Host "----------------------------------------------"

# Start Laravel Serve in background
$laravelJob = Start-Job -ScriptBlock { cmd /c "php artisan serve" }

# Start Vite
cmd /c "npm run dev"

# Cleanup jobs on exit
Receive-Job $laravelJob
Stop-Job $laravelJob

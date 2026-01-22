$ErrorActionPreference = "Stop"

Write-Host "Attempting to install Scoop..."
try {
    Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
    [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
    Invoke-RestMethod -Uri https://get.scoop.sh | Invoke-Expression
}
catch {
    Write-Warning "Scoop install failed: $_"
}

# Reload Env
$env:Path = [System.Environment]::GetEnvironmentVariable("Path", "User") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "Machine")

if (Get-Command scoop -ErrorAction SilentlyContinue) {
    Write-Host "Scoop installed. Installing PHP and Composer..."
    scoop bucket add extras
    scoop install php composer
    
    # Reload Env again
    $env:Path = [System.Environment]::GetEnvironmentVariable("Path", "User") + ";" + [System.Environment]::GetEnvironmentVariable("Path", "Machine")
    
    if ((Get-Command php -ErrorAction SilentlyContinue) -and (Get-Command composer -ErrorAction SilentlyContinue)) {
        Write-Host "SUCCESS: PHP and Composer installed." -ForegroundColor Green
        exit 0
    }
}

Write-Error "Failed to install tools via Scoop."
exit 1

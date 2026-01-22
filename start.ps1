$env:Path = "C:\php;C:\ProgramData\ComposerSetup\bin;$env:Path"
Set-Location 'C:\Users\assad\OneDrive\Desktop\Pixel Pro3\Site PXP 3\pixelpro3-main'

Write-Host "Iniciando servidores em novas janelas..." -ForegroundColor Cyan

# Start Backend (Laravel) in a new window
Start-Process powershell -ArgumentList "-NoExit", "-Command", "`$env:Path='C:\php;'+`$env:Path; `$env:PHPRC='C:\php'; cd 'C:\Users\assad\OneDrive\Desktop\Pixel Pro3\Site PXP 3\pixelpro3-main'; php -d extension_dir='C:\php\ext' artisan serve"

# Start Frontend (Vite) in a new window
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd 'C:\Users\assad\OneDrive\Desktop\Pixel Pro3\Site PXP 3\pixelpro3-main'; npm run dev"

Write-Host "✅ Servidores iniciados!" -ForegroundColor Green
Write-Host "Aguarde as janelas abrirem e acesse: http://localhost:8000"
Start-Sleep -Seconds 5

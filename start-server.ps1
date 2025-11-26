# Start PHP built-in web server from this project directory
# Usage: Right-click -> Run with PowerShell, or from PowerShell: .\start-server.ps1

# Try to find a php executable. Prefer php in PATH, fallback to XAMPP's php.exe if present.
$phpCmd = $null
try {
    $phpCmd = (Get-Command php -ErrorAction Stop).Source
} catch {
    # Not in PATH, try common XAMPP location
    $xamppPhp = "C:\\xampp\\php\\php.exe"
    if (Test-Path $xamppPhp) {
        $phpCmd = $xamppPhp
    }
}

if (-not $phpCmd) {
    Write-Host "PHP executable not found. Please install PHP, add it to PATH, or install XAMPP." -ForegroundColor Yellow
    Write-Host "If you have XAMPP installed, ensure C:\\xampp\\php\\php.exe exists or start Apache from XAMPP Control Panel." -ForegroundColor Yellow
    pause
    exit 1
}

# Ask for port or default to 8000
$port = Read-Host -Prompt 'Enter port to serve on (press Enter for 8000)'
if ([string]::IsNullOrWhiteSpace($port)) { $port = '8000' }

# Basic port availability check
try {
    $inUse = (& netstat -ano -p tcp) -match ":$port\s"
} catch {
    $inUse = $false
}
if ($inUse) {
    Write-Host "Warning: port $port appears in use. You may need to choose a different port or stop the process using it." -ForegroundColor Yellow
}

Push-Location $PSScriptRoot
Write-Host "Using PHP: $phpCmd" -ForegroundColor Cyan
Write-Host "Serving project at http://localhost:$port (Ctrl+C to stop)" -ForegroundColor Green
& $phpCmd -S "localhost:$port"
Pop-Location

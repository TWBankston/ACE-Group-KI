# ACE Group KI Fast Deployment Script (SCP with compression)
# Much faster than SFTP batch mode

param(
    [string]$ConfigFile = "deploy-config.local.json",
    [switch]$ThemeOnly,
    [switch]$PluginOnly,
    [switch]$Build
)

# Load configuration
if (-not (Test-Path $ConfigFile)) {
    Write-Host "Error: Configuration file not found: $ConfigFile" -ForegroundColor Red
    exit 1
}

$config = Get-Content $ConfigFile | ConvertFrom-Json
$projectRoot = (Get-Location).Path

$keyPath = $config.sshKeyPath
$remoteHost = "$($config.username)@$($config.host)"
$port = $config.port
$remotePath = $config.remotePath

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  ACE Group KI Fast Deploy (SCP)" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Server: $($config.host):$port" -ForegroundColor Gray
Write-Host ""

$startTime = Get-Date

# Build assets if requested
if ($Build) {
    Write-Host "[Build] Compiling assets with Vite..." -ForegroundColor Yellow
    Push-Location "$projectRoot\wp-content\themes\acegroupki"
    npm run build
    Pop-Location
    Write-Host ""
}

# Determine what to deploy
$deployTheme = -not $PluginOnly
$deployPlugins = -not $ThemeOnly

# Deploy theme
if ($deployTheme) {
    $themeLocal = "$projectRoot\wp-content\themes\acegroupki"
    $themeRemote = "${remoteHost}:${remotePath}/themes/acegroupki/"
    
    Write-Host "[Theme] Uploading acegroupki..." -ForegroundColor Cyan
    
    # Upload compiled dist folder
    Write-Host "  - dist/ (compiled assets)" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C -r "$themeLocal\dist\*" "$themeRemote/dist/"
    
    # Upload PHP files
    Write-Host "  - PHP files" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C "$themeLocal\*.php" $themeRemote
    scp -P $port -i $keyPath -C "$themeLocal\*.css" $themeRemote
    scp -P $port -i $keyPath -C "$themeLocal\*.json" $themeRemote
    scp -P $port -i $keyPath -C "$themeLocal\*.png" $themeRemote 2>$null
    
    # Upload template directories
    Write-Host "  - templates/" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C -r "$themeLocal\templates" $themeRemote
    
    Write-Host "  - template-parts/" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C -r "$themeLocal\template-parts" $themeRemote
    
    Write-Host "  - patterns/" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C -r "$themeLocal\patterns" $themeRemote
    
    Write-Host "  - assets/" -ForegroundColor DarkGray
    scp -P $port -i $keyPath -C -r "$themeLocal\assets" $themeRemote
    
    if (Test-Path "$themeLocal\blocks") {
        Write-Host "  - blocks/" -ForegroundColor DarkGray
        scp -P $port -i $keyPath -C -r "$themeLocal\blocks" $themeRemote
    }
    
    Write-Host "  Done!" -ForegroundColor Green
}

# Deploy plugins
if ($deployPlugins) {
    $plugins = @("acegroupki-core", "acegroupki-forms")
    
    foreach ($plugin in $plugins) {
        $pluginLocal = "$projectRoot\wp-content\plugins\$plugin"
        $pluginRemote = "${remoteHost}:${remotePath}/plugins/$plugin/"
        
        if (-not (Test-Path $pluginLocal)) {
            Write-Host "[Plugin] $plugin - skipped (not found)" -ForegroundColor Yellow
            continue
        }
        
        Write-Host "[Plugin] Uploading $plugin..." -ForegroundColor Cyan
        scp -P $port -i $keyPath -C -r "$pluginLocal\*" $pluginRemote
        Write-Host "  Done!" -ForegroundColor Green
    }
}

$endTime = Get-Date
$duration = $endTime - $startTime

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  DEPLOYMENT COMPLETE" -ForegroundColor Green
Write-Host "  Duration: $($duration.TotalSeconds.ToString('0.0'))s" -ForegroundColor Gray
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Commit changes
Write-Host "Git status:" -ForegroundColor Yellow
git status --short


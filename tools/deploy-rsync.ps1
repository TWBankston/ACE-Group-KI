# ACE Group KI Fast Deployment Script (rsync over SSH)
# Much faster than SFTP - only syncs changed files

param(
    [string]$ConfigFile = "deploy-config.local.json",
    [switch]$ThemeOnly,
    [switch]$PluginOnly,
    [switch]$DryRun
)

# Load configuration
if (-not (Test-Path $ConfigFile)) {
    Write-Host "Error: Configuration file not found: $ConfigFile" -ForegroundColor Red
    exit 1
}

$config = Get-Content $ConfigFile | ConvertFrom-Json

$host_addr = $config.host
$port = $config.port
$username = $config.username
$remotePath = $config.remotePath
$sshKeyPath = $config.sshKeyPath

# Get project root
$projectRoot = (Get-Location).Path

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  ACE Group KI Fast Deploy (rsync)" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Common rsync options
$rsyncOpts = @(
    "-avz",           # Archive mode, verbose, compress
    "--progress",     # Show progress
    "--delete",       # Delete files on remote that don't exist locally
    "-e", "`"ssh -p $port -i '$sshKeyPath'`""
)

if ($DryRun) {
    $rsyncOpts += "--dry-run"
    Write-Host "DRY RUN MODE - No files will be transferred" -ForegroundColor Yellow
    Write-Host ""
}

# Determine what to deploy
$deployTheme = -not $PluginOnly
$deployPlugins = -not $ThemeOnly

$startTime = Get-Date

# Deploy theme
if ($deployTheme) {
    Write-Host "[Theme] Syncing acegroupki..." -ForegroundColor Cyan
    
    $themeLocal = "$projectRoot/wp-content/themes/acegroupki/"
    $themeRemote = "${username}@${host_addr}:${remotePath}/themes/acegroupki/"
    
    # Exclude node_modules and source maps
    $excludes = @(
        "--exclude=node_modules",
        "--exclude=.git",
        "--exclude=*.map"
    )
    
    $cmd = "rsync $($rsyncOpts -join ' ') $($excludes -join ' ') `"$themeLocal`" `"$themeRemote`""
    Write-Host "  $cmd" -ForegroundColor DarkGray
    
    # Use wsl rsync or native rsync
    $rsyncPath = Get-Command rsync -ErrorAction SilentlyContinue
    if ($rsyncPath) {
        & rsync @rsyncOpts @excludes "$themeLocal" "$themeRemote"
    } else {
        # Try WSL
        $wslThemeLocal = $themeLocal -replace '\\', '/' -replace '^([A-Za-z]):', '/mnt/$1'.ToLower()
        wsl rsync -avz --progress --delete -e "ssh -p $port -i '$($sshKeyPath -replace '\\', '/' -replace '^([A-Za-z]):', '/mnt/$1'.ToLower())'" --exclude=node_modules --exclude=.git --exclude='*.map' "$wslThemeLocal" "$themeRemote"
    }
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "  Done!" -ForegroundColor Green
    } else {
        Write-Host "  Error during sync" -ForegroundColor Red
    }
}

# Deploy plugins
if ($deployPlugins) {
    $plugins = @("acegroupki-core", "acegroupki-forms")
    
    foreach ($plugin in $plugins) {
        Write-Host "[Plugin] Syncing $plugin..." -ForegroundColor Cyan
        
        $pluginLocal = "$projectRoot/wp-content/plugins/$plugin/"
        $pluginRemote = "${username}@${host_addr}:${remotePath}/plugins/$plugin/"
        
        if (-not (Test-Path $pluginLocal)) {
            Write-Host "  Skipped - not found" -ForegroundColor Yellow
            continue
        }
        
        $rsyncPath = Get-Command rsync -ErrorAction SilentlyContinue
        if ($rsyncPath) {
            & rsync @rsyncOpts "$pluginLocal" "$pluginRemote"
        } else {
            # Try WSL
            $wslPluginLocal = $pluginLocal -replace '\\', '/' -replace '^([A-Za-z]):', '/mnt/$1'.ToLower()
            $wslKeyPath = $sshKeyPath -replace '\\', '/' -replace '^([A-Za-z]):', '/mnt/$1'.ToLower()
            wsl rsync -avz --progress --delete -e "ssh -p $port -i '$wslKeyPath'" "$wslPluginLocal" "$pluginRemote"
        }
        
        if ($LASTEXITCODE -eq 0) {
            Write-Host "  Done!" -ForegroundColor Green
        } else {
            Write-Host "  Error during sync" -ForegroundColor Red
        }
    }
}

$endTime = Get-Date
$duration = $endTime - $startTime

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  DEPLOYMENT COMPLETE" -ForegroundColor Green
Write-Host "  Duration: $($duration.TotalSeconds.ToString('0.0'))s" -ForegroundColor Gray
Write-Host "============================================" -ForegroundColor Cyan


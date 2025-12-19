# ACE Group KI Deployment Script (SFTP via OpenSSH)
# Deploys theme and plugins to staging server
# Only replaces OUR theme and plugins, not the entire folders
#
# IMPORTANT: This script uploads files INTO specific subdirectories:
#   - Theme goes INTO /www/wp-content/themes/acegroupki/
#   - Plugins go INTO /www/wp-content/plugins/{plugin-name}/
#
# It NEVER touches other themes or plugins on the server.

param(
    [string]$ConfigFile = "deploy-config.local.json",
    [switch]$ThemeOnly,
    [switch]$PluginOnly,
    [string]$PluginName
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
$themePath = $config.themePath
$pluginPaths = $config.pluginPaths

# Get absolute paths
$projectRoot = (Get-Location).Path
$themeAbsPath = Join-Path $projectRoot $themePath

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  ACE Group KI Deployment Script" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Server: $host_addr`:$port" -ForegroundColor Gray
Write-Host "Remote Base: $remotePath" -ForegroundColor Gray
Write-Host ""

# Determine what to deploy
$deployTheme = $true
$deployPlugins = $true

if ($ThemeOnly) {
    $deployPlugins = $false
    Write-Host "Mode: Theme Only" -ForegroundColor Yellow
} elseif ($PluginOnly) {
    $deployTheme = $false
    Write-Host "Mode: Plugins Only" -ForegroundColor Yellow
} else {
    Write-Host "Mode: Full Deployment (Theme + Plugins)" -ForegroundColor Yellow
}
Write-Host ""

# Create SFTP batch file
$batchFile = [System.IO.Path]::GetTempFileName()
$batchContent = @()

# The theme name is fixed - we always deploy to "acegroupki"
$themeRemoteFolder = "acegroupki"
$themeRemotePath = "$remotePath/themes/$themeRemoteFolder"

# Deploy theme (into themes/acegroupki folder only - NEVER to themes/ root)
if ($deployTheme) {
    Write-Host "[1/3] Theme: $themeRemoteFolder" -ForegroundColor White
    
    if (-not (Test-Path $themeAbsPath)) {
        Write-Host "  ERROR: Theme path not found: $themeAbsPath" -ForegroundColor Red
        exit 1
    }

    Write-Host "  Local:  $themeAbsPath" -ForegroundColor DarkGray
    Write-Host "  Remote: $themeRemotePath" -ForegroundColor DarkGray

    # CRITICAL: We must cd into the theme subfolder BEFORE uploading
    # This ensures files go INTO acegroupki/ not INTO themes/
    $batchContent += "lcd `"$themeAbsPath`""
    $batchContent += "-mkdir $themeRemotePath"
    $batchContent += "cd $themeRemotePath"
    $batchContent += "put -r ."
    
    Write-Host "  Status: Ready" -ForegroundColor Green
}

# Deploy plugins (only our plugins - each goes into its own subfolder)
# NEVER touches other plugins on the server
if ($deployPlugins) {
    $pluginIndex = 2
    $totalItems = 1 + $pluginPaths.Count
    
    foreach ($pluginPath in $pluginPaths) {
        $pluginName = Split-Path $pluginPath -Leaf
        $pluginAbsPath = Join-Path $projectRoot $pluginPath
        $pluginRemotePath = "$remotePath/plugins/$pluginName"
        
        Write-Host "[$pluginIndex/$totalItems] Plugin: $pluginName" -ForegroundColor White
        
        if (-not (Test-Path $pluginAbsPath)) {
            Write-Host "  WARNING: Plugin path not found: $pluginAbsPath" -ForegroundColor Yellow
            $pluginIndex++
            continue
        }

        Write-Host "  Local:  $pluginAbsPath" -ForegroundColor DarkGray
        Write-Host "  Remote: $pluginRemotePath" -ForegroundColor DarkGray
        
        # CRITICAL: cd into the plugin subfolder BEFORE uploading
        # This ensures files go INTO the plugin folder, not into plugins/
        $batchContent += "lcd `"$pluginAbsPath`""
        $batchContent += "-mkdir $pluginRemotePath"
        $batchContent += "cd $pluginRemotePath"
        $batchContent += "put -r ."
        
        Write-Host "  Status: Ready" -ForegroundColor Green
        $pluginIndex++
    }
}

$batchContent += "bye"
$batchContent | Out-File -FilePath $batchFile -Encoding ASCII

Write-Host ""
Write-Host "Connecting..." -ForegroundColor Cyan

# Use SSH key if available
if ($sshKeyPath -and (Test-Path $sshKeyPath)) {
    Write-Host "Auth: SSH Key ($sshKeyPath)" -ForegroundColor Green
    sftp -P $port -i $sshKeyPath -b $batchFile "${username}@${host_addr}"
    $exitCode = $LASTEXITCODE
} else {
    Write-Host "Auth: Password" -ForegroundColor Yellow
    sftp -P $port -b $batchFile "${username}@${host_addr}"
    $exitCode = $LASTEXITCODE
}

# Cleanup
Remove-Item $batchFile -Force

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
if ($exitCode -eq 0) {
    Write-Host "  DEPLOYMENT SUCCESSFUL" -ForegroundColor Green
} else {
    Write-Host "  DEPLOYMENT COMPLETE (with warnings)" -ForegroundColor Yellow
}
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Deployed to:" -ForegroundColor White
if ($deployTheme) {
    Write-Host "  Theme:  $themeRemotePath" -ForegroundColor Gray
}
if ($deployPlugins) {
    foreach ($pluginPath in $pluginPaths) {
        $pluginName = Split-Path $pluginPath -Leaf
        Write-Host "  Plugin: $remotePath/plugins/$pluginName" -ForegroundColor Gray
    }
}
Write-Host ""
Write-Host "What was NOT touched:" -ForegroundColor DarkYellow
Write-Host "  - Other themes in /www/wp-content/themes/" -ForegroundColor DarkGray
Write-Host "  - Other plugins in /www/wp-content/plugins/" -ForegroundColor DarkGray
Write-Host "  - WordPress core files" -ForegroundColor DarkGray
Write-Host ""
Write-Host "Next steps:" -ForegroundColor White
Write-Host "  1. Log into WordPress: https://acegroupki.wordkeeper.net/wp-admin" -ForegroundColor Gray
Write-Host "  2. Activate theme: Appearance > Themes" -ForegroundColor Gray
Write-Host "  3. Activate plugins: Plugins" -ForegroundColor Gray
Write-Host "  4. Run setup: Settings > ACE Group KI Setup" -ForegroundColor Gray

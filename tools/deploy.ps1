# ACE Group KI Deployment Script
# Deploys theme and plugins to staging server via SFTP

param(
    [string]$ConfigFile = "deploy-config.local.json",
    [switch]$ThemeOnly,
    [switch]$PluginOnly,
    [string]$PluginName
)

# Load configuration
if (-not (Test-Path $ConfigFile)) {
    Write-Host "Error: Configuration file not found: $ConfigFile" -ForegroundColor Red
    Write-Host "Please copy deploy-config.example.json to $ConfigFile and update with your credentials" -ForegroundColor Yellow
    exit 1
}

$config = Get-Content $ConfigFile | ConvertFrom-Json

# Validate required fields
$requiredFields = @("host", "port", "username", "password", "remotePath", "themePath")
foreach ($field in $requiredFields) {
    if (-not $config.$field) {
        Write-Host "Error: Missing required configuration field: $field" -ForegroundColor Red
        exit 1
    }
}

# Install WinSCP .NET assembly if not available
$winscpPath = "$PSScriptRoot\WinSCPnet.dll"
if (-not (Test-Path $winscpPath)) {
    Write-Host "Downloading WinSCP .NET assembly..." -ForegroundColor Yellow
    $winscpUrl = "https://winscp.net/eng/download/WinSCPnet.dll"
    Invoke-WebRequest -Uri $winscpUrl -OutFile $winscpPath
}

# Load WinSCP assembly
Add-Type -Path $winscpPath

# Set up session options
$sessionOptions = New-Object WinSCP.SessionOptions -Property @{
    Protocol = [WinSCP.Protocol]::Sftp
    HostName = $config.host
    PortNumber = $config.port
    UserName = $config.username
    Password = $config.password
    SshHostKeyFingerprint = "ssh-ed25519 255"
}

# Use SSH key if available
if ($config.sshKeyPath -and (Test-Path $config.sshKeyPath)) {
    $sessionOptions.SshPrivateKeyPath = $config.sshKeyPath
    $sessionOptions.Password = $null
    Write-Host "Using SSH key authentication" -ForegroundColor Green
} else {
    Write-Host "Using password authentication" -ForegroundColor Yellow
}

try {
    # Create session
    $session = New-Object WinSCP.Session
    
    Write-Host "Connecting to $($config.host):$($config.port)..." -ForegroundColor Cyan
    $session.Open($sessionOptions)
    Write-Host "Connected successfully!" -ForegroundColor Green
    
    # Determine what to deploy
    $deployTheme = $false
    $deployPlugins = @()
    
    if ($ThemeOnly) {
        $deployTheme = $true
    } elseif ($PluginOnly) {
        if ($PluginName) {
            $deployPlugins = @("wp-content/plugins/$PluginName")
        } else {
            $deployPlugins = $config.pluginPaths
        }
    } else {
        # Deploy everything
        $deployTheme = $true
        $deployPlugins = $config.pluginPaths
    }
    
    # Deploy theme
    if ($deployTheme) {
        $themeLocalPath = $config.themePath
        $themeRemotePath = "$($config.remotePath)/themes/acegroupki"
        
        if (-not (Test-Path $themeLocalPath)) {
            Write-Host "Error: Theme path not found: $themeLocalPath" -ForegroundColor Red
            exit 1
        }
        
        Write-Host "`nDeploying theme..." -ForegroundColor Cyan
        Write-Host "  Local:  $themeLocalPath" -ForegroundColor Gray
        Write-Host "  Remote: $themeRemotePath" -ForegroundColor Gray
        
        # Remove old theme directory
        $session.RemoveFiles($themeRemotePath).Check()
        
        # Upload theme with transfer options (file permissions)
        $transferOptions = New-Object WinSCP.TransferOptions
        $transferOptions.FilePermissions = New-Object WinSCP.FilePermissions
        $transferOptions.FilePermissions.Octal = "0644"
        $transferOptions.DirectoryPermissions = New-Object WinSCP.FilePermissions
        $transferOptions.DirectoryPermissions.Octal = "0755"
        
        $session.PutFiles($themeLocalPath, $themeRemotePath, $False, $transferOptions).Check()
        Write-Host "Theme deployed successfully!" -ForegroundColor Green
    }
    
    # Deploy plugins
    foreach ($pluginPath in $deployPlugins) {
        $pluginName = Split-Path $pluginPath -Leaf
        $pluginLocalPath = $pluginPath
        $pluginRemotePath = "$($config.remotePath)/plugins/$pluginName"
        
        if (-not (Test-Path $pluginLocalPath)) {
            Write-Host "Warning: Plugin path not found: $pluginLocalPath" -ForegroundColor Yellow
            continue
        }
        
        Write-Host "`nDeploying plugin: $pluginName..." -ForegroundColor Cyan
        Write-Host "  Local:  $pluginLocalPath" -ForegroundColor Gray
        Write-Host "  Remote: $pluginRemotePath" -ForegroundColor Gray
        
        # Remove old plugin directory
        $session.RemoveFiles($pluginRemotePath).Check()
        
        # Upload plugin with transfer options
        $transferOptions = New-Object WinSCP.TransferOptions
        $transferOptions.FilePermissions = New-Object WinSCP.FilePermissions
        $transferOptions.FilePermissions.Octal = "0644"
        $transferOptions.DirectoryPermissions = New-Object WinSCP.FilePermissions
        $transferOptions.DirectoryPermissions.Octal = "0755"
        
        $session.PutFiles($pluginLocalPath, $pluginRemotePath, $False, $transferOptions).Check()
        Write-Host "Plugin $pluginName deployed successfully!" -ForegroundColor Green
    }
    
    Write-Host "`nDeployment completed successfully!" -ForegroundColor Green
    
} catch {
    Write-Host "`nError: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
} finally {
    if ($session) {
        $session.Dispose()
    }
}


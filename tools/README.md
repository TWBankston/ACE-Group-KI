# Deployment Tools

This directory contains deployment scripts for the ACE Group KI WordPress theme.

## Files

- `deploy.ps1` - PowerShell deployment script for Windows
- `deploy.sh` - Bash deployment script for Linux/Mac
- `README.md` - This file

## Quick Start

### Windows

1. Create local config file:
   ```powershell
   Copy-Item ..\deploy-config.example.json ..\deploy-config.local.json
   ```

2. Edit `deploy-config.local.json` with your credentials

3. Build assets:
   ```powershell
   cd ..\wp-content\themes\acegroupki
   npm run build
   cd ..\..\..
   ```

4. Deploy:
   ```powershell
   .\tools\deploy.ps1
   ```

### Linux/Mac

1. Create local config file:
   ```bash
   cp ../deploy-config.example.json ../deploy-config.local.json
   ```

2. Edit `deploy-config.local.json` with your credentials

3. Build assets:
   ```bash
   cd ../wp-content/themes/acegroupki
   npm run build
   cd ../../..
   ```

4. Deploy:
   ```bash
   chmod +x tools/deploy.sh
   ./tools/deploy.sh
   ```

## Deployment Options

### Deploy Everything (Default)
```powershell
.\tools\deploy.ps1
```

### Deploy Theme Only
```powershell
.\tools\deploy.ps1 -ThemeOnly
```

### Deploy Plugins Only
```powershell
.\tools\deploy.ps1 -PluginOnly
```

### Deploy Specific Plugin
```powershell
.\tools\deploy.ps1 -PluginOnly -PluginName acegroupki-core
```

## Requirements

### Windows
- PowerShell 5.1+ or PowerShell 7+
- WinSCP .NET assembly (downloaded automatically)

### Linux/Mac
- `lftp` package
- `jq` package

## Security

- Never commit `deploy-config.local.json` to git
- Credentials are stored locally only
- Use SSH keys when possible
- Rotate credentials regularly

## Troubleshooting

See `../docs/deployment-guide.md` for detailed troubleshooting information.


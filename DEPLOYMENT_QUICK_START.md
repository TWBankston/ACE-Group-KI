# Deployment Quick Start Guide

## Prerequisites

1. **Build assets before deploying:**
   ```powershell
   cd wp-content/themes/acegroupki
   npm run build
   cd ../../..
   ```

## Windows Deployment (PowerShell)

### First Time Setup

1. The `deploy-config.local.json` file already exists with your credentials (gitignored)

2. Run deployment:
   ```powershell
   .\tools\deploy.ps1
   ```

### Deployment Options

**Deploy everything (theme + plugins):**
```powershell
.\tools\deploy.ps1
```

**Deploy theme only:**
```powershell
.\tools\deploy.ps1 -ThemeOnly
```

**Deploy plugins only:**
```powershell
.\tools\deploy.ps1 -PluginOnly
```

**Deploy specific plugin:**
```powershell
.\tools\deploy.ps1 -PluginOnly -PluginName acegroupki-core
```

## What Gets Deployed

- **Theme:** `wp-content/themes/acegroupki` → `/www/wp-content/themes/acegroupki`
- **Plugins:**
  - `wp-content/plugins/acegroupki-core` → `/www/wp-content/plugins/acegroupki-core`
  - `wp-content/plugins/acegroupki-forms` → `/www/wp-content/plugins/acegroupki-forms`

## File Permissions

The deployment script automatically sets:
- **Directories:** 755
- **Files:** 644

## Server Information

- **Host:** 172.233.152.148
- **Port:** 2222
- **Protocol:** SFTP
- **Remote Path:** `/www/wp-content`

## Security

✅ Credentials are stored in `deploy-config.local.json` (gitignored)  
✅ Never committed to git  
✅ Never pushed to GitHub  
✅ Never uploaded to server

## Troubleshooting

See `docs/deployment-guide.md` for detailed troubleshooting.

## Post-Deployment

After deployment:
1. Log into WordPress admin: https://acegroupki.wordkeeper.net/wp-admin
2. Activate theme (if not already active)
3. Activate plugins (if not already active)
4. Test site functionality


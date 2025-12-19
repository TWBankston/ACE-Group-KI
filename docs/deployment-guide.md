# Deployment Guide - ACE Group KI

## Overview

This guide covers deploying the ACE Group KI WordPress theme and plugins to the staging server at `acegroupki.wordkeeper.net`.

**Important Security Notes:**
- Never commit credentials to git
- Never push credentials to the server
- Always use secure authentication methods
- Keep credentials in local files that are gitignored

## Server Information

- **Host:** 172.233.152.148
- **Port:** 2222
- **Protocol:** SFTP Only
- **Remote Path:** `/www/wp-content`
- **SSH Key:** `C:\Users\Tyler\.ssh\acegroupki_website_ed25519` (Windows)

## Prerequisites

### Windows
- PowerShell 5.1+ or PowerShell 7+
- WinSCP .NET assembly (will be downloaded automatically)

### Linux/Mac
- `lftp` package
- `jq` package (for JSON parsing)
- SSH key configured (optional, can use password)

## Setup

### 1. Create Local Configuration File

Copy the example configuration file:

```bash
# Windows PowerShell
Copy-Item deploy-config.example.json deploy-config.local.json

# Linux/Mac
cp deploy-config.example.json deploy-config.local.json
```

### 2. Update Configuration

Edit `deploy-config.local.json` with your credentials:

```json
{
  "host": "172.233.152.148",
  "port": 2222,
  "username": "staging_acegroupki",
  "password": "yQF6OeORfCvgbN6M",
  "remotePath": "/www/wp-content",
  "sshKeyPath": "C:\\Users\\Tyler\\.ssh\\acegroupki_website_ed25519",
  "themePath": "wp-content/themes/acegroupki",
  "pluginPaths": [
    "wp-content/plugins/acegroupki-core",
    "wp-content/plugins/acegroupki-forms"
  ]
}
```

**Note:** The `deploy-config.local.json` file is gitignored and will never be committed.

### 3. Build Assets (Before Deployment)

Always build production assets before deploying:

```bash
cd wp-content/themes/acegroupki
npm run build
cd ../../..
```

## Deployment Methods

### Method 1: PowerShell Script (Windows)

Deploy everything (theme + plugins):
```powershell
.\tools\deploy.ps1
```

Deploy theme only:
```powershell
.\tools\deploy.ps1 -ThemeOnly
```

Deploy plugins only:
```powershell
.\tools\deploy.ps1 -PluginOnly
```

Deploy specific plugin:
```powershell
.\tools\deploy.ps1 -PluginOnly -PluginName acegroupki-core
```

### Method 2: Bash Script (Linux/Mac)

Deploy everything:
```bash
chmod +x tools/deploy.sh
./tools/deploy.sh
```

Deploy theme only:
```bash
./tools/deploy.sh deploy-config.local.json true false
```

Deploy plugins only:
```bash
./tools/deploy.sh deploy-config.local.json false true
```

### Method 3: Manual SFTP (Any Platform)

Using WinSCP (Windows) or FileZilla (Cross-platform):

1. **Connect to server:**
   - Host: `172.233.152.148`
   - Port: `2222`
   - Username: `staging_acegroupki`
   - Password: `yQF6OeORfCvgbN6M`
   - Protocol: SFTP

2. **Deploy Theme:**
   - Navigate to `/www/wp-content/themes/`
   - Delete existing `acegroupki` folder (if exists)
   - Upload `wp-content/themes/acegroupki` folder
   - Set permissions: `755` for directories, `644` for files

3. **Deploy Plugins:**
   - Navigate to `/www/wp-content/plugins/`
   - Delete existing plugin folders (if exists)
   - Upload each plugin folder:
     - `wp-content/plugins/acegroupki-core`
     - `wp-content/plugins/acegroupki-forms`
   - Set permissions: `755` for directories, `644` for files

## File Permissions

After deployment, ensure correct permissions:

```bash
# Directories
chmod 755 /www/wp-content/themes/acegroupki
chmod 755 /www/wp-content/plugins/acegroupki-core
chmod 755 /www/wp-content/plugins/acegroupki-forms

# Files
find /www/wp-content/themes/acegroupki -type f -exec chmod 644 {} \;
find /www/wp-content/plugins/acegroupki-core -type f -exec chmod 644 {} \;
find /www/wp-content/plugins/acegroupki-forms -type f -exec chmod 644 {} \;
```

## Post-Deployment Checklist

- [ ] Theme files uploaded to `/www/wp-content/themes/acegroupki`
- [ ] Plugin files uploaded to `/www/wp-content/plugins/`
- [ ] File permissions set correctly (755 for dirs, 644 for files)
- [ ] Theme activated in WordPress admin
- [ ] Plugins activated in WordPress admin
- [ ] Assets built (`dist/` folder exists in theme)
- [ ] Test site functionality
- [ ] Check browser console for errors
- [ ] Verify forms are working
- [ ] Test project filters
- [ ] Check mobile responsiveness

## Troubleshooting

### Connection Issues

**Error: Permission denied**
- Verify credentials in `deploy-config.local.json`
- Check SSH key permissions (if using key auth)
- Ensure port 2222 is not blocked by firewall

**Error: Host key verification failed**
- Add host key to known hosts
- Or use `-oStrictHostKeyChecking=no` (not recommended for production)

### File Permission Issues

If files are not accessible:
```bash
# Fix permissions recursively
find /www/wp-content/themes/acegroupki -type d -exec chmod 755 {} \;
find /www/wp-content/themes/acegroupki -type f -exec chmod 644 {} \;
```

### Missing Assets

If CSS/JS files are not loading:
1. Verify `npm run build` was run before deployment
2. Check that `dist/` folder exists in theme
3. Verify file permissions on `dist/` folder
4. Check WordPress file permissions

## Security Best Practices

1. **Never commit credentials:**
   - `deploy-config.local.json` is gitignored
   - Never add credentials to version control
   - Use environment variables in CI/CD

2. **Use SSH keys when possible:**
   - More secure than passwords
   - Configure in `deploy-config.local.json`

3. **Rotate credentials regularly:**
   - Update passwords periodically
   - Update configuration file when changed

4. **Limit access:**
   - Only deploy from trusted machines
   - Use VPN if possible
   - Monitor deployment logs

## Automated Deployment (Future)

Consider setting up CI/CD with GitHub Actions:

```yaml
# .github/workflows/deploy.yml
name: Deploy to Staging
on:
  push:
    branches: [main]
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Deploy via SFTP
        uses: SamKirkland/FTP-Deploy-Action@4.0.0
        with:
          server: ${{ secrets.DEPLOY_HOST }}
          username: ${{ secrets.DEPLOY_USER }}
          password: ${{ secrets.DEPLOY_PASS }}
          local-dir: ./wp-content/
          server-dir: /www/wp-content/
```

## Database Information (Reference Only)

- **DB URL:** https://db-jacobtyler2.wordkeeper.net/
- **DB Username:** staging_acegroupki
- **DB Password:** ZDZDTZsES0RHUB6x

**Note:** Database credentials are for reference only. Database migrations are handled separately and not part of file deployment.

## WordPress Admin Access

- **URL:** https://acegroupki.wordkeeper.net/wp-admin
- **Username:** acegroupki
- **Password:** R1ptNxd017E0CURI

**Note:** These credentials are for reference only. Never commit them to git.


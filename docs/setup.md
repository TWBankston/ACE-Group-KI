# ACE Group KI WordPress Theme - Setup Guide

## Prerequisites

- WordPress 6.0 or higher
- PHP 8.1 or higher (8.2 recommended)
- MySQL 5.7+ or MariaDB 10.3+
- Node.js LTS (18.x or 20.x)
- npm or yarn

## Local WordPress Installation

This repository contains only the theme and plugins. You'll need a local WordPress installation to develop.

### Option 1: Local by Flywheel / LocalWP

1. Create a new site in LocalWP
2. Point the site's `wp-content` directory to this repository's `wp-content` folder
3. Or copy the theme and plugins to your LocalWP site's `wp-content` directory

### Option 2: Manual Setup

1. Download WordPress from wordpress.org
2. Extract to a local directory (e.g., `C:\local-sites\acegroupki\`)
3. Copy this repository's `wp-content/themes/acegroupki` to `wp-content/themes/`
4. Copy `wp-content/plugins/acegroupki-core` to `wp-content/plugins/`
5. Configure `wp-config.php` with database credentials
6. Run WordPress installation

## Theme Activation

1. Log into WordPress admin
2. Navigate to **Appearance > Themes**
3. Activate **ACE Group KI** theme

## Plugin Activation

1. Navigate to **Plugins**
2. Activate **ACE Group KI Core**

## Build Pipeline Setup

1. Navigate to theme directory:
   ```bash
   cd wp-content/themes/acegroupki
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Start development server (with HMR):
   ```bash
   npm run dev
   ```

4. Build for production:
   ```bash
   npm run build
   ```

## Development Workflow

1. Make changes to files in `src/js/` or `src/scss/`
2. Vite will automatically rebuild and reload (if dev server running)
3. For production, run `npm run build` before deploying

## Page Setup

After activating the theme and plugin:

1. Create pages in WordPress admin:
   - **Home** (assign template: Home)
   - **Services** (assign template: Services)
   - **Projects** (assign template: Projects)
   - **About** (assign template: About)
   - **Contact / Request a Bid** (assign template: Contact / Request a Bid)
   - **Safety & Qualifications** (optional, assign template: Safety & Qualifications)

2. Set **Home** as the front page:
   - Settings > Reading > Static page > Home

3. Create navigation menu:
   - Appearance > Menus
   - Add pages to menu
   - Assign to "Primary Menu" location

## Project CPT Setup

The plugin automatically creates the `project` Custom Post Type with taxonomies:

- **Project Types**: Commercial Construction, Residential Construction & Remodeling, Tenant Improvements, Specialty & Custom Projects
- **Market Types**: Commercial, Residential

To add projects:
1. Navigate to **Projects** in admin menu
2. Add New Project
3. Fill in title, content, featured image
4. Assign project type and market type
5. Add location as custom field: `_project_location`

## Site Settings

Configure site settings:
1. Navigate to **Settings > ACE Group KI**
2. Enter service area, response time, phone, email
3. These values are used in the contact page template

## Troubleshooting

### Assets not loading
- Ensure `npm run build` has been run
- Check that `dist/.vite/manifest.json` exists
- Verify file permissions

### Block patterns not showing
- Ensure patterns are in `patterns/` directory
- Check that pattern category is registered in `functions.php`

### CPT not appearing
- Ensure plugin is activated
- Check for PHP errors in debug log
- Verify plugin files are in correct location


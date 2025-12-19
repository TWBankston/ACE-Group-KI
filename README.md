# ACE Group KI WordPress Theme

Professional WordPress theme and custom plugins for ACE Group KI construction company website.

## Project Structure

- `site-assets/` - Site assets including templates, sitemap, brand assets, and copy
- `wp-content/themes/acegroupki/` - Custom WordPress theme
- `wp-content/plugins/acegroupki-core/` - Core plugin (CPT, taxonomies, site settings)
- `wp-content/plugins/acegroupki-forms/` - Form handling plugin (if needed)
- `docs/` - Documentation (setup, decisions, deployment)

## Tech Stack

- **WordPress:** Modern block editor / theme.json approach
- **PHP:** 8.1+ (target 8.2)
- **Build Tool:** Vite
- **CSS:** SCSS with structured architecture
- **JavaScript:** GSAP, Swiper.js, Alpine.js (as needed)

## Development Setup

See `docs/setup.md` for detailed setup instructions.

### Quick Start

1. Install Node.js dependencies:
   ```bash
   cd wp-content/themes/acegroupki
   npm install
   ```

2. Start development server:
   ```bash
   npm run dev
   ```

3. Build for production:
   ```bash
   npm run build
   ```

## Pages

- **Home:** Hero + Services Snapshot + Credibility + Featured Projects + CTA
- **Services:** Single page listing 4 core services
- **Projects:** Gallery with project cards (Custom Post Type)
- **About:** Company Overview + Experience & Approach + Values
- **Contact / Request a Bid:** Form + Service Area + Response Time Note
- **Safety & Qualifications:** Optional page (toggleable)

## Content Model

- **Custom Post Type:** `project` (with taxonomies: `project_type`, `market_type`)
- **Pages:** Standard WordPress pages with custom templates

## License

Proprietary - ACE Group KI


# Architecture Decisions Log

## Project Structure

### Theme vs. Plugin Separation
**Decision:** Custom Post Types and site settings in plugin, presentation in theme.

**Rationale:**
- Separates content model from presentation
- Theme updates won't break CPT registration
- Follows WordPress best practices
- Easier maintenance and updates

## Content Model

### Projects as CPT vs. Pages
**Decision:** Custom Post Type `project` with archive.

**Rationale:**
- Projects page is a true gallery with repeated entries
- Filters require taxonomy queries
- Future scalability for project management
- Easier content updates via WP admin

### Taxonomies
**Decision:** Two taxonomies: `project_type` and `market_type`.

**Rationale:**
- `project_type`: Matches the 4 core services
- `market_type`: Enables filtering by Commercial/Residential
- Non-hierarchical for flexibility

## Build Pipeline

### Vite vs. Webpack/Gulp
**Decision:** Vite for build pipeline.

**Rationale:**
- Faster development with HMR
- Modern tooling
- Better performance
- Good WordPress integration options

### Asset Enqueue Strategy
**Decision:** Manifest-based versioning with conditional page loading.

**Rationale:**
- Cache busting via hash-based filenames
- Reduced initial bundle size
- Page-specific scripts only load when needed

## JavaScript Libraries

### GSAP Integration
**Decision:** GSAP with ScrollTrigger for animations.

**Rationale:**
- Industry standard for animations
- ScrollTrigger for scroll-based reveals
- Conditional loading (only on home page)

### Swiper.js
**Decision:** Swiper for project galleries.

**Rationale:**
- Lightweight and performant
- Good mobile support
- Easy to customize

## Forms

### Form Plugin vs. Custom
**Decision:** Use existing form plugin (Gravity Forms/Fluent Forms/WPForms).

**Rationale:**
- Faster development
- Battle-tested security
- Easy admin management
- Custom handler only if requirements exceed plugin capabilities

**Note:** Form plugin choice to be documented when selected.

## Theme Architecture

### Block-First Approach
**Decision:** Use theme.json and block patterns.

**Rationale:**
- Modern WordPress approach
- Better editor experience
- Reusable patterns
- Future-proof

### Template Hierarchy
**Decision:** Custom page templates for each main page.

**Rationale:**
- Clear separation of concerns
- Easy to maintain
- Matches content map structure

## Optional Features

### Safety & Qualifications Page
**Decision:** Optional template + navigation toggle.

**Rationale:**
- Not in content map but explicitly in sitemap
- Create template structure
- Can be enabled/disabled via theme customizer or plugin setting

## Future Considerations

- Consider ACF (Advanced Custom Fields) for project fields if native custom fields insufficient
- Evaluate need for custom blocks if patterns insufficient
- Consider image optimization plugin for project galleries
- Evaluate caching strategy for production


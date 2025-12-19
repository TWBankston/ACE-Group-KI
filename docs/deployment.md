# Deployment Checklist

## Pre-Deployment

- [ ] Run `npm run build` in theme directory
- [ ] Test all pages locally
- [ ] Verify all forms are working
- [ ] Check responsive design on mobile/tablet
- [ ] Test project filters
- [ ] Verify navigation menus
- [ ] Check for console errors
- [ ] Test in multiple browsers (Chrome, Firefox, Safari, Edge)

## Production Requirements

- PHP 8.1+ (8.2 recommended)
- MySQL 5.7+ or MariaDB 10.3+
- WordPress 6.0+
- SSL certificate (HTTPS required)

## Deployment Steps

1. **Build Assets**
   ```bash
   cd wp-content/themes/acegroupki
   npm run build
   ```

2. **Upload Files**
   - Upload `wp-content/themes/acegroupki/` to production
   - Upload `wp-content/plugins/acegroupki-core/` to production
   - Ensure `dist/` folder is included

3. **Database**
   - Export local database if needed
   - Import to production (or use migration tool)
   - Update URLs if needed (use Search Replace DB tool)

4. **WordPress Configuration**
   - Activate theme
   - Activate ACE Group KI Core plugin
   - Configure site settings (Settings > ACE Group KI)
   - Set up navigation menus
   - Configure permalinks (Settings > Permalinks)

5. **Content Setup**
   - Create pages and assign templates
   - Set Home page as front page
   - Add projects (if any)
   - Configure form plugin (if using)

6. **Performance**
   - Enable caching plugin (WP Super Cache, W3 Total Cache, etc.)
   - Optimize images
   - Enable GZIP compression
   - Configure CDN if applicable

7. **Security**
   - Update WordPress core
   - Update plugins
   - Configure security plugin (Wordfence, etc.)
   - Set up backups

## Post-Deployment

- [ ] Test all pages on production
- [ ] Verify forms are submitting correctly
- [ ] Check email notifications
- [ ] Test on mobile devices
- [ ] Verify SSL certificate
- [ ] Check page load speeds
- [ ] Test project filters
- [ ] Verify navigation menus

## Rollback Plan

If issues occur:
1. Switch to default WordPress theme
2. Deactivate ACE Group KI Core plugin
3. Investigate errors in debug log
4. Fix issues and redeploy

## Maintenance

- Regular WordPress core updates
- Plugin updates
- Theme updates (rebuild assets after updates)
- Regular backups
- Monitor error logs
- Performance monitoring


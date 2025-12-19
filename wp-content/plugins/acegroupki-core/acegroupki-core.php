<?php
/**
 * Plugin Name: ACE Group KI Core
 * Plugin URI: https://acegroupki.com
 * Description: Core functionality for ACE Group KI website. Registers custom post types, taxonomies, and site settings.
 * Version: 1.0.0
 * Author: ACE Group KI
 * Author URI: https://acegroupki.com
 * License: Proprietary
 * Text Domain: acegroupki-core
 * Requires at least: 6.0
 * Requires PHP: 8.1
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ACEGROUPKI_CORE_VERSION', '1.0.0');
define('ACEGROUPKI_CORE_DIR', plugin_dir_path(__FILE__));
define('ACEGROUPKI_CORE_URI', plugin_dir_url(__FILE__));

// Load plugin files
require_once ACEGROUPKI_CORE_DIR . 'includes/class-cpt-projects.php';
require_once ACEGROUPKI_CORE_DIR . 'includes/class-taxonomies.php';
require_once ACEGROUPKI_CORE_DIR . 'includes/class-site-settings.php';

/**
 * Initialize plugin
 */
function acegroupki_core_init() {
    // Initialize CPT
    $cpt_projects = new ACEGroupKI_CPT_Projects();
    $cpt_projects->init();

    // Initialize Taxonomies
    $taxonomies = new ACEGroupKI_Taxonomies();
    $taxonomies->init();

    // Initialize Site Settings
    $site_settings = new ACEGroupKI_Site_Settings();
    $site_settings->init();
}
add_action('plugins_loaded', 'acegroupki_core_init');


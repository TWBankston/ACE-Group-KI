<?php
/**
 * Plugin Name: ACE Group KI Forms
 * Plugin URI: https://acegroupki.com
 * Description: Custom form handling for ACE Group KI website. Use this if custom form handling is needed beyond form plugins.
 * Version: 1.0.0
 * Author: ACE Group KI
 * Author URI: https://acegroupki.com
 * License: Proprietary
 * Text Domain: acegroupki-forms
 * Requires at least: 6.0
 * Requires PHP: 8.1
 *
 * Note: This plugin is optional. It's recommended to use Gravity Forms, Fluent Forms, or WPForms instead.
 * This plugin is provided as a placeholder for custom form handling if needed.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ACEGROUPKI_FORMS_VERSION', '1.0.0');
define('ACEGROUPKI_FORMS_DIR', plugin_dir_path(__FILE__));
define('ACEGROUPKI_FORMS_URI', plugin_dir_url(__FILE__));

// Load plugin files (if custom form handling is needed)
// require_once ACEGROUPKI_FORMS_DIR . 'includes/class-form-handler.php';

/**
 * Initialize plugin (currently disabled - use form plugin instead)
 */
// function acegroupki_forms_init() {
//     $form_handler = new ACEGroupKI_Form_Handler();
//     $form_handler->init();
// }
// add_action('plugins_loaded', 'acegroupki_forms_init');


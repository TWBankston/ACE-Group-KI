<?php
/**
 * ACE Group KI Theme Functions
 *
 * @package ACEGroupKI
 */

if (!defined('ABSPATH')) {
    exit;
}

// Theme version
define('ACEGROUPKI_VERSION', '1.0.0');
define('ACEGROUPKI_THEME_DIR', get_template_directory());
define('ACEGROUPKI_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function acegroupki_setup() {
    // Add theme support
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Add custom logo support
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'acegroupki'),
        'footer' => __('Footer Menu', 'acegroupki'),
    ));

    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'acegroupki_setup');

/**
 * Enqueue Scripts and Styles
 */
function acegroupki_enqueue_assets() {
    // Get manifest for versioned assets
    $manifest_path = ACEGROUPKI_THEME_DIR . '/dist/.vite/manifest.json';
    $manifest = file_exists($manifest_path) ? json_decode(file_get_contents($manifest_path), true) : null;

    // Fallback if manifest doesn't exist (development)
    if (!$manifest) {
        // Enqueue unversioned assets for development
        wp_enqueue_style(
            'acegroupki-main',
            ACEGROUPKI_THEME_URI . '/src/scss/main.scss',
            array(),
            ACEGROUPKI_VERSION
        );
        return;
    }

    // Enqueue main stylesheet
    if (isset($manifest['js/main.js']['css']) && is_array($manifest['js/main.js']['css'])) {
        foreach ($manifest['js/main.js']['css'] as $css_file) {
            wp_enqueue_style(
                'acegroupki-main',
                ACEGROUPKI_THEME_URI . '/dist/' . $css_file,
                array(),
                ACEGROUPKI_VERSION
            );
        }
    }

    // Enqueue main JavaScript
    if (isset($manifest['js/main.js']['file'])) {
        wp_enqueue_script(
            'acegroupki-main',
            ACEGROUPKI_THEME_URI . '/dist/' . $manifest['js/main.js']['file'],
            array(),
            ACEGROUPKI_VERSION,
            true
        );
    }

    // Conditionally enqueue page-specific scripts
    if (is_front_page() || is_page_template('templates/template-home.php')) {
        if (isset($manifest['js/home.js']['file'])) {
            wp_enqueue_script(
                'acegroupki-home',
                ACEGROUPKI_THEME_URI . '/dist/' . $manifest['js/home.js']['file'],
                array('acegroupki-main'),
                ACEGROUPKI_VERSION,
                true
            );
        }
    }

    if (is_post_type_archive('project') || is_page_template('templates/template-projects.php') || is_singular('project')) {
        if (isset($manifest['js/projects.js']['file'])) {
            wp_enqueue_script(
                'acegroupki-projects',
                ACEGROUPKI_THEME_URI . '/dist/' . $manifest['js/projects.js']['file'],
                array('acegroupki-main'),
                ACEGROUPKI_VERSION,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'acegroupki_enqueue_assets');

/**
 * Register Widget Areas
 */
function acegroupki_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'acegroupki'),
        'id' => 'footer-1',
        'description' => __('Add widgets here to appear in your footer.', 'acegroupki'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'acegroupki_widgets_init');

/**
 * Load Text Domain
 */
function acegroupki_load_textdomain() {
    load_theme_textdomain('acegroupki', ACEGROUPKI_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'acegroupki_load_textdomain');

/**
 * Register Block Patterns
 */
function acegroupki_register_block_patterns() {
    register_block_pattern_category('acegroupki', array('label' => __('ACE Group KI', 'acegroupki')));
}
add_action('init', 'acegroupki_register_block_patterns');


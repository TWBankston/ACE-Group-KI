<?php
/**
 * Projects Custom Post Type
 *
 * @package ACEGroupKI_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class ACEGroupKI_CPT_Projects {
    /**
     * Initialize CPT registration
     */
    public function init() {
        add_action('init', array($this, 'register_post_type'));
    }

    /**
     * Register Projects CPT
     */
    public function register_post_type() {
        $labels = array(
            'name' => _x('Projects', 'Post Type General Name', 'acegroupki-core'),
            'singular_name' => _x('Project', 'Post Type Singular Name', 'acegroupki-core'),
            'menu_name' => __('Projects', 'acegroupki-core'),
            'name_admin_bar' => __('Project', 'acegroupki-core'),
            'archives' => __('Project Archives', 'acegroupki-core'),
            'attributes' => __('Project Attributes', 'acegroupki-core'),
            'parent_item_colon' => __('Parent Project:', 'acegroupki-core'),
            'all_items' => __('All Projects', 'acegroupki-core'),
            'add_new_item' => __('Add New Project', 'acegroupki-core'),
            'add_new' => __('Add New', 'acegroupki-core'),
            'new_item' => __('New Project', 'acegroupki-core'),
            'edit_item' => __('Edit Project', 'acegroupki-core'),
            'update_item' => __('Update Project', 'acegroupki-core'),
            'view_item' => __('View Project', 'acegroupki-core'),
            'view_items' => __('View Projects', 'acegroupki-core'),
            'search_items' => __('Search Project', 'acegroupki-core'),
            'not_found' => __('Not found', 'acegroupki-core'),
            'not_found_in_trash' => __('Not found in Trash', 'acegroupki-core'),
            'featured_image' => __('Featured Image', 'acegroupki-core'),
            'set_featured_image' => __('Set featured image', 'acegroupki-core'),
            'remove_featured_image' => __('Remove featured image', 'acegroupki-core'),
            'use_featured_image' => __('Use as featured image', 'acegroupki-core'),
            'insert_into_item' => __('Insert into project', 'acegroupki-core'),
            'uploaded_to_this_item' => __('Uploaded to this project', 'acegroupki-core'),
            'items_list' => __('Projects list', 'acegroupki-core'),
            'items_list_navigation' => __('Projects list navigation', 'acegroupki-core'),
            'filter_items_list' => __('Filter projects list', 'acegroupki-core'),
        );

        $args = array(
            'label' => __('Project', 'acegroupki-core'),
            'description' => __('Construction projects portfolio', 'acegroupki-core'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'taxonomies' => array('project_type', 'market_type'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-building',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'projects'),
        );

        register_post_type('project', $args);
    }
}


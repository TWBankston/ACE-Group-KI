<?php
/**
 * Taxonomies Registration
 *
 * @package ACEGroupKI_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class ACEGroupKI_Taxonomies {
    /**
     * Initialize taxonomy registration
     */
    public function init() {
        add_action('init', array($this, 'register_taxonomies'));
    }

    /**
     * Register all taxonomies
     */
    public function register_taxonomies() {
        $this->register_project_type();
        $this->register_market_type();
    }

    /**
     * Register Project Type taxonomy
     */
    private function register_project_type() {
        $labels = array(
            'name' => _x('Project Types', 'Taxonomy General Name', 'acegroupki-core'),
            'singular_name' => _x('Project Type', 'Taxonomy Singular Name', 'acegroupki-core'),
            'menu_name' => __('Project Types', 'acegroupki-core'),
            'all_items' => __('All Project Types', 'acegroupki-core'),
            'parent_item' => __('Parent Project Type', 'acegroupki-core'),
            'parent_item_colon' => __('Parent Project Type:', 'acegroupki-core'),
            'new_item_name' => __('New Project Type Name', 'acegroupki-core'),
            'add_new_item' => __('Add New Project Type', 'acegroupki-core'),
            'edit_item' => __('Edit Project Type', 'acegroupki-core'),
            'update_item' => __('Update Project Type', 'acegroupki-core'),
            'view_item' => __('View Project Type', 'acegroupki-core'),
            'separate_items_with_commas' => __('Separate project types with commas', 'acegroupki-core'),
            'add_or_remove_items' => __('Add or remove project types', 'acegroupki-core'),
            'choose_from_most_used' => __('Choose from the most used', 'acegroupki-core'),
            'popular_items' => __('Popular Project Types', 'acegroupki-core'),
            'search_items' => __('Search Project Types', 'acegroupki-core'),
            'not_found' => __('Not Found', 'acegroupki-core'),
            'no_terms' => __('No project types', 'acegroupki-core'),
            'items_list' => __('Project types list', 'acegroupki-core'),
            'items_list_navigation' => __('Project types list navigation', 'acegroupki-core'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'project-type'),
        );

        register_taxonomy('project_type', array('project'), $args);

        // Register default terms
        $this->register_default_project_types();
    }

    /**
     * Register Market Type taxonomy
     */
    private function register_market_type() {
        $labels = array(
            'name' => _x('Market Types', 'Taxonomy General Name', 'acegroupki-core'),
            'singular_name' => _x('Market Type', 'Taxonomy Singular Name', 'acegroupki-core'),
            'menu_name' => __('Market Types', 'acegroupki-core'),
            'all_items' => __('All Market Types', 'acegroupki-core'),
            'parent_item' => __('Parent Market Type', 'acegroupki-core'),
            'parent_item_colon' => __('Parent Market Type:', 'acegroupki-core'),
            'new_item_name' => __('New Market Type Name', 'acegroupki-core'),
            'add_new_item' => __('Add New Market Type', 'acegroupki-core'),
            'edit_item' => __('Edit Market Type', 'acegroupki-core'),
            'update_item' => __('Update Market Type', 'acegroupki-core'),
            'view_item' => __('View Market Type', 'acegroupki-core'),
            'separate_items_with_commas' => __('Separate market types with commas', 'acegroupki-core'),
            'add_or_remove_items' => __('Add or remove market types', 'acegroupki-core'),
            'choose_from_most_used' => __('Choose from the most used', 'acegroupki-core'),
            'popular_items' => __('Popular Market Types', 'acegroupki-core'),
            'search_items' => __('Search Market Types', 'acegroupki-core'),
            'not_found' => __('Not Found', 'acegroupki-core'),
            'no_terms' => __('No market types', 'acegroupki-core'),
            'items_list' => __('Market types list', 'acegroupki-core'),
            'items_list_navigation' => __('Market types list navigation', 'acegroupki-core'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'market-type'),
        );

        register_taxonomy('market_type', array('project'), $args);

        // Register default terms
        $this->register_default_market_types();
    }

    /**
     * Register default project type terms
     */
    private function register_default_project_types() {
        $terms = array(
            'Commercial Construction',
            'Residential Construction & Remodeling',
            'Tenant Improvements',
            'Specialty & Custom Projects',
        );

        foreach ($terms as $term) {
            if (!term_exists($term, 'project_type')) {
                wp_insert_term($term, 'project_type');
            }
        }
    }

    /**
     * Register default market type terms
     */
    private function register_default_market_types() {
        $terms = array(
            'Commercial',
            'Residential',
        );

        foreach ($terms as $term) {
            if (!term_exists($term, 'market_type')) {
                wp_insert_term($term, 'market_type');
            }
        }
    }
}


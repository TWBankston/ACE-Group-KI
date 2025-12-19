<?php
/**
 * Automated Page Setup
 *
 * Creates pages and assigns templates on plugin activation.
 *
 * @package ACEGroupKI_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class ACEGroupKI_Page_Setup {
    /**
     * Page configuration
     */
    private $pages = array(
        'home' => array(
            'title' => 'Home',
            'slug' => 'home',
            'template' => 'templates/template-home.php',
            'is_front_page' => true,
        ),
        'about' => array(
            'title' => 'About',
            'slug' => 'about',
            'template' => 'templates/template-about.php',
        ),
        'services' => array(
            'title' => 'Services',
            'slug' => 'services',
            'template' => 'templates/template-services.php',
        ),
        'projects' => array(
            'title' => 'Projects',
            'slug' => 'projects',
            'template' => 'templates/template-projects.php',
        ),
        'contact' => array(
            'title' => 'Contact',
            'slug' => 'contact',
            'template' => 'templates/template-contact.php',
        ),
    );

    /**
     * Initialize
     */
    public function init() {
        add_action('admin_menu', array($this, 'add_setup_page'));
        add_action('admin_init', array($this, 'handle_setup_action'));
        add_action('admin_init', array($this, 'auto_create_pages_if_needed'));
        add_action('admin_notices', array($this, 'show_setup_notice'));
    }

    /**
     * Automatically create pages if they haven't been created yet
     * This runs on admin_init to ensure pages exist
     */
    public function auto_create_pages_if_needed() {
        // Only run once - check if we've already auto-created
        if (get_option('acegroupki_pages_created')) {
            return;
        }

        // Only run for admins
        if (!current_user_can('manage_options')) {
            return;
        }

        // Create all pages automatically
        $this->create_all_pages();
        update_option('acegroupki_pages_created', true);

        // Show a success notice
        add_action('admin_notices', function() {
            ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <strong><?php _e('ACE Group KI:', 'acegroupki-core'); ?></strong>
                    <?php _e('Site pages have been automatically created!', 'acegroupki-core'); ?>
                    <a href="<?php echo admin_url('options-general.php?page=acegroupki-setup'); ?>">
                        <?php _e('View setup', 'acegroupki-core'); ?>
                    </a>
                </p>
            </div>
            <?php
        });
    }

    /**
     * Add setup page to admin menu
     */
    public function add_setup_page() {
        add_submenu_page(
            'options-general.php',
            __('ACE Group KI Setup', 'acegroupki-core'),
            __('ACE Group KI Setup', 'acegroupki-core'),
            'manage_options',
            'acegroupki-setup',
            array($this, 'render_setup_page')
        );
    }

    /**
     * Show setup notice if pages haven't been created
     */
    public function show_setup_notice() {
        if (!get_option('acegroupki_pages_created') && current_user_can('manage_options')) {
            $screen = get_current_screen();
            if ($screen && $screen->id !== 'settings_page_acegroupki-setup') {
                ?>
                <div class="notice notice-info is-dismissible">
                    <p>
                        <strong><?php _e('ACE Group KI:', 'acegroupki-core'); ?></strong>
                        <?php _e('Your site pages have not been set up yet.', 'acegroupki-core'); ?>
                        <a href="<?php echo admin_url('options-general.php?page=acegroupki-setup'); ?>">
                            <?php _e('Set up now', 'acegroupki-core'); ?>
                        </a>
                    </p>
                </div>
                <?php
            }
        }
    }

    /**
     * Handle setup actions
     */
    public function handle_setup_action() {
        if (!isset($_POST['acegroupki_setup_action'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['acegroupki_setup_nonce'], 'acegroupki_setup')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $action = sanitize_text_field($_POST['acegroupki_setup_action']);

        if ($action === 'create_pages') {
            $this->create_all_pages();
            update_option('acegroupki_pages_created', true);
            add_settings_error(
                'acegroupki_setup',
                'pages_created',
                __('All pages have been created and configured successfully!', 'acegroupki-core'),
                'success'
            );
        }

        if ($action === 'reset_pages') {
            $this->delete_all_pages();
            delete_option('acegroupki_pages_created');
            add_settings_error(
                'acegroupki_setup',
                'pages_deleted',
                __('All ACE Group KI pages have been deleted.', 'acegroupki-core'),
                'warning'
            );
        }
    }

    /**
     * Render setup page
     */
    public function render_setup_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        settings_errors('acegroupki_setup');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2><?php _e('Page Setup', 'acegroupki-core'); ?></h2>
                <p><?php _e('This will automatically create the following pages with their associated templates:', 'acegroupki-core'); ?></p>
                
                <table class="widefat" style="margin: 15px 0;">
                    <thead>
                        <tr>
                            <th><?php _e('Page', 'acegroupki-core'); ?></th>
                            <th><?php _e('Slug', 'acegroupki-core'); ?></th>
                            <th><?php _e('Template', 'acegroupki-core'); ?></th>
                            <th><?php _e('Status', 'acegroupki-core'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->pages as $key => $page) : ?>
                            <?php $existing = $this->get_existing_page($page['slug']); ?>
                            <tr>
                                <td><strong><?php echo esc_html($page['title']); ?></strong></td>
                                <td><code>/<?php echo esc_html($page['slug']); ?>/</code></td>
                                <td><code><?php echo esc_html($page['template']); ?></code></td>
                                <td>
                                    <?php if ($existing) : ?>
                                        <span style="color: green;">✓ <?php _e('Created', 'acegroupki-core'); ?></span>
                                        <a href="<?php echo get_edit_post_link($existing->ID); ?>" style="margin-left: 10px;">
                                            <?php _e('Edit', 'acegroupki-core'); ?>
                                        </a>
                                    <?php else : ?>
                                        <span style="color: #999;">— <?php _e('Not created', 'acegroupki-core'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <form method="post" style="margin-top: 20px;">
                    <?php wp_nonce_field('acegroupki_setup', 'acegroupki_setup_nonce'); ?>
                    
                    <?php if (!get_option('acegroupki_pages_created')) : ?>
                        <button type="submit" name="acegroupki_setup_action" value="create_pages" class="button button-primary button-hero">
                            <?php _e('Create All Pages', 'acegroupki-core'); ?>
                        </button>
                        <p class="description" style="margin-top: 10px;">
                            <?php _e('This will create all pages, assign templates, and set the Home page as the front page.', 'acegroupki-core'); ?>
                        </p>
                    <?php else : ?>
                        <p style="color: green; font-weight: bold;">
                            ✓ <?php _e('All pages have been created!', 'acegroupki-core'); ?>
                        </p>
                        <button type="submit" name="acegroupki_setup_action" value="reset_pages" class="button button-secondary" style="margin-top: 15px;" onclick="return confirm('<?php _e('Are you sure you want to delete all ACE Group KI pages?', 'acegroupki-core'); ?>');">
                            <?php _e('Reset & Delete All Pages', 'acegroupki-core'); ?>
                        </button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2><?php _e('Navigation Menu', 'acegroupki-core'); ?></h2>
                <p><?php _e('After creating pages, you need to set up a navigation menu:', 'acegroupki-core'); ?></p>
                <ol>
                    <li><?php _e('Go to', 'acegroupki-core'); ?> <a href="<?php echo admin_url('nav-menus.php'); ?>"><?php _e('Appearance → Menus', 'acegroupki-core'); ?></a></li>
                    <li><?php _e('Create a new menu (e.g., "Primary Menu")', 'acegroupki-core'); ?></li>
                    <li><?php _e('Add the pages to the menu', 'acegroupki-core'); ?></li>
                    <li><?php _e('Assign to the "Primary Menu" location', 'acegroupki-core'); ?></li>
                </ol>
            </div>
        </div>
        <?php
    }

    /**
     * Create all pages
     */
    public function create_all_pages() {
        foreach ($this->pages as $key => $page) {
            $this->create_page($page);
        }

        // Set reading settings
        $front_page = $this->get_existing_page('home');
        if ($front_page) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page->ID);
        }

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Create a single page
     */
    private function create_page($page_data) {
        // Check if page already exists
        $existing = $this->get_existing_page($page_data['slug']);
        if ($existing) {
            // Update template if needed
            update_post_meta($existing->ID, '_wp_page_template', $page_data['template']);
            return $existing->ID;
        }

        // Create the page
        $page_id = wp_insert_post(array(
            'post_title' => $page_data['title'],
            'post_name' => $page_data['slug'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '',
        ));

        if (!is_wp_error($page_id)) {
            // Set the page template
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
        }

        return $page_id;
    }

    /**
     * Delete all created pages
     */
    public function delete_all_pages() {
        foreach ($this->pages as $key => $page) {
            $existing = $this->get_existing_page($page['slug']);
            if ($existing) {
                wp_delete_post($existing->ID, true);
            }
        }

        // Reset reading settings
        update_option('show_on_front', 'posts');
        delete_option('page_on_front');

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Get existing page by slug
     */
    private function get_existing_page($slug) {
        $page = get_page_by_path($slug);
        return $page;
    }

    /**
     * Run on plugin activation
     */
    public static function activate() {
        // Auto-create pages on activation
        $instance = new self();
        $instance->create_all_pages();
        update_option('acegroupki_pages_created', true);
    }

    /**
     * Run on plugin deactivation
     */
    public static function deactivate() {
        // Pages are kept on deactivation
    }
}


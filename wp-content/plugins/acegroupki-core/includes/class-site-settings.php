<?php
/**
 * Site Settings
 *
 * @package ACEGroupKI_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class ACEGroupKI_Site_Settings {
    /**
     * Initialize settings
     */
    public function init() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __('ACE Group KI Settings', 'acegroupki-core'),
            __('ACE Group KI', 'acegroupki-core'),
            'manage_options',
            'acegroupki-settings',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('acegroupki_settings', 'acegroupki_service_area');
        register_setting('acegroupki_settings', 'acegroupki_response_time');
        register_setting('acegroupki_settings', 'acegroupki_phone');
        register_setting('acegroupki_settings', 'acegroupki_email');
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('acegroupki_settings');
                do_settings_sections('acegroupki_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="acegroupki_service_area"><?php _e('Service Area', 'acegroupki-core'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="acegroupki_service_area" name="acegroupki_service_area" value="<?php echo esc_attr(get_option('acegroupki_service_area', 'San Diego, CA and surrounding areas')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Service area description displayed on contact page.', 'acegroupki-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="acegroupki_response_time"><?php _e('Response Time', 'acegroupki-core'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="acegroupki_response_time" name="acegroupki_response_time" value="<?php echo esc_attr(get_option('acegroupki_response_time', 'We aim to respond to all inquiries within one business day.')); ?>" class="regular-text" />
                            <p class="description"><?php _e('Response time message displayed on contact page.', 'acegroupki-core'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="acegroupki_phone"><?php _e('Phone Number', 'acegroupki-core'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="acegroupki_phone" name="acegroupki_phone" value="<?php echo esc_attr(get_option('acegroupki_phone', '')); ?>" class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="acegroupki_email"><?php _e('Email Address', 'acegroupki-core'); ?></label>
                        </th>
                        <td>
                            <input type="email" id="acegroupki_email" name="acegroupki_email" value="<?php echo esc_attr(get_option('acegroupki_email', '')); ?>" class="regular-text" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}


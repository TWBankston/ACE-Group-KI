<?php
/**
 * Call to Action Template Part
 *
 * @package ACEGroupKI
 */
?>
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title"><?php _e('Let\'s Talk About Your Project', 'acegroupki'); ?></h2>
        <div class="cta-buttons">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn--primary">
                <?php _e('Contact Us', 'acegroupki'); ?>
            </a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn--secondary">
                <?php _e('Request Information', 'acegroupki'); ?>
            </a>
        </div>
    </div>
</section>


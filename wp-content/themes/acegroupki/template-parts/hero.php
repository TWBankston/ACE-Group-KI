<?php
/**
 * Hero Template Part
 *
 * @package ACEGroupKI
 */
?>
<section class="hero">
    <div class="container">
        <h1 class="hero__title"><?php _e('ACE Group KI is a professional construction company delivering high-quality commercial and residential building solutions.', 'acegroupki'); ?></h1>
        <p class="hero__subtitle"><?php _e('We specialize in construction, remodeling, and custom build projects with a focus on quality craftsmanship and dependable execution.', 'acegroupki'); ?></p>
        <div class="hero__cta">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn--primary">
                <?php _e('Get in Touch', 'acegroupki'); ?>
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="btn btn--secondary">
                <?php _e('View Our Projects', 'acegroupki'); ?>
            </a>
        </div>
    </div>
</section>


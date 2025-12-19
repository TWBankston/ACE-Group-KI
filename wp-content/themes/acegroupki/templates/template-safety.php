<?php
/**
 * Template Name: Safety & Qualifications
 * Template for Safety & Qualifications page (Optional)
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-safety">
    <section class="safety-intro">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <p><?php _e('Safety and qualifications information will be added here.', 'acegroupki'); ?></p>
        </div>
    </section>

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            ?>
            <section class="safety-content">
                <div class="container">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
            <?php
        }
    }
    ?>
</main>

<?php
get_footer();


<?php
/**
 * Template Name: Projects
 * Template for Projects page
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-projects">
    <section class="projects-intro">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <p><?php _e('Our projects reflect the quality, attention to detail, and professionalism we bring to every job.', 'acegroupki'); ?></p>
        </div>
    </section>

    <?php
    // Redirect to archive if using CPT
    if (post_type_exists('project')) {
        wp_redirect(get_post_type_archive_link('project'));
        exit;
    }
    ?>
</main>

<?php
get_footer();


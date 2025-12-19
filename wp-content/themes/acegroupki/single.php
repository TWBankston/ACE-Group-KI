<?php
/**
 * Single Post Template
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content', 'single');
    }
    ?>
</main>

<?php
get_footer();


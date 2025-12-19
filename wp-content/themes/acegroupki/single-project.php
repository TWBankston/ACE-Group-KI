<?php
/**
 * Single Project Template
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main single-project">
    <?php
    while (have_posts()) {
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>

                <?php
                $project_types = get_the_terms(get_the_ID(), 'project_type');
                $market_types = get_the_terms(get_the_ID(), 'market_type');
                $location = get_post_meta(get_the_ID(), '_project_location', true);
                ?>

                <div class="entry-meta">
                    <?php if ($project_types) : ?>
                        <span class="project-type">
                            <?php echo esc_html($project_types[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($market_types) : ?>
                        <span class="market-type">
                            <?php echo esc_html($market_types[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($location) : ?>
                        <span class="location">
                            <?php echo esc_html($location); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php
            // Project gallery (if using ACF or custom fields)
            $gallery = get_post_meta(get_the_ID(), '_project_gallery', true);
            if ($gallery) {
                // Display gallery
            }
            ?>
        </article>
        <?php
    }
    ?>
</main>

<?php
get_footer();


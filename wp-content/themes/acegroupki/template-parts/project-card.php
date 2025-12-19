<?php
/**
 * Project Card Template Part
 *
 * @package ACEGroupKI
 */
?>
<article class="project-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="project-card__image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="project-card__content">
        <h3 class="project-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php
        $project_types = get_the_terms(get_the_ID(), 'project_type');
        $market_types = get_the_terms(get_the_ID(), 'market_type');
        ?>

        <?php if ($project_types || $market_types) : ?>
            <div class="project-card__meta">
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
            </div>
        <?php endif; ?>

        <?php if (has_excerpt()) : ?>
            <p class="project-card__excerpt"><?php the_excerpt(); ?></p>
        <?php endif; ?>

        <?php
        // Location field (custom field or meta)
        $location = get_post_meta(get_the_ID(), '_project_location', true);
        if ($location) :
            ?>
            <p class="project-card__location">
                <strong><?php _e('Location:', 'acegroupki'); ?></strong> <?php echo esc_html($location); ?>
            </p>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="project-card__link">
            <?php _e('View Project', 'acegroupki'); ?>
        </a>
    </div>
</article>


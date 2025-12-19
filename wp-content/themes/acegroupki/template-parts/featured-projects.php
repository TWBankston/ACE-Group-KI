<?php
/**
 * Featured Projects Template Part
 *
 * @package ACEGroupKI
 */
?>
<section class="featured-projects">
    <div class="container">
        <h2 class="section-title"><?php _e('Recent Projects', 'acegroupki'); ?></h2>
        <p class="section-intro"><?php _e('A selection of completed projects showcasing our range of construction and remodeling capabilities.', 'acegroupki'); ?></p>

        <?php
        $featured_projects = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
        ));

        if ($featured_projects->have_posts()) {
            echo '<div class="projects-grid">';
            while ($featured_projects->have_posts()) {
                $featured_projects->the_post();
                get_template_part('template-parts/project-card');
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            ?>
            <p><?php _e('Projects will be displayed here once they are added.', 'acegroupki'); ?></p>
            <?php
        }
        ?>
    </div>
</section>


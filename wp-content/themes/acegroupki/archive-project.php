<?php
/**
 * Archive Template for Projects CPT
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main archive-project">
    <header class="page-header">
        <div class="container">
            <h1 class="page-title"><?php _e('Projects', 'acegroupki'); ?></h1>
            <p><?php _e('Our projects reflect the quality, attention to detail, and professionalism we bring to every job.', 'acegroupki'); ?></p>
        </div>
    </header>

    <?php
    // Project Filters
    $project_types = get_terms(array(
        'taxonomy' => 'project_type',
        'hide_empty' => true,
    ));

    $market_types = get_terms(array(
        'taxonomy' => 'market_type',
        'hide_empty' => true,
    ));
    ?>

    <section class="project-filters">
        <div class="container">
            <?php if (!empty($project_types) || !empty($market_types)) : ?>
                <div class="filter-group">
                    <?php if (!empty($project_types)) : ?>
                        <div class="filter-item">
                            <label><?php _e('Project Type:', 'acegroupki'); ?></label>
                            <select id="filter-project-type" class="project-filter">
                                <option value=""><?php _e('All Types', 'acegroupki'); ?></option>
                                <?php foreach ($project_types as $type) : ?>
                                    <option value="<?php echo esc_attr($type->slug); ?>">
                                        <?php echo esc_html($type->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($market_types)) : ?>
                        <div class="filter-item">
                            <label><?php _e('Market Type:', 'acegroupki'); ?></label>
                            <select id="filter-market-type" class="project-filter">
                                <option value=""><?php _e('All Markets', 'acegroupki'); ?></option>
                                <?php foreach ($market_types as $type) : ?>
                                    <option value="<?php echo esc_attr($type->slug); ?>">
                                        <?php echo esc_html($type->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="projects-grid">
        <div class="container">
            <?php
            if (have_posts()) {
                echo '<div class="projects-wrapper">';
                while (have_posts()) {
                    the_post();
                    get_template_part('template-parts/project-card');
                }
                echo '</div>';

                // Pagination
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('Previous', 'acegroupki'),
                    'next_text' => __('Next', 'acegroupki'),
                ));
            } else {
                ?>
                <p><?php _e('No projects found.', 'acegroupki'); ?></p>
                <?php
            }
            ?>
        </div>
    </section>
</main>

<?php
get_footer();


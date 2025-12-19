<?php
/**
 * Template Name: About
 * Template for About page
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-about">
    <section class="company-overview">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <p><?php _e('ACE Group KI is a construction company providing commercial and residential building services. The company focuses on quality workmanship, reliable execution, and maintaining strong client relationships throughout every phase of a project.', 'acegroupki'); ?></p>
        </div>
    </section>

    <section class="experience-approach">
        <div class="container">
            <h2><?php _e('Experience & Approach', 'acegroupki'); ?></h2>
            <p><?php _e('With experience across a variety of project types, ACE Group KI approaches each job with careful planning, clear communication, and attention to detail.', 'acegroupki'); ?></p>
        </div>
    </section>

    <section class="values">
        <div class="container">
            <h2><?php _e('Values', 'acegroupki'); ?></h2>
            <ul>
                <li><?php _e('Quality-first mindset', 'acegroupki'); ?></li>
                <li><?php _e('Professional accountability', 'acegroupki'); ?></li>
                <li><?php _e('Clear and consistent communication', 'acegroupki'); ?></li>
                <li><?php _e('Respect for timelines and budgets', 'acegroupki'); ?></li>
            </ul>
        </div>
    </section>
</main>

<?php
get_footer();


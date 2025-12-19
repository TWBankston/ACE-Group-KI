<?php
/**
 * Template Name: Services
 * Template for Services page
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-services">
    <section class="services-intro">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <p><?php _e('ACE Group KI offers a range of construction services tailored to both residential and commercial clients. Our team approaches each project with professionalism, precision, and a focus on results.', 'acegroupki'); ?></p>
        </div>
    </section>

    <section class="services-list">
        <div class="container">
            <div class="service-item">
                <h2><?php _e('Commercial Construction', 'acegroupki'); ?></h2>
                <p><?php _e('End-to-end commercial construction services supporting new builds, renovations, and upgrades.', 'acegroupki'); ?></p>
            </div>

            <div class="service-item">
                <h2><?php _e('Residential Construction & Remodeling', 'acegroupki'); ?></h2>
                <p><?php _e('Custom residential construction and remodeling services designed to elevate living spaces.', 'acegroupki'); ?></p>
            </div>

            <div class="service-item">
                <h2><?php _e('Tenant Improvements', 'acegroupki'); ?></h2>
                <p><?php _e('Interior construction and improvements to meet tenant or business operational needs.', 'acegroupki'); ?></p>
            </div>

            <div class="service-item">
                <h2><?php _e('Specialty & Custom Projects', 'acegroupki'); ?></h2>
                <p><?php _e('Custom construction solutions for projects requiring specialized attention or design-forward execution.', 'acegroupki'); ?></p>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();


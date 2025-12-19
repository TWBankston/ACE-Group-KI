<?php
/**
 * Template Name: Home
 * Template for Home page
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-home">
    <?php
    // Hero Section
    get_template_part('template-parts/hero');

    // Overview / Value Proposition
    ?>
    <section class="value-proposition">
        <div class="container">
            <h2><?php _e('Built on Quality. Driven by Experience.', 'acegroupki'); ?></h2>
            <p><?php _e('ACE Group KI provides reliable construction services for clients seeking quality-driven results. Our team brings hands-on experience, attention to detail, and a commitment to delivering projects that meet both functional and aesthetic goals.', 'acegroupki'); ?></p>
        </div>
    </section>

    <?php
    // Services Snapshot
    get_template_part('template-parts/services-snapshot');

    // Why Choose ACE Group KI
    ?>
    <section class="why-choose">
        <div class="container">
            <h2><?php _e('Why Clients Choose ACE Group KI', 'acegroupki'); ?></h2>
            <ul>
                <li><?php _e('Commitment to quality craftsmanship', 'acegroupki'); ?></li>
                <li><?php _e('Clear communication throughout the project lifecycle', 'acegroupki'); ?></li>
                <li><?php _e('Experienced project coordination and execution', 'acegroupki'); ?></li>
                <li><?php _e('Reliable timelines and expectations', 'acegroupki'); ?></li>
                <li><?php _e('Focus on long-term client satisfaction', 'acegroupki'); ?></li>
            </ul>
        </div>
    </section>

    <?php
    // Featured Projects
    get_template_part('template-parts/featured-projects');

    // CTA Section
    get_template_part('template-parts/cta');
    ?>
</main>

<?php
get_footer();


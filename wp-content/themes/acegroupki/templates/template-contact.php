<?php
/**
 * Template Name: Contact / Request a Bid
 * Template for Contact page
 *
 * @package ACEGroupKI
 */

get_header();
?>

<main id="main" class="site-main page-contact">
    <section class="contact-intro">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <p><?php _e('Have a project in mind or questions about our services? Get in touch with ACE Group KI to start the conversation.', 'acegroupki'); ?></p>
        </div>
    </section>

    <section class="contact-form-section">
        <div class="container">
            <div class="contact-form-wrapper">
                <?php
                // Form will be added via form plugin or custom form
                // Placeholder for form integration
                ?>
                <div class="contact-form-placeholder">
                    <p><?php _e('Contact form will be integrated here.', 'acegroupki'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-details">
        <div class="container">
            <div class="service-area">
                <h3><?php _e('Service Area', 'acegroupki'); ?></h3>
                <p><?php echo esc_html(get_option('acegroupki_service_area', 'San Diego, CA and surrounding areas')); ?></p>
            </div>

            <div class="response-time">
                <h3><?php _e('Response Time', 'acegroupki'); ?></h3>
                <p><?php echo esc_html(get_option('acegroupki_response_time', 'We aim to respond to all inquiries within one business day.')); ?></p>
            </div>

            <?php
            $phone = get_option('acegroupki_phone');
            $email = get_option('acegroupki_email');
            if ($phone || $email) :
                ?>
                <div class="contact-info">
                    <?php if ($phone) : ?>
                        <p><strong><?php _e('Phone:', 'acegroupki'); ?></strong> <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></p>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <p><strong><?php _e('Email:', 'acegroupki'); ?></strong> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();


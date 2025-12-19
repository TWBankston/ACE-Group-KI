<?php
/**
 * Footer Template Part
 *
 * @package ACEGroupKI
 */
?>
    <footer id="colophon" class="site-footer">
        <div class="site-footer__inner">
            <?php
            if (is_active_sidebar('footer-1')) {
                ?>
                <div class="footer-widgets">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
                <?php
            }
            ?>

            <nav class="footer-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id' => 'footer-menu',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                ));
                ?>
            </nav>

            <div class="site-info">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>


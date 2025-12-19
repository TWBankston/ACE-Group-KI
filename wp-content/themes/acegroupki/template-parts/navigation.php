<?php
/**
 * Navigation Template Part
 *
 * @package ACEGroupKI
 */
?>
<nav class="main-navigation">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_id' => 'primary-menu',
        'container' => false,
        'menu_class' => 'nav-menu',
    ));
    ?>
</nav>


<nav role="navigation" class=" info subNav">
    <?php wp_nav_menu(array(
    'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
    'container_class' => 'utility-footer-menu cf',         // class of container (should you choose to use it)
    'menu' => __( 'Footer Utility Menu', 'bonestheme' ),   // nav name
    'menu_class' => 'nav footer-utility-nav cf',            // adding custom nav class
    'theme_location' => 'footer-utility-nav',             // where it's located in the theme
    'before' => '',                                 // before the menu
    'after' => '',                                  // after the menu
    'link_before' => '',                            // before each link
    'link_after' => '',                             // after each link
    'depth' => 1,                                   // limit the depth of the nav
    'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
    )); ?>
</nav>

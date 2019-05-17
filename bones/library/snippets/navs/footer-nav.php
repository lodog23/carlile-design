<nav role="navigation" class="footerNav">
	<?php wp_nav_menu(array(
		'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
		'container_class' => 'footer-menu cf',         // class of container (should you choose to use it)
		'menu' => __( 'Footer Menu', 'bonestheme' ),   // nav name
		'menu_class' => 'nav footer-nav cf',            // adding custom nav class
		'theme_location' => 'footer-nav',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 1,                                   // limit the depth of the nav
		'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
	)); ?>
</nav>

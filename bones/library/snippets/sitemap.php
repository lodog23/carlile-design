<ul id="sitemap">
	<?php /* include the ID for the homepage here */ ?>
	<li><a href="<?php echo get_permalink(get_option('page_on_front')); ?>"><?php echo get_the_title(get_option('page_on_front')); ?></a></li>
	<?php
    wp_nav_menu(array(
      'container' => '',
      'container_class' => 'nav-section',
      'theme_location' => 'main-nav',
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
    )); 
    wp_nav_menu(array(
      'container' => '',
      'container_class' => 'nav-section',
      'theme_location' => 'utility-nav',
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
    )); 
    wp_nav_menu(array(
      'container' => '',
      'container_class' => 'nav-section',
      'theme_location' => 'footer-utility-nav',
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
    )); 
	?>
</ul>
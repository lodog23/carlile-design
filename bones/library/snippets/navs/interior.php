<?php
$top_page_ID = end( get_ancestors( get_the_ID(), 'page' ) );
$top_page_url = get_permalink( $top_page_ID );
$top_page_title = get_the_title( $top_page_ID );
$start_depth = !$top_page_ID ? 1 : 0;

$interiorNav = wp_nav_menu(array(
    'container' => 'nav',                           // remove nav container
    'container_class' => 'menu cf interior',        // class of container (should you choose to use it)
    'container_id' => 'leftNavSection',
    'menu_class' => 'leftNav interior-nav color-3',      // adding custom nav class
    'before' => '',                                 // before the menu
    'after' => '',                                  // after the menu
    'link_before' => '',                            // before each link
    'link_after' => '',                             // after each link
    'depth' => 0,                                   // limit the depth of the nav
    'start_depth' => $start_depth,
    'segment' => $top_page_ID,
    'walker' => new qd_custom_nav_walker(),
    'echo' => false
  ));

?>
<div id="interior-nav" <?php echo !$interiorNav ? 'class="no-nav"' : '' ?>>
  <h4 class="interior-nav-title<?php echo !$top_page_ID ? " current-menu-item" : "" ?>"><a class="color-2" href="<?php echo $top_page_url; ?>"><?php echo $top_page_title; ?></a></h4>
  <hr class="color-4-bg" />
  <?php
    echo $interiorNav;
  ?>
  <hr class="color-4-bg" />
</div>

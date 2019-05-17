<?php $displayWidget = get_field('qd_display_widgets');

    if ($displayWidget){
        $widgetVar = 'qd_widgets';
    }

?>

<section id="widget-space" class="sidebar <?php echo $sidebar ?>" role="complementary">
    <?php //Check for left ads
    if(!isset($widgetVar)){
      $widgetVar = 'qd_widgets';
    }
    if(is_search()||is_404()){
      $ps = get_field($widgetVar, options);
    }else{
      if(!$PageID){
        $PageID = get_the_ID();
      }
      $ps = get_field($widgetVar, $PageID);
    }
    if($ps){
      include_once('library/snippets/widgets.php');

      /********************************************/
      /*           STEP THROUGH WIDGETS           */
      /********************************************/
      if ( $ps ):
        foreach( $ps as $p):
 /*         $terms = get_the_terms($p->ID, 'widget_type');
          if($terms):
            foreach ($terms as $t) :
              $term = $t->slug;
            endforeach;
       */
            echo do_shortcode('[widget id="'.$p->ID.'"]');
            //echo do_shortcode('[widget type="' . $term . '" id="'.$p->ID.'"]');
                /*        endif;
                 */
        endforeach;
      endif;
    } ?>
</section>

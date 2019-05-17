<?php
add_shortcode( 'widget', 'widget_function' );
function widget_function( $atts, $content = null ) {
	extract( shortcode_atts( array(
    'class' => '',
	  'type' => '',
	  'id' => ''
      ), $atts ) );
	switch ($type) :
		case 'standard-widget':
			return standard_widget($id);
			break;	
		case 'news-widget':
			return news_widget($id);
			break;
    case 'blog-widget':
			return blog_widget($id);
			break;
    case 'freeform-widget':
			return freeform_widget($id);
			break;
	endswitch; 
}

/***************************************/
/*             TEXT WIDGET             */
/***************************************/
function standard_widget( $id ) {
  ob_start();
  
  //getvars
  $wTitle = get_field('qd_sow_title', $id);
  $wType = get_field('qd_sow_type', $id);
  $wHeadline = get_field('qd_sow_headline', $id);
  $wTeaser = get_field('qd_sow_teaser', $id);
  $wSubHeadline = get_field('qd_sow_sub_headline', $id);
  $wImage = get_field('qd_sow_image', $id);
  if($wImage){
    switch($wType){
      case 'small':
        $wImageUrl = wp_get_attachment_image_src( $wImage, 'widget-tall' );
        break;
      case 'medium':
        $wImageUrl = wp_get_attachment_image_src( $wImage, 'widget-short' );
        break;
      case 'large':
        $wImageUrl = wp_get_attachment_image_src( $wImage, 'widget-square' );
        break;
    }
    $wImageUrl = $wImageUrl[0];
  }
  
  $wButtonText = get_field('qd_sow_button_text', $id);
  $linkTarget = '';
  $wButtonLinkType = get_field('qd_sow_button_link_type', $id);
  switch ($wButtonLinkType){
    case "internal":
      $link = get_field('qd_sow_internal_link', $id);
      $linkTarget = '';
      break;
    case "external":
      $link = get_field('qd_sow_external_link', $id);
      $linkTarget = 'target="_blank"';
      break;
    case "file":
      $link = get_field('qd_sow_download', $id);
      $linkTarget = 'target="_blank"';
      break;
    case "video":
      $link = get_field('qd_sow_video_link', $id);
      break;
  }
  
  ?>
  <aside class="qd-widget standard-widget">
  
    <?php if($wTitle){ ?>
      <h3 class="color-2"><?php echo $wTitle ?></h3>
    <?php } ?>
    
    <div class="widget-panel widget-bg image-<?php echo $wType ?>">
      <?php if($wImageUrl){ ?>
        <div class="widget-image" style="background-image:url(<?php echo $wImageUrl ?>);"></div>
      <?php } ?>
      
      <?php if($wHeadline){ ?>
        <h2 class="widget-header color-1"><?php echo $wHeadline ?></h2>
      <?php } ?>
      
      <?php if($wTeaser){ ?>
          <p class="widget-1"><?php echo $wTeaser; ?></p>
      <?php } ?>
      
      <?php if($wSubHeadline){ ?>
          <p class="widget-subhead widget-2"><?php echo $wSubHeadline; ?></p>
      <?php } ?>
      
      <?php if($wButtonText){ ?>
          <div class="btn-container">
              <a class="btn" href="<?php echo $link; ?>" class="widget-button cf" <?php echo $linkTarget; ?>><?php echo $wButtonText; ?></a>
          </div>
      <?php } ?>
    </div>
  </aside>
  <?php $out = ob_get_clean();		
        return $out;
}

/***************************************/
/*             FREEFORM WIDGET            */
/***************************************/
function freeform_widget( $id ) {
  ob_start();
  
  //getvars
  $wTitle = get_field('qd_ffw_headline', $id);
  $wContent = get_field('qd_ffw_content', $id);
  
  ?>
  <aside class="qd-widget freeform-widget">
  
    <?php if($wTitle){ ?>
      <h3 class="color-2"><?php echo $wTitle ?></h3>
    <?php } ?>
    
    <div class="widget-panel color-3">
      
      <?php if($wContent){ ?>
          <?php echo $wContent; ?>
      <?php } ?>
      
    </div>
  </aside>
  <?php $out = ob_get_clean();		
        return $out;
}

/***************************************/
/*            VIDEO WIDGET             */
/***************************************/
/*
function video_widget( $id ) {
  //wp_enqueue_style( 'lightbox-stylesheet' );
  //wp_enqueue_script( 'lightbox' );
  ob_start();
  
  //getvars
  $widgetTeaser = get_field('qd_widget_content', $id);
  $widgetThumbnail = get_field('qd_widget_thumbnail', $id);
  if($widgetThumbnail){
    $widgetThumbnailUrl = wp_get_attachment_image_src( $widgetThumbnail, 'video-widget-thumb' );
    $widgetThumbnailUrl = $widgetThumbnailUrl[0];
  }
  $widgetVideo = get_field('qd_widget_video', $id);
  ?>
  <aside class="qdWidget videoWidget bottom-shadow">
    <a href="<?php echo $widgetVideo ?>" style="background-image:url(<?php echo $widgetThumbnailUrl ?>);" class="litebox wplightbox" rel="lightbox">
      Click to play video
    </a>
    <div class="widgetContent">
      <div class="widgetIcon">Video</div>
      <?php if($widgetTeaser){ ?>
          <p><?php echo $widgetTeaser; ?></p>
      <?php } ?>
    </div>
  </aside>
  <?php $out = ob_get_clean();		
        return $out;
}
*/

/***************************************/
/*            BLOG WIDGET             */
/***************************************/
function blog_widget( $id ) {
  ob_start();
  
  //getvars
  $blogFeedTitle = get_field('qd_bw_headline', $id);
  $blogFeedCount = get_field('qd_bw_records', $id);
  $blogFeedCount = is_numeric($blogFeedCount) ? $blogFeedCount : 3;
  
  ?>
  <aside class="qd-widget blog-feed-widget">
    <?php if($blogFeedTitle){ ?>
      <h3 class="color-2"><?php echo $blogFeedTitle ?></h3>
      <hr class="color-4-bg" />
    <?php } ?>
    
    <div class="widget-panel">
      
      <?php 
      
      global $wpdb; 
      $querystr = "
        SELECT wposts.*
        FROM $wpdb->posts wposts
        WHERE wposts.post_type = 'post'
        AND wposts.post_status = 'publish'
        ORDER BY wposts.post_date DESC
        LIMIT " . $blogFeedCount;

      $recent_posts = $wpdb->get_results($querystr);

      if($recent_posts){ 
        global $post;
        ?>

        <ul class="blog-feed">

        <?php foreach ($recent_posts as $post): ?>
          <?php setup_postdata($post); ?>

		        <li><p class="post-link color-2"><a href="<?php get_permalink($post->ID) ?>"><?php echo $post->post_title?></p></a><p class="post-date color-4"><?php echo date_format(date_create($post->post_date), 'F j, Y') ?></p></li>
	        
        <?php endforeach; ?>
        </ul>

      <?php } ?>
    </div>  
  </aside>
  <?php 
    wp_reset_postdata();  
    $out = ob_get_clean();		
    return $out;
}

/***************************************/
/*            BLOG WIDGET             */
/***************************************/
function blog_widget_old_approach( $id ) {
  ob_start();
  
  //getvars
  $blogFeedTitle = get_field('qd_bw_headline', $id);
  $blogFeedCount = get_field('qd_bw_records', $id);
  $blogFeedCount = is_numeric($blogFeedCount) ? $blogFeedCount : 3;
  
  ?>
  <aside class="qd-widget blog-feed-widget">
    <?php if($blogFeedTitle){ ?>
      <h3 class="color-2"><?php echo $blogFeedTitle ?></h3>
      <hr class="color-4-bg" />
    <?php } ?>
    
    <div class="widget-panel">
      
      <?php 
  
  $args = array(
    'numberposts' => $blogFeedCount,
    'post_status' => 'publish'
    );

  $recent_posts = wp_get_recent_posts( $args );
  
  if(count($recent_posts) > 0){ ?>

        <ul class="blog-feed">

        <?php
    foreach( $recent_posts as $recent ){
      
      echo '<li><p class="post-link color-2"><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</p></a><p class="post-date color-4">' . date_format(date_create($recent["post_date"]), 'F j, Y') . '</p></li> ';
    }
        ?>
        </ul>

      <?php } ?>
      
    </div>  
  </aside>
  <?php $out = ob_get_clean();		
        return $out;
}

?>
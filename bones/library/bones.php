<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/

  - head cleanup (remove rsd, uri links, junk css, ect)
  - enqueueing scripts & styles
  - theme support functions
  - custom menu output & fallbacks
  - related post function
  - page-navi function
  - removing <p> from around images
  - customizing the post excerpt

*/

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	//add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	//add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

} /* end bones head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
	//if ( strpos( $src, 'ver=' ) )
		//$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles() {

  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

  	// modernizr (without media query polyfill)
  	wp_register_script( 'bones-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

  	// register main stylesheet
  	$stylesheetURL =  '/library/css-output/style.css';
  	wp_register_style( 'bones-stylesheet', get_stylesheet_directory_uri() . $stylesheetURL, array(), date("dmY-his", filemtime (get_stylesheet_directory() . $stylesheetURL)), 'all' );

      // comment reply script for threaded comments
      if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
  		  wp_enqueue_script( 'comment-reply' );
      }

  		//adding scripts file in the footer
  	$scriptsURL =  '/library/js/scripts.min.js';
      wp_register_script( 'bones-js', get_stylesheet_directory_uri() . $scriptsURL, array( 'jquery' ), date("dmY-his", filemtime (get_stylesheet_directory() . $scriptsURL)), true );

  	wp_enqueue_style( 'font-awesome-stylesheet', get_stylesheet_directory_uri() . '/library/css/fonts/font-awesome/css/font-awesome.min.css', array(), '', 'all' );
      wp_enqueue_style( 'font-awesome-five', '//use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '', 'all' );


      // if(is_front_page()):
      //     wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ), '', true );
      //     wp_enqueue_style( 'slick-css', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', array(), '', 'all' );
      // endif;
  		// enqueue styles and scripts
  		wp_enqueue_script( 'bones-modernizr' );
  		wp_enqueue_style( 'bones-stylesheet' );

  		/*
  		I recommend using a plugin to call jQuery
  		using the google cdn. That way it stays cached
  		and your site will load faster.
  		*/
  		wp_enqueue_script( 'jquery' );
  		wp_enqueue_script( 'bones-js' );
  		wp_enqueue_script( 'responsive-js' );

  	}
  }


      function fontawesome_dashboard() {
         wp_enqueue_style( 'font-awesome-five', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '', 'all' );

      }

      add_action('admin_init', 'fontawesome_dashboard');

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(254, 45, true);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'bonestheme' ),  // main nav in header
			'utility-nav' => __( 'Utility Menu', 'bonestheme' ) // secondary nav in header
		)
	);

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );

} /* end bones theme support */


/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end bones related posts function */

/*********************
PAGE NAVI
*********************/
/**
 * Summary of bones_page_navi
 * @param $custom_query : Optional custom query may be passed into pagination. If no query is passed, the default global wp_query will be used
 * @param $prev : Text to be used for the 'Previous' button
 * @param $next : Text to be used for the 'Next' button
 * @param $pages_to_show : The number of pages to be shown within the pagination
 * @param $before : Any HTML/Text that should display prior to the pagination
 * @param $after : Any HTML/Text that should display prior to the pagination
 * @return
 */
function bones_page_navi($custom_query = '', $prev = '', $next = '', $pages_to_show = 7, $before = '', $after = '') {
  global $wpdb, $wp_query;

  //Check for custom query variable, if set, assign to navi_query, if not, assign main wp_query to navi_query
  if (isset($custom_query) && $custom_query != '') {
    $navi_query = $custom_query;
  } else {
    $navi_query = $wp_query;
  }

  //change $posts_per_page variable to be set with the new navi_query
  $posts_per_page = intval($navi_query->query_vars['posts_per_page']);
  $paged = intval(get_query_var('paged'));
  $numposts = $navi_query->found_posts; //update with navi_query
  $max_page = $navi_query->max_num_pages; //update with navi_query
  if ( $numposts <= $posts_per_page ) { return; }
  if(empty($paged) || $paged == 0) {
    $paged = 1;
  }
  $pages_to_show_minus_1 = $pages_to_show-1;
  $half_page_start = floor($pages_to_show_minus_1/2);
  $half_page_end = ceil($pages_to_show_minus_1/2);
  $start_page = $paged - $half_page_start;
  if($start_page <= 0) {
    $start_page = 1;
  }
  $end_page = $paged + $half_page_end;
  if(($end_page - $start_page) != $pages_to_show_minus_1) {
    $end_page = $start_page + $pages_to_show_minus_1;
  }
  if($end_page > $max_page) {
    $start_page = $max_page - $pages_to_show_minus_1;
    $end_page = $max_page;
  }
  if($start_page <= 0) {
    $start_page = 1;
  }

  echo $before.'<nav class="page-navigation"><ol class="bones_page_navi clearfix">'."";
  /*if ($start_page >= 2 && $pages_to_show < $max_page) {
  $first_page_text = __( "First", 'bonestheme' );
  echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
  }*/
  echo '<li class="bpn-prev-link">';
  if($paged != 1){
    previous_posts_link($prev);
  }else{
    echo '<div class="inactivePreviousArrow">'.$prev.'</div>';
  }
  echo '</li>';
  for($i = $start_page; $i  <= $end_page; $i++) {
    $additionalClass = "";
    if($i == $start_page){
      $additionalClass = "first";
    }else if($i == $end_page){
      $additionalClass = "last";
    }
    if($i == $paged) {
      echo '<li class="bpn-current"><div class="currentPage '.$additionalClass.'">'.$i.'</div></li>';
    } else {
      echo '<li class="bpn-num-link"><a href="'.get_pagenum_link($i).'" class="'.$additionalClass.'">'.$i.'</a></li>';
    }
  }
  echo '<li class="bpn-next-link">';
  if($paged != $max_page){
    next_posts_link($next, $max_page);
  }else{
    echo '<div class="inactiveNextArrow">'.$next.'</div>';
  }
  echo '</li>';
  /*if ($end_page < $max_page) {
  $last_page_text = __( "Last", 'bonestheme' );
  echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
  }*/
  echo '</ol></nav>'.$after."";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'bonestheme' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'bonestheme' ) .'</a>';
}



?>

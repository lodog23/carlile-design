<?php

/********************************
ENABLE ADVANCED CUSTOM FIELDS OPTION PAGES
********************************/
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

if( function_exists('acf_add_options_sub_page') )
{
  //acf_add_options_sub_page( 'Sitewide Options' );
  //acf_add_options_sub_page( 'Social Media' );
  //acf_add_options_sub_page( '404 Page' );
}

/********************************
ADD ADDITIONAL TOOLBAR SET TO ACF WYSIWYG
 ********************************/
if ( function_exists( 'get_field' ) ) {
  add_filter( 'acf/fields/wysiwyg/toolbars' , 'qd_toolbars'  );
  function qd_toolbars( $toolbars )
  {
    //FIND MORE INFO ABOUT THIS OPERATION AT http://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
    // Add a new toolbar called "Very Simple"
    // - this toolbar has only 1 row of buttons
    $toolbars['Very Simple' ] = array();
    $toolbars['Very Simple' ][1] = array('bold' , 'italic' , 'underline', 'link', 'unlink' );

    // return $toolbars - IMPORTANT!
    return $toolbars;
  }
}

/******************************************************
ADD CLASSES TO GRAVITY FORMS SUBMIT BUTTONS - ENABLE IF NECESSARY
 ******************************************************/
/**
 * Override the output of the submit button on forms, useful for
 * adding custom classes or other attributes.
 *
 * @param  string $button An HTML string of the default button
 * @param  array  $form   An array of form data
 * @return string $button
 *
 * @filter gform_submit_button
 */
function qd_gform_submit_button( $button, $form ) {
  $button = sprintf(
    '<input type="submit" class="btn" id="gform_submit_button_%d" value="%s">',
    absint( $form['id'] ),
    esc_attr( $form['button']['text'] )
  );

	return $button;
}
//add_filter( 'gform_submit_button', 'qd_gform_submit_button', 10, 2 );

/******************************************************
Filter Yoast Meta Priority - ENABLE IF NECESSARY
 ******************************************************/
//add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/******************************************************
RESOLVE RELATIVE URL ISSUE WITH GRAVITY FORMS UPLOADED FILES - ENABLE IF NECESSARY
 ******************************************************/
//add_filter("gform_upload_path", "change_upload_path", 10, 2);
function change_upload_path($path_info, $form_id){
  $path_info["path"] = "wp-content/uploads/gravity_forms/";
  $path_info["url"] = 'http://'.$_SERVER['HTTP_HOST']."/wp-content/uploads/gravity_forms/";
  return $path_info;
}

/******************************************************
CHANGE THE DEFAULT 'ADD MEDIA' LINK TYPE
 ******************************************************/
update_option('image_default_link_type','none');

/******************************************************
Interior Nav Custom Walker
 ******************************************************/
class qd_custom_nav_walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'page-id-' . $item->object_id;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * @see Walker::end_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     */
    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $output .= "</li>\n";
    }
}




/****************************
Disable the Admin Email Notification When Changed
****************************/

remove_action( 'add_option_new_admin_email', 'update_option_new_admin_email' );
remove_action( 'update_option_new_admin_email', 'update_option_new_admin_email' );

function wpdocs_update_option_new_admin_email( $old_value, $value ) {

    update_option( 'admin_email', $value );
}
add_action( 'add_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );
add_action( 'update_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );


?>

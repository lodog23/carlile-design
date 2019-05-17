<?php

/**
 * Shortcode which returns the current year. Helpful when building copyright footers.
 * @return string
 */
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function button_shortcode( $atts, $content = null ) {
  extract( shortcode_atts( array(
  'class' => '',
  'link' => '',
    ), $atts ) );
  
  return '<a href="' . $link . '" class="btn ' . $class . '">' . $content . '</a>';
}
add_shortcode('qd-button', 'button_shortcode');

function superscript_shortcode( $atts, $content = null ) {
  return '<sup>' . $content . ' </sup>';
}
add_shortcode('super', 'superscript_shortcode');

?>
<?php
/**
 * @package rezfusion_components
 * @version 0.1
 */
/*
Plugin Name: Rezfusion Components
Plugin URI: https://bluetent.com/
Description Embed RezFusion components on your WordPress site.
Author: developers@bluetent.com
Version: 0.1
Author URI: https://bluetent.com
*/
define('S3_BUCKET', 'https://s3.amazonaws.com/rezfusion-components-storage');

/**
 * Add a shortcode wrapper to download rezfusion components.
 *
 * @param $atts
 *
 * @return string
 */
function rezfusion_component( $atts ) {

  $a = shortcode_atts([
    'source' => 'bundle.js',
    'element' => 'app',
    'channel' => NULL,
  ], $atts );

  if(!$a['channel']) {
    return "A 'channel' attribute was not provided";
  }

  wp_enqueue_style(
    "{$a['channel']}-{$a['source']}",
    S3_BUCKET . "/{$a['channel']}/app.css"
  );

  wp_enqueue_script(
    "{$a['channel']}-{$a['source']}",
    S3_BUCKET . "/{$a['channel']}/{$a['source']}"
  );

  return "<div id={$a['element']}></div>";
}
add_shortcode( 'rezfusion-component', 'rezfusion_component' );
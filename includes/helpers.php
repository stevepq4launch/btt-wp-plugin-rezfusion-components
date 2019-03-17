<?php
/**
 * @file - Utility functions
 */

/**
 * Insert a value or key/value pair after a specific key in an array.  If key doesn't exist, value is appended
 * to the end of the array.
 *
 * @param array $array
 * @param string $key
 * @param array $new
 *
 * @return array
 */
function _array_insert_after( array $array, $key, array $new ) {
  $keys = array_keys( $array );
  $index = array_search( $key, $keys );
  $pos = false === $index ? count( $array ) : $index + 1;
  return array_merge( array_slice( $array, 0, $pos ), $new, array_slice( $array, $pos ) );
}

/**
 * Provide a helper function to describe the environement.
 *
 * @return string
 *
 */
function rezfusions_component_env() {
  $env = get_option('rezfusion_hub_env');
  if(empty($env)) {
    return 'prd';
  }

  return $env;
}

/**
 * Get the bucket name to use.
 *
 * @param $env
 *
 * @return string
 */
function rezfusion_components_get_bucket($env = "prd") {
  $suffix = "";
  if($env !== "prd") {
    $suffix = "-dev";
  }
  return "https://s3-us-west-2.amazonaws.com/rezfusion-components-storage$suffix";
}

/**
 * Get the URL for Blueprint.
 *
 * @return string
 */
function rezfusion_components_get_blueprint_url() {
  $env = rezfusions_component_env();
  if($env === 'prd') {
    return "https://blueprint.rezfusion.com/graphql";
  }
  return "https://dev.blueprint.rescmshost.com/graphql";

}

/**
 * Get the local post that represents the remote item.
 *
 * @param $id
 *
 * @return array|null|object
 */
function rezfusion_components_get_local_item($id) {
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rezfusion_hub_item_id' AND  meta_value = '$id' LIMIT 1", ARRAY_A);
}
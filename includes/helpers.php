<?php
/**
 * @file - Utility functions
 */

/**
 * Provide a helper function to describe the environement.
 *
 * @return string
 *
 */
function rezfusions_component_env() {
  $env = get_option('rezfusion_hub_env', 'prd');
  if(empty($env)) {
    return 'prd';
  }

  return $env;
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
  return "https://blueprint.hub-stg.rezfusion.com/graphql";

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

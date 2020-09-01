<?php

namespace Rezfusion\Tests;

/**
 * Class GqlTests
 *
 * @package Rezfusion_Components
 */

/**
 * Test that we can still retrieve the various pieces of API data needed for the
 * plugin.
 */
class SyncTest extends BaseTestCase {

	/**
	 * Fetch the item data and verify it matches.
	 */
	public function testSyncsPropertyData() {
		$response = rezfusion_components_get_channel_items(get_option('rezfusion_hub_channel'));
		$this->assertNotEmpty($response->data->lodgingProducts->results);
		delete_transient('rezfusion_hub_item_data');
		rezfusion_components_cache_item_data();
		$this->assertEquals($response, get_transient('rezfusion_hub_item_data'));
	}

  /**
   * Test that we can add and remove items.
   */
	public function testCreatesItemPosts() {
    rezfusion_components_update_item_data();
    $data = get_transient('rezfusion_hub_item_data');
    $query = new \WP_Query(array(
      'post_type' => get_option('rezfusion_hub_sync_items_post_type', 'vr_listing'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
    ));
    $ct = count($query->get_posts());
    $this->assertEquals(count($data->data->lodgingProducts->results), $ct);
    // Load each item by its Hub ID and check its metadata.
    foreach($data->data->lodgingProducts->results as $result) {

      // Verify the presence of a local post.
      $local_data = rezfusion_components_get_local_item($result->item->id);
      $post = get_post($local_data[0]['post_id']);
      $this->assertNotEmpty($post);

      // Verify beds/baths is set appropriately.
      $meta = get_post_meta($post->ID);
      $this->assertEquals(intval($meta['rezfusion_hub_beds'][0]), intval($result->beds));
      $this->assertEquals(intval($meta['rezfusion_hub_baths'][0]), intval($result->baths));

      // Verify that the terms are set correctly.
      $categories = get_transient('rezfusion_hub_category_data');
      if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
        foreach ($categories->data->categoryInfo->categories as $category) {

          // Build up an array of hub ids keyed by category name.
          $name = str_replace('-', '_', sanitize_title($category->name));
          $taxonomies[$name] = [];
          foreach($category->values as $value) {
            $taxonomies[$name][] = intval($value->id);
          }
          $terms = wp_get_post_terms($post->ID, $name);

          if (empty($result->item->category_values)) {
            // This item has no values. Assert there none tagged.
            $this->assertEmpty($terms);
          }
          else {
            $values = array_map(function($value) {
              return intval($value->value->id);
            }, $result->item->category_values);
            // Assert that this item has the right number of items tagged locally.
            $this->assertEquals(count(array_intersect($values, $taxonomies[$name])), count($terms));
          }
        }
      }
    }
  }

	public function tearDown(): void {
    parent::tearDown();
    delete_transient('rezfusion_hub_item_data');
    $query = new \WP_Query(array(
      'post_type' => get_option('rezfusion_hub_sync_items_post_type', 'vr_listing'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
    ));
    foreach($query->get_posts() as $p) {
      wp_delete_post($p->ID);
    }
  }
}

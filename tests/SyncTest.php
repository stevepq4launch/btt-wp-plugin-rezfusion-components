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
class SyncTest extends \PHPUnit\Framework\TestCase {

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

<?php

namespace Rezfusion\Tests;

/**
 * Class GqlTests
 *
 * @package Rezfusion_Components
 */

use Rezfusion\Client\NullCache;
use Rezfusion\Exception\HubCategoriesValidationException;
use Rezfusion\Helper\CategoriesItemsCounter;
use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;
use Rezfusion\Service\DataRefreshService;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\MockAPI_Client;
use Rezfusion\Tests\TestHelper\TestHelper;

/**
 * Test that we can still retrieve the various pieces of API data needed for the
 * plugin.
 */
class SyncTest extends BaseTestCase
{
  /**
   * Verify the client bootstraps.
   *
   * @throws \Exception
   */
  public function testSyncsPropertyData()
  {
    $client = Plugin::apiClient();
    $response = $client->getItems(get_rezfusion_option(Options::hubChannelURL()));
    $this->assertNotEmpty($response->data->lodgingProducts->results);
  }

  /**
   * Test that we properly sync items.
   *
   * @throws \Exception
   */
  public function testCreatesItemPosts()
  {
    TestHelper::refreshData();
    $client = Plugin::apiClient();
    $channel = get_rezfusion_option(Options::hubChannelURL());
    $data = $client->getItems($channel);
    $itemRepository = new ItemRepository($client);
    $query = new \WP_Query(array(
      'post_type' => get_rezfusion_option(Options::syncItemsPostType(), PostTypes::listing()),
      'post_status' => 'publish',
      'posts_per_page' => -1,
    ));
    $ct = count($query->get_posts());
    $this->assertEquals(count($data->data->lodgingProducts->results), $ct);
    // Load each item by its Hub ID and check its metadata.
    foreach ($data->data->lodgingProducts->results as $result) {

      // Verify the presence of a local post.
      $local_data = $itemRepository->getItemById($result->item->id);
      $post = get_post($local_data[0]['post_id']);
      $this->assertNotEmpty($post);

      // Verify beds/baths is set appropriately.
      $meta = get_post_meta($post->ID);
      $this->assertEquals(intval($meta[Metas::beds()][0]), intval($result->beds));
      $this->assertEquals(intval($meta[Metas::baths()][0]), intval($result->baths));

      // Verify that the terms are set correctly.
      $categories = $client->getCategories($channel);
      if (isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
        foreach ($categories->data->categoryInfo->categories as $category) {

          // Build up an array of hub ids keyed by category name.
          $name =  CategoryRepository::categoryMachineName($category->name);
          $taxonomies[$name] = [];
          foreach ($category->values as $value) {
            $taxonomies[$name][] = intval($value->id);
          }
          $terms = wp_get_post_terms($post->ID, $name);

          if (empty($result->item->category_values)) {
            // This item has no values. Assert there none tagged.
            $this->assertEmpty($terms);
          } else {
            $values = array_map(function ($value) {
              return intval($value->value->id);
            }, $result->item->category_values);
            // Assert that this item has the right number of items tagged locally.
            $this->assertEquals(count(array_intersect($values, $taxonomies[$name])), count($terms));
          }
        }
      }
    }
  }

  public function testCategoriesCount()
  {
    $API_Client = Plugin::getInstance()->apiClient();
    $CategoryRepository = new CategoryRepository($API_Client);
    $localCategories = $CategoryRepository->getCategories();
    $channel = Plugin::getInstance()->getOption(Options::hubChannelURL());
    $sourceCategories = $API_Client->getCategories($channel);
    $CategoriesItemsCounter = new CategoriesItemsCounter();
    $this->assertSame($CategoriesItemsCounter->count($sourceCategories), count($localCategories));
  }

  public function testCategoryNameChangedInSource()
  {
    (new DeleteDataService)->run();
    $MockAPI_Client = new MockAPI_Client(
      REZFUSION_PLUGIN_QUERIES_PATH,
      Plugin::getInstance()->getOption(Options::blueprintURL()),
      new NullCache()
    );
    $CategoryRepository = new CategoryRepository($MockAPI_Client);
    $DataRefreshService = new DataRefreshService($MockAPI_Client);
    $categories = [];
    $mockCategories = [
      "data" => [
        "categoryInfo" => [
          "categories" => [
            [
              "name" => "Amenities",
              "id" => 1000,
              "values" => [
                [
                  "name" => "Hot Tub",
                  "id" => 1001
                ],
                [
                  "name" => "TV",
                  "id" => 1002
                ]
              ]
            ]
          ]
        ]
      ]
    ];

    /* Create initial categories firs. */
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $DataRefreshService->run();
    $this->assertCount(2, $categories = $CategoryRepository->getCategories());
    $this->assertSame("Hot Tub", $categories[0]->name);
    $this->assertSame("hot-tub", $categories[0]->slug);
    $this->assertSame("TV", $categories[1]->name);
    $this->assertSame("tv", $categories[1]->slug);

    /* Change name (and slug) of first category. */
    $mockCategories['data']['categoryInfo']['categories'][0]["values"][0]["name"] = "Bigger Hot Tub";
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $DataRefreshService->run();
    $this->assertCount(2, $categories = $CategoryRepository->getCategories());
    $this->assertSame("Bigger Hot Tub", $categories[0]->name);
    $this->assertSame("bigger-hot-tub", $categories[0]->slug);
    $this->assertSame("TV", $categories[1]->name);
    $this->assertSame("tv", $categories[1]->slug);

    /* Change name (and slug) of second category. */
    $mockCategories['data']['categoryInfo']['categories'][0]["values"][1]["name"] = "Video Games";
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $DataRefreshService->run();
    $this->assertCount(2, $categories = $CategoryRepository->getCategories());
    $this->assertSame("Bigger Hot Tub", $categories[0]->name);
    $this->assertSame("bigger-hot-tub", $categories[0]->slug);
    $this->assertSame("Video Games", $categories[1]->name);
    $this->assertSame("video-games", $categories[1]->slug);

    /* Add third category. */
    $mockCategories['data']['categoryInfo']['categories'][0]["values"][] = [
      "name" => "Tennis Court",
      "id" => 1003
    ];
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $DataRefreshService->run();
    $this->assertCount(3, $categories = $CategoryRepository->getCategories());
    $this->assertSame("Bigger Hot Tub", $categories[0]->name);
    $this->assertSame("bigger-hot-tub", $categories[0]->slug);
    $this->assertSame("Video Games", $categories[2]->name);
    $this->assertSame("video-games", $categories[2]->slug);
    $this->assertSame("Tennis Court", $categories[1]->name);
    $this->assertSame("tennis-court", $categories[1]->slug);

    /* Remove second category. */
    array_splice($mockCategories['data']['categoryInfo']['categories'][0]["values"], 1, 1);
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $DataRefreshService->run();
    $this->assertCount(2, $categories = $CategoryRepository->getCategories());
    $this->assertSame("Bigger Hot Tub", $categories[0]->name);
    $this->assertSame("bigger-hot-tub", $categories[0]->slug);
    $this->assertSame("Tennis Court", $categories[1]->name);
    $this->assertSame("tennis-court", $categories[1]->slug);

    /* Second category gets the same ID as first. */
    $mockCategories['data']['categoryInfo']['categories'][0]["values"][1]['id'] = 1001;
    $MockAPI_Client->setCategories(json_decode(json_encode($mockCategories)));
    $this->expectException(HubCategoriesValidationException::class);
    $DataRefreshService->run();
  }

  public static function tearDownAfterClass(): void
  {
    (new DeleteDataService)->run();
  }
}

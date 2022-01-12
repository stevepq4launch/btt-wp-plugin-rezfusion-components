<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;

class PropertiesAd extends Shortcode
{

  /**
   * @var string
   */
  const INCLUDE_DETAILS_ATTR_KEY = "details";

  /**
   * @var string
   */
  protected $shortcode = "properties-ad";

  /**
   * Add 'beds', 'baths' and 'sleeps' keys and values to array reference from lodgingProduct object.
   * @param array $item
   * @param object $LodgingProduct
   * @return array
   */
  private function mergeInDetails(array &$item = [], object $lodgingProduct)
  {
    $item['beds'] = $lodgingProduct->beds;
    $item['baths'] = $this->LodgingProductHelper->getTotalBaths($lodgingProduct);
    $item['sleeps'] = $lodgingProduct->occ_total;
    return $item;
  }

  /**
   * @param array $atts
   * 
   * @return string
   */
  public function render($atts = []): string
  {
    $postIds = array();
    $itemIds = array();
    $results = array();
    $client = Plugin::apiClient();
    /**
     * @var bool
     */
    $includeDetails = false;

    $data = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemids' => '',
      'pids' => '',
      static::INCLUDE_DETAILS_ATTR_KEY => false
    ], $atts);

    $includeDetails = filter_var($data[static::INCLUDE_DETAILS_ATTR_KEY], FILTER_VALIDATE_BOOLEAN);

    if (!empty($data['pids'])) {
      $postIds = explode(',', $data['pids']);
      foreach ($postIds as $postId) {
        if ($postId && get_post_type($postId) == PostTypes::listing() && get_post_status($postId) != 'trash') {
          $itemIds[] = get_post_meta($postId, Metas::itemId())[0];
        }
      }
    } elseif (!empty($data['itemids'])) {
      $itemIds = explode(',', $data['itemids']);
    } else {
      $propertyArray = get_posts(array('numberposts' => 3, 'post_type' => PostTypes::listing(), 'orderby' => 'rand'));
      foreach ($propertyArray as $property) {
        $itemIds[] = get_post_meta($property->ID, Metas::itemId())[0];
      }
    }

    if (count($itemIds) > 3) {
      $itemIds = array_slice($itemIds, 0, 3);
    }

    $resultIndex = 0;

    foreach ($itemIds as $itemId) {
      $lodgingProduct = $client->getItem($itemId, $data['channel'])->data->lodgingProducts->results[0];
      $item = $lodgingProduct->item;
      $itemDerivatives = $item->images[0]->derivatives;
      $derivativeImage = $itemDerivatives[count($itemDerivatives) - 2];
      $results[$resultIndex]['alt'] = !empty($item->images[0]->description) ? $item->images[0]->description : $item->images[0]->title;
      $results[$resultIndex]['image'] = $derivativeImage->url;
      $results[$resultIndex]['name'] = $item->name;
      $results[$resultIndex]['url'] = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($item->name)));
      $results[$resultIndex]['slug'] = (get_rezfusion_option(Options::customListingSlug())) ?: 'vacation-rentals';
      ($includeDetails === true) && $this->mergeInDetails($results[$resultIndex], $lodgingProduct);
      $resultIndex++;
    }

    return $this->template->render([
      'lodgingItems' => $results,
      'includeDetails' => $includeDetails
    ], true);
  }
}

<?php
/**
 * @file - Provide a shortcode for rendering a single item.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Factory\FloorPlanRepositoryFactory;
use Rezfusion\Options;
use Rezfusion\Plugin;

class LodgingItemDetails extends Shortcode {

  protected $shortcode = 'rezfusion-lodging-item';

  /**
   * @param array $atts
   *
   * @return string
   * @throws \Exception
   */
  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemid' => $atts['itemid']
    ], $atts );

    if(!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);
    $FloorPlanRepository = (new FloorPlanRepositoryFactory)->make();
    set_query_var('hasFloorPlan', $FloorPlanRepository->hasFloorPlan($a['itemid'], get_the_ID()));

    return $this->template->render([
      'categoryInfo' => $result->data->categoryInfo,
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]);
  }

}

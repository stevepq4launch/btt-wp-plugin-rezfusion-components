<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Plugin;

class LodgingItemFavoriteToggle extends  Shortcode
{
  protected $shortcode = 'rezfusion-favorite-toggle';

  public function render($atts = []): string
  {
    global $post;
    $meta = get_post_meta($post->ID);
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemid' => !empty($meta['rezfusion_hub_item_id']) ? $meta['rezfusion_hub_item_id'][0] : $atts['itemid'],
      'type' => 'small',
    ], $atts);

    if (!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $favoritesEnabled = get_rezfusion_option(Options::enableFavorites());
    $favoritesChannel = $a['channel'];

    add_action('wp_footer', function () use ($favoritesChannel, $favoritesEnabled) { ?>
      <script> REZFUSION_COMPONENTS_CONF = { "settings": { "favorites": { "enable": <?php print json_encode($favoritesEnabled); ?> }, "components": { "SearchProvider": { "channels": <?php print json_encode($favoritesChannel); ?> } } } }; </script>
     <?php });

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0],
      'type' => $a['type'],
    ]);
  }
}

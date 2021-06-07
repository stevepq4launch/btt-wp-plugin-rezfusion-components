<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class Favorites extends Shortcode {
  protected $shortcode = 'rezfusion-favorites';

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_option('rezfusion_hub_channel'),
      'mapApiKey' => get_option( 'rezfusion_hub_google_maps_api_key'),
      'endPoint' => 'https://blueprint.rezfusion.com/graphql',
    ], $atts);

    $favoritesEnabled = isset(get_option('rezfusion_hub_enable_favorites')['1']) ? true : false;
    $favoritesChannel = $a['channel'];
    $favoritesApiKey = $a['mapApiKey'];
    $favoritesEndPoint = $a['endPoint'];

    add_action( 'wp_footer', function () use ($favoritesApiKey, $favoritesChannel, $favoritesEnabled, $favoritesEndPoint){ ?>
      <script>REZFUSION_COMPONENTS_CONF = { "settings": { "favorites": { "enable": <?php print json_encode($favoritesEnabled); ?> }, "components": { "SearchProvider":{ "channels": <?php print json_encode($favoritesChannel); ?>, "endpoint": <?php print json_encode($favoritesEndPoint) ?>, }, "Map":{ "id": "result-map", "apiKey": <?php print json_encode($favoritesApiKey); ?> } } }};</script>
    <?php });

    return $this->template->render();
  }
}

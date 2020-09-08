<?php
/**
 * @file - Render a favorites flag fit for a single item display.
 */

namespace Rezfusion\Shortcodes;

class ItemFlag extends Shortcode {

  protected $shortcode = 'rezfusion-item-flag';

  public function render($atts = []): string {
    $a = shortcode_atts([
      'namespace' => get_option('rezfusion_hub_favorites_namespace', 'rezfusion-favorites'),
      'itemid' => $atts['itemid']
    ], $atts );

    wp_enqueue_script(
      'rezfusion_components_flag',
      plugins_url('rezfusion-components/dist/bundle.js')
    );

    wp_enqueue_style(
      'rezfusion_components_flag',
      plugins_url('rezfusion-components/assets/css/favorites.css')
    );

    return $this->template->render($a);
  }

}

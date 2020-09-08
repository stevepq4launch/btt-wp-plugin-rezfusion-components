<?php
/**
 * @file - Provide a simple
 */

namespace Rezfusion\Shortcodes;


class Component extends Shortcode {

  protected $shortcode = 'rezfusion-component';

  public function render($atts = []): string {
    $a = shortcode_atts([
      'element' => 'search',
      'id' => 'app',
      'channel' => get_option('rezfusion_hub_channel'),
      'url' => get_option('rezfusion_hub_folder'),
    ], $atts );

    if(!$a['channel'] || !$a['url']) {
      return "Rezfusion Component: A 'channel' and a 'URL' attribute are both required";
    }

    $handle = "{$a['channel']}-{$a['element']}";

    wp_enqueue_script(
      $handle,
      $a['url']
    );

    if($a['element'] === 'details-page' && $post = get_post()) {
      $meta = get_post_meta($post->ID);
      if($meta['rezfusion_hub_item_id']) {
        wp_localize_script(
          $handle,
          'REZFUSION_COMPONENTS_CONF',
          [
            'settings' => [
              'components' => [
                'DetailsPage' => [
                  'id' => $meta['rezfusion_hub_item_id'][0],
                ],
              ],
            ],
          ]
        );
      }
    }

    if(is_tax()) {
      $object = get_queried_object();
      $meta = get_term_meta($object->term_id);
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'components' => [
              'SearchProvider' => [
                'filters' => [
                  'categoryFilter' => [
                    'categories' => [
                      [
                        'cat_id' => $meta['rezfusion_hub_category_id'][0],
                        'values' => $meta['rezfusion_hub_category_value_id'],
                        'operator' => 'AND',
                      ],
                    ],
                  ],
                ],
              ],
            ],
          ],
        ]
      );
    }

    return $this->template->render($a);
  }

}

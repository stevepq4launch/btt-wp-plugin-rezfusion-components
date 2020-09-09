<?php

/**
 * @file - Provide a simple
 */

namespace Rezfusion\Shortcodes;


class Component extends Shortcode
{

  protected $shortcode = 'rezfusion-component';

  public function render($atts = []): string
  {
    $a = shortcode_atts([
      'element' => 'search',
      'id' => 'app',
      'channel' => get_option('rezfusion_hub_channel'),
      'url' => get_option('rezfusion_hub_folder'),
    ], $atts);

    if (!$a['channel'] || !$a['url']) {
      return "Rezfusion Component: A 'channel' and a 'URL' attribute are both required";
    }

    $handle = "{$a['channel']}-{$a['element']}";

    wp_enqueue_script(
      $handle,
      $a['url']
    );

    $favoritesEnabled = isset(get_option('rezfusion_hub_enable_favorites')['1']) ? true : false;

    if ($a['element'] == 'search') {
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ]
          ]
        ]
      );
    }

    if ($a['element'] === 'details-page' && $post = get_post()) {
      $meta = get_post_meta($post->ID);
      if ($meta['rezfusion_hub_item_id']) {
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

    if (is_tax()) {
      $object = get_queried_object();
      $meta = get_term_meta($object->term_id);
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ],
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

    if (get_post_type() == 'vr_promo') {
      $promoIds = [];
      foreach (get_post_meta(get_post()->ID, 'rzf_promo_listing_value')[0] as $listing) {
        $meta = get_post_meta($listing);
        array_push($promoIds, $meta['rezfusion_hub_item_id'][0]);
      }
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ],
            'components' => [
              'SearchProvider' => [
                'filters' => [
                  'itemIds' => $promoIds,
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

<?php
/**
 * @file - Query for data from blueprint.
 */

/**
 * Make an HTTP request to get item data.
 *
 * @todo: This needs to be able to pass a param for "updated_ts"
 * @todo: ^^ Blueprint needs to support that, too.
 *
 * @param $channel
 *
 * @return array|mixed|object
 */
function rezfusion_components_get_items($channel) {
  $query = <<<'JSON'
query($channels:ChannelFilter!) {
  lodgingProducts(channels:$channels) {
    results {
      beds
      baths
      item {
        id
        name
      }
    }
  }
}
JSON;

  $variables = [
    'channels' => [
      'url' => $channel,
    ]
  ];

  $json = json_encode(['query' => $query, 'variables' => $variables]);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, rezfusion_components_get_blueprint_url());
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json;charset=utf-8',
    ]
  );

  $response = curl_exec($ch);
  return json_decode($response);
}

/**
 * Update item data.
 *
 * This function runs on save of the form.
 *
 * @param null $channel
 *
 * @return bool
 */
function rezfusion_components_cache_item_data($channel = NULL) {
  if(!$channel) {
    $channel = get_option('rezfusion_hub_channel');
  }

  $data = rezfusion_components_get_items($channel);

  if(!empty($data)) {
    set_transient('rezfusion_hub_item_data', $data);
    return TRUE;
  }

  return FALSE;
}

function rezfusion_components_update_item_data($channel = NULL) {
  // Warm the cache, and get the items from there.
  rezfusion_components_cache_item_data($channel);
  $items = get_transient('rezfusion_hub_item_data');

  // By default we will sync into the `vr_listing` post type.
  $post_type = get_option('rezfusion_hub_sync_items_post_type', 'vr_listing');

  $args = [
    'post_type' => [$post_type],
    'nopaging' => TRUE,
  ];

  $query = new WP_Query($args);
  // Rekey the array by ID.
  $local_items = array_reduce($query->posts, function($carry, $item) {
    if(!empty($item->ID)) {
      $meta = get_post_meta($item->ID);
      $carry[$meta['rezfusion_hub_item_id'][0]] = $item;
    }
    return $carry;
  }, []);

  if (isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) {
    foreach($items->data->lodgingProducts->results as $result) {
      $id = $result->item->id;
      $data = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'post_title' => $result->item->name,
        'meta_input' => [
          'rezfusion_hub_item_id' => $result->item->id,
          'rezfusion_hub_beds' => $result->beds,
          'rezfusion_hub_baths' => $result->baths,
        ],
      ];
      if(!empty($local_items[$id])) {
        wp_update_post([
          'ID' => $local_items[$id]->ID,
        ] + $data);
        // Remove from the list. This'll
        // let us know which items
        // need to unpublished.
        unset($local_items[$id]);
      }
      else {
        wp_insert_post($data);
      }
    }

    // These are missing from Blueprint.
    // So unpublish them.
    if(!empty($local_items)) {
      $data = [
        'post_status' => 'draft',
      ];
      foreach($local_items as $local_item) {
        wp_update_post([
            'ID' => $local_item->ID,
          ] + $data);
      }
    }
  }
}
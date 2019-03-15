<?php
/**
 * @file - Query for data from blueprint.
 */

function rezfusion_components_get_item_ids($channel) {
  $query = <<<'JSON'
query($channels:ChannelFilter!) {
  lodgingProducts(channels:$channels) {
    results {
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
  curl_setopt($ch, CURLOPT_URL, rezfusion_component_get_blueprint_url());
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json;charset=utf-8',
    ]
  );

  $response = curl_exec($ch);
  curl_close($ch);
  return json_decode($response);
}

<?php
/**
 * @file - Provide a client which communicates with blueprint via curl
 * calls.
 */

namespace Rezfusion\Client;

class CurlClient extends Client {

  /**
   * @param $query
   * @param array $variables
   *
   * @return array|mixed|object
   * @throws \Exception
   */
  public function request($query, $variables = []) {
    $json = json_encode(['query' => $query, 'variables' => $variables]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json;charset=utf-8',
      ]
    );

    $response = curl_exec($ch);

    if($err = curl_errno($ch)) {
      throw new \Exception("Rezfusion Blueprint connection exception. Curl err: $err");
    }

    return json_decode($response);
  }

}

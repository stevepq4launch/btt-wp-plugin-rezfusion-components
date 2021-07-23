<?php

namespace Rezfusion\Repository;

class LodgingProductRepository extends AbstractHubRepository
{

  /**
   * Fetch lodging products by ids.
   * 
   * @return array
   */
  public function findByIds(array $ids = [])
  {
    $client = $this->client;
    $query = $client->getQuery($client->getQueriesBasePath() . "/featured-properties.graphql");
    $data = $client->call($query, [
      'channels' => [
        'url' => $this->channel,
      ],
      'itemIds' => $ids
    ]);
    return $data->data->lodgingProducts->results;
  }
}

<?php

namespace Rezfusion\Repository;

use Rezfusion\Client\ClientInterface;

abstract class AbstractHubRepository
{

  /**
   * @var \Rezfusion\Client\ClientInterface
   */
  protected $client;

  protected $channel;

  /**
   * Provide a way to inject an API client as it is needed.
   *
   * @param \Rezfusion\Client\ClientInterface $client
   */
  public function __construct(ClientInterface $client, $channel)
  {
    $this->client = $client;
    $this->channel = $channel;
  }
}

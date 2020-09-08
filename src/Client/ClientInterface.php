<?php
/**
 * @file - Define the few API calls that need to be made to get information
 * from Hub.
 *
 * @see Rezfusion Blueprint documentation for information on these shapes.
 */

namespace Rezfusion\Client;

interface ClientInterface {

  /**
   * ClientInterface constructor.
   *
   * @param $queriesBasePath
   * @param string $url
   * @param \Rezfusion\Client\Cache|NULL $cache
   */
  public function __construct($queriesBasePath, $url, Cache $cache = null);

  /**
   * @param $channel
   *
   * @return mixed
   */
  public function getItems($channel);

  /**
   * @param $itemId
   * @param $channel
   *
   * @return mixed
   */
  public function getItem($itemId, $channel);

  /**
   * @param $channel
   *
   * @return mixed
   */
  public function getCategories($channel);

  /**
   * @return \Rezfusion\Client\Cache
   */
  public function getCache(): Cache;

  /**
   * @param \Rezfusion\Client\Cache|NULL $cache
   *
   * @return void
   */
  public function setCache(Cache $cache = null);

  /**
   * Make a call to Blueprint to retrieve information.
   *
   * @param $query
   * @param array $variables
   *
   * @return mixed
   */
  public function call($query, $variables = []);

}

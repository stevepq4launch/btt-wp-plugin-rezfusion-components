<?php
/**
 * @file - Provide some common methods for loading queries and other utilities.
 */
namespace Rezfusion\Client;

/**
 * Class Client
 *
 * @package Rezfusion\Client
 */
abstract class Client implements ClientInterface {

  /**
   * A lookup table of paths to strings.
   *
   * @var array
   */
  protected $queries = [];

  /**
   * Provide a path where queries are stored.
   *
   * @var $queriesBasePath
   */
  protected $queriesBasePath;

  /**
   * @var string
   */
  protected $url;

  /**
   * @var \Rezfusion\Client\Cache
   */
  protected $cache;

  /**
   * Client constructor.
   *
   * @param $queriesBasePath
   * @param string $url
   * @param \Rezfusion\Client\Cache|NULL $cache
   */
  public function __construct($queriesBasePath, $url = 'https://blueprint.rezfusion.com', Cache $cache = null) {
    $this->queriesBasePath = $queriesBasePath;
    $this->url = $url;
    $this->cache = $cache;
  }

  /**
   * @return \Rezfusion\Client\Cache
   */
  public function getCache(): Cache {
    return $this->cache;
  }

  /**
   * @param \Rezfusion\Client\Cache $cache
   */
  public function setCache(Cache $cache = null): void {
    $this->cache = $cache;
  }

  /**
   * @param $channel
   * @param null $query
   *
   * @return mixed
   * @throws \Exception
   */
  public function getItems($channel, $query = null) {
    $variables = [
      'channels' => [
        'url' => $channel,
      ]
    ];

    if(!$query) {
      $query = $this->getQuery("$this->queriesBasePath/items.graphql");
    }
    return $this->call($query, $variables);
  }

  /**
   * @param $itemId
   * @param $channel
   * @param null $query
   *
   * @return mixed
   * @throws \Exception
   */
  public function getItem($itemId, $channel, $query = null) {
    $variables = [
      'channels' => [
        'url' => $channel,
      ],
      'itemIds' => [$itemId]
    ];
    if(!$query) {
      $query = $this->getQuery("$this->queriesBasePath/item.graphql");
    }
    return $this->call($query, $variables);
  }

  /**
   * @param $channel
   * @param null $query
   *
   * @return mixed
   * @throws \Exception
   */
  public function getCategories($channel, $query = null) {
    $variables = [
      'channels' => [
        'url' => $channel,
      ]
    ];
    if(!$query) {
      $query = $this->getQuery("$this->queriesBasePath/categoryinfo.graphql");
    }
    return $this->call($query, $variables);
  }

  /**
   * Retrieve a graphql query from a separate file.
   *
   * @param $path
   *
   * @return string
   * @throws \Exception
   */
  public function getQuery($path) {
    if (!file_exists($path)) {
      throw new \Exception("Path for query: $path. Was not found.");
    }
    if (!isset($this->queries[$path])) {
      $this->queries[$path] = file_get_contents($path);
    }
    return $this->queries[$path];
  }

  /**
   * Make a cache key for the call.
   *
   * @param $query
   * @param array $variables
   *
   * @return string
   */
  public static function cacheKey($query, $variables = []) {
    return md5($query) . ":" . md5(serialize($variables));
  }

  /**
   * Public API which wraps the HTTP request method.
   *
   * @param $query
   * @param array $variables
   *
   * @return mixed
   */
  public function call($query, $variables = []) {
    $key = self::cacheKey($query, $variables);

    if($this->cache && ($this->cache->getMode() & $this->cache::MODE_READ) && $this->cache->has($key)) {
      return $this->cache->get($key);
    }

    $response = $this->request($query, $variables);
    if($this->cache && ($this->cache->getMode() & $this->cache::MODE_WRITE)) {
      $this->cache->set($key, $response);
    }
    return $response;
  }

  /**
   * This is the internal API provided to clients for initiating a request
   * to the Blueprint service.
   *
   * @param $query
   * @param array $variables
   *
   * @return mixed
   */
  abstract protected function request($query, $variables = []);
}

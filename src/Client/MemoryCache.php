<?php
/**
 * @file - a Cache implementation used for testing purposes. But
 * could be useful in other contexts.
 */

namespace Rezfusion\Client;

class MemoryCache extends Cache {

  /**
   * @var array
   */
  protected $memoryCache = [];

  /**
   * @return array
   */
  public function getMemoryCache() {
    return $this->memoryCache;
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function get($key) {
    return $this->memoryCache[$key];
  }

  /**
   * @param $key
   * @param $data
   *
   * @return mixed|void
   */
  public function set($key, $data) {
    $this->memoryCache[$key] = $data;
  }

  /**
   * @param $key
   *
   * @return bool|mixed
   */
  public function has($key) {
    return isset($this->memoryCache[$key]);
  }

  /**
   * @param $key
   *
   * @return mixed|void
   */
  public function delete($key) {
    unset($this->memoryCache[$key]);
  }
}

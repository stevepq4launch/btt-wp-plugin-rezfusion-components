<?php
/**
 * @file - Provide a cache contract for Blueprint API data.
 */

namespace Rezfusion\Client;

abstract class Cache {

  /**
   * Determine whether the cache should read, write, or both.
   */
  const MODE_READ = 1;
  const MODE_WRITE = 2;

  /**
   * By default the transient cache reads and writes.
   *
   * @var int
   */
  protected $mode = Cache::MODE_READ | Cache::MODE_WRITE;

  /**
   * Set the bitmask mode for READ/WRITE.
   *
   * This is useful when updating information and you want to skip reading
   * the cache. But still write to it.
   *
   * @param int $mode
   *
   * @return mixed
   */
  public function setMode(int $mode): void {
    $this->mode = $mode;
  }

  /**
   * Get the current read/write mode.
   *
   * @return int
   */
  public function getMode(): int {
    return $this->mode;
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  abstract public function get($key);

  /**
   * @param $key
   * @param $data
   *
   * @return mixed
   */
  abstract public function set($key, $data);

  /**
   * @param $key
   *
   * @return mixed
   */
  abstract public function has($key);

  /**
   * @param $key
   *
   * @return mixed
   */
  abstract public function delete($key);

}

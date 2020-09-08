<?php
/**
 * @file - Provide a cache contract for Blueprint API data.
 */

namespace Rezfusion\Client;

interface Cache {

  /**
   * Determine whether the cache should read, write, or both.
   */
  const MODE_READ = 1;
  const MODE_WRITE = 2;

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
  public function setMode(int $mode);

  /**
   * Get the current read/write mode.
   *
   * @return int
   */
  public function getMode(): int;

  /**
   * @param $key
   *
   * @return mixed
   */
  public function get($key);

  /**
   * @param $key
   * @param $data
   *
   * @return mixed
   */
  public function set($key, $data);

  /**
   * @param $key
   *
   * @return mixed
   */
  public function has($key);

  /**
   * @param $key
   *
   * @return mixed
   */
  public function delete($key);

}

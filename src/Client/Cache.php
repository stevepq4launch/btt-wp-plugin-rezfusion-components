<?php
/**
 * @file - Provide a cache contract for Blueprint API data.
 */

namespace Rezfusion\Client;

interface Cache {

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

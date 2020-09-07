<?php
/**
 * @file - Provide a cache class that works with WP transients.
 */

namespace Rezfusion\Client;

use Rezfusion\Plugin;

class TransientCache implements Cache {

  /**
   * By default the transient cache reads and writes.
   *
   * @var int
   */
  protected $mode = Cache::MODE_READ & Cache::MODE_WRITE;

  /**
   * @return int
   */
  public function getMode(): int {
    return $this->mode;
  }

  /**
   * @param int $mode
   */
  public function setMode(int $mode): void {
    $this->mode = $mode;
  }

  /**
   * @param $key
   *
   * @return string
   */
  private function key($key) {
    return Plugin::PREFIX . "_$key";
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function get($key) {
    return json_decode(get_transient($this->key($key)));
  }

  /**
   * @param $key
   * @param $data
   *
   * @return bool|mixed
   */
  public function set($key, $data) {
    return set_transient($this->key($key), $data);
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function has($key) {
    return !!get_transient($this->key($key));
  }

  /**
   * @param $key
   *
   * @return bool|mixed
   */
  public function delete($key) {
    return delete_transient($this->key($key));
  }

}

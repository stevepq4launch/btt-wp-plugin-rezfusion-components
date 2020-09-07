<?php
/**
 * @file - Invoke display of a simple list of items.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

class ItemInfoPage extends Page {

  /**
   * Display the list of API items.
   *
   * @return mixed|void
   * @throws \Exception
   */
  public function display() {
    $client = Plugin::apiClient();
    $channel = get_option('rezfusion_hub_channel');
    print $this->template->render(['items' => $client->getItems($channel)]);
  }

}

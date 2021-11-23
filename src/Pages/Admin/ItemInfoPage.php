<?php
/**
 * @file - Invoke display of a simple list of items.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Options;
use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

class ItemInfoPage extends Page {

  /**
   * @var string
   */
  const PAGE_NAME = 'rezfusion_components_item_info';

  /**
   * Display the list of API items.
   *
   * @return void
   * @throws \Exception
   */
  public function display(): void {
    $client = Plugin::apiClient();
    $channel = get_rezfusion_option(Options::hubChannelURL());
    print $this->template->render(['items' => $client->getItems($channel)]);
  }

}

<?php
/**
 * @file - Render a simple page that displays the raw data from the API
 * for categories.
 */
namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

class CategoryInfoPage extends Page {

  /**
   * Display the category data from the API.
   *
   * @return mixed|void
   * @throws \Exception
   */
  public function display() {
    $client = Plugin::apiClient();
    $channel = get_option('rezfusion_hub_channel');
    print $this->template->render(['categories' => $client->getCategories($channel)]);
  }
}

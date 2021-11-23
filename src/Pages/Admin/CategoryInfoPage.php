<?php
/**
 * @file - Render a simple page that displays the raw data from the API
 * for categories.
 */
namespace Rezfusion\Pages\Admin;

use Rezfusion\Options;
use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

class CategoryInfoPage extends Page {

  /**
   * @var string
   */
  const PAGE_NAME = 'rezfusion_components_category_info';

  /**
   * Display the category data from the API.
   *
   * @return mixed|void
   * @throws \Exception
   */
  public function display():void {
    $client = Plugin::apiClient();
    $channel = get_rezfusion_option(Options::hubChannelURL());
    print $this->template->render(['categories' => $client->getCategories($channel)]);
  }
}

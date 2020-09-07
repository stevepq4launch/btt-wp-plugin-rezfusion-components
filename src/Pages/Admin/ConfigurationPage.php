<?php
/**
 * @file - Render a page for entering rezfusion
 * configuration options.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

class ConfigurationPage extends Page {

  /**
   * This will display a settings form.
   *
   * @see \Rezfusion\Plugin::registerPages()
   * @see \Rezfusion\Plugin::registerSettings()
   *
   * @return mixed|void
   */
  public function display() {
    if (!empty($_POST)) {
      $this->save($_POST);
    }
    print $this->template->render();
  }

  /**
   * Save the form we displayed on the page.
   *
   * @param $values
   */
  protected function save($values) {
    $keys = [
      'rezfusion_hub_channel',
      'rezfusion_hub_folder',
      'rezfusion_hub_env',
      'rezfusion_hub_redirect_urls',
      'rezfusion_hub_sync_items',
      'rezfusion_hub_sync_items_post_type',
    ];

    foreach ($keys as $key) {
      update_option($key, $values[$key]);
    }

    if (!empty($values['rezfusion_hub_fetch_data'])) {
      try {
        Plugin::refreshData();
        flush_rewrite_rules();
        show_message('Data updated.');
      } catch (\Exception $e) {
        show_message('Data not updated.');
      }
    }
  }
}

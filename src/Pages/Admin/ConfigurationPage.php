<?php
/**
 * @file - Render a page for entering rezfusion
 * configuration options.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Options;
use Rezfusion\Factory\ValuesCleanerFactory;
use Rezfusion\Pages\Page;
use Rezfusion\Plugin;

session_start();

class ConfigurationPage extends Page {

  /**
   * @var string
   */
  const PAGE_NAME = 'rezfusion_components_config';

  /**
   * @var string
   */
  const GENERAL_TAB_NAME = 'general';

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
    switch ($_SESSION['savetab']) {
      case 'general':
        $keys = [
          'rezfusion_hub_channel',
          'rezfusion_hub_folder',
          'rezfusion_hub_env',
          'rezfusion_hub_sps_domain',
          'rezfusion_hub_conf_page',
          'rezfusion_hub_redirect_urls',
          'rezfusion_hub_sync_items',
          'rezfusion_hub_sync_items_post_type',
          'rezfusion_hub_enable_favorites',
          'rezfusion_hub_google_maps_api_key',
          'rezfusion_hub_custom_listing_slug',
          'rezfusion_hub_custom_promo_slug',
          'rezfusion_hub_promo_code_flag_text'
        ];
        break;
      case 'policies':
        $keys  = [
          'rezfusion_hub_policies_general',
          'rezfusion_hub_policies_pets',
          'rezfusion_hub_policies_payment',
          'rezfusion_hub_policies_cancellation',
          'rezfusion_hub_policies_changing',
          'rezfusion_hub_policies_insurance',
          'rezfusion_hub_policies_cleaning',
        ];
        break;
      case 'amenities':
        $keys = [
          'rezfusion_hub_amenities_featured',
          'rezfusion_hub_amenities_general',
        ];
        break;
      case 'forms':
        $keys = [
          'rezfusion_hub_review_btn_text',
          'rezfusion_hub_review_form',
          'rezfusion_hub_inquiry_btn_text',
          'rezfusion_hub_inquiry_form',
        ];
        break;
      case 'featured-properties':
        $keys = [
          Options::featuredPropertiesUseIcons(),
          Options::featuredPropertiesBedsLabel(),
          Options::featuredPropertiesBathsLabel(),
          Options::featuredPropertiesSleepsLabel(),
          Options::featuredPropertiesIds()
        ];
        break;
    }

    $values = (new ValuesCleanerFactory)->make()->clean($values);

    foreach ($keys as $key) {
      if ( isset($_POST[$key]) && !empty($_POST[$key])) {
        update_option($key, $values[$key]);
      } else {
        update_option($key, NULL);
      }
    }
    
    if (!empty(get_option( 'rezfusion_hub_folder' ))) {
      $themeUrl = null;
      $bundle = file(get_option( 'rezfusion_hub_folder' ), FILE_SKIP_EMPTY_LINES);
      foreach ($bundle as $key => $value) {
        preg_match('~https://rezfusion-components-storage.*\.css~', $value, $match);
        if (!empty($match)) {
          $themeUrl .= $match[0];
        }
      }
      
      update_option('rezfusion_hub_theme', $themeUrl);
    } else {
      update_option( 'rezfusion_hub_theme', NULL );
    }

    if (!empty($values['rezfusion_hub_fetch_data'])) {
      try {
        Plugin::refreshData();
        add_action( 'admin_notices', function ()
        { ?>
          <div class="notice notice-success is-dismissible">
            <p><?php echo 'Item data refreshed.'; ?></p>
          </div>
        <?php } );
      } catch (\Exception $e) {
        add_action( 'admin_notices', function ()
        { ?>
          <div class="notice notice-error is-dismissible">
            <p><?php echo 'Item data not refreshed.'; ?></p>
          </div>
        <?php } );
      }
    }
    
    update_option('rezfusion_trigger_rewrite_flush', 1);

    add_action('admin_notices', function ()
    { ?>
      <div class="notice notice-success is-dismissible">
        <p><?php echo 'Settings saved.'; ?></p>
      </div>
    <?php });

  }

  /**
   * @return string
   */
  public static function pageName(){
    return static::PAGE_NAME;
  }

  /**
   * @return string
   */
  public static function generalTabName(){
    return static::GENERAL_TAB_NAME;
  }
}

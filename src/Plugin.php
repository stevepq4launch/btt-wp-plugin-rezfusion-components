<?php
/**
 * @file - Provide a plugin instance class that boostraps hooks.
 */

namespace Rezfusion;

use Rezfusion\Client\Cache;
use Rezfusion\Client\CurlClient;
use Rezfusion\Client\TransientCache;
use Rezfusion\Metaboxes\Metabox;
use Rezfusion\Pages\Admin\ConfigurationPage;
use Rezfusion\Pages\Admin\CategoryInfoPage;
use Rezfusion\Pages\Admin\ItemInfoPage;
use Rezfusion\PostTypes\VRListing;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Shortcodes\Component;
use Rezfusion\Shortcodes\ItemFlag;
use Rezfusion\Shortcodes\LodgingItemDetails;

class Plugin {

  const PREFIX = "rzf";

  const VR_LISTING_NAME = "vr_listing";

  /**
   * @var \Rezfusion\Plugin
   */
  public static $instance;

  /**
   * @var \Rezfusion\Client\Client
   */
  public static $apiClient;

  /**
   * Plugin constructor.
   *
   * Private to enforce this class a singleton that binds
   * hooks only once.
   */
  private function __construct() {
    $this->registerPostTypes();
    $this->registerMetaboxes();
    add_action('init', [$this, 'registerShortcodes']);
    add_action('init', [$this, 'registerRewriteTags']);
    add_action('admin_menu', [$this, 'registerPages']);
    add_action('admin_init', [$this, 'registerSettings']);
    add_action('template_redirect', [$this, 'templateRedirect']);
    add_action('wp_head', [$this, 'wpHead']);
  }

  /**
   * Create the plugin instance. The main `rezfusion-components` plugin file
   * initializes itself using this function.
   *
   * @return \Rezfusion\Plugin
   */
  public static function getInstance() {
    if(!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  /**
   * Add a rewrite tag for the query parameter that components uses to identify
   * items in the API.
   */
  public function registerRewriteTags() {
    add_rewrite_tag('%pms_id%', '([^&]+)');
  }

  /**
   * Add metaboxes as needed.
   */
  public function registerMetaboxes() {
    new Metabox(
      'lodging-item-info',
      new Template('lodging-item-info.php', REZFUSION_PLUGIN_TEMPLATES_PATH . '/admin/metaboxes'),
      __('Property Information'),
      [self::VR_LISTING_NAME]
    );
  }

  /**
   * Register custom post types.
   */
  public function registerPostTypes() {
     new VRListing(self::VR_LISTING_NAME);
  }

  /**
   * Add admin settings.
   */
  public function registerSettings() {
    register_setting( 'rezfusion-components', 'rezfusion_hub_channel');
    register_setting( 'rezfusion-components', 'rezfusion_hub_folder');
    register_setting( 'rezfusion-components', 'rezfusion_hub_env');
    register_setting( 'rezfusion-components', 'rezfusion_hub_sync_items_post_type');
  }

  /**
   * Add pages to the admin menu.
   */
  public function registerPages() {
    $configTemplate = new Template('configuration.php', REZFUSION_PLUGIN_TEMPLATES_PATH . "/admin");
    $configPage = new ConfigurationPage($configTemplate);
    add_menu_page(
      'Rezfusion Components',
      'Rezfusion',
      'administrator',
      'rezfusion_components_config',
      [$configPage, 'display']
    );

    $itemInfoTemplate = new Template('lodging-item.php', REZFUSION_PLUGIN_TEMPLATES_PATH . "/admin");
    $itemInfoPage = new ItemInfoPage($itemInfoTemplate);
    add_submenu_page(
      'rezfusion_components_config',
      'Items',
      'Items',
      'administrator',
      'rezfusion_components_items',
      [$itemInfoPage, 'display']
    );

    $categoryInfoTemplate = new Template('category-info.php', REZFUSION_PLUGIN_TEMPLATES_PATH . "/admin");
    $categoryInfoPage = new CategoryInfoPage($categoryInfoTemplate);
    add_submenu_page(
      'rezfusion_components_config',
      'Categories',
      'Categories',
      'administrator',
      'rezfusion_components_categories',
      [$categoryInfoPage, 'display']
    );
  }

  /**
   * @throws \Exception
   */
  public function registerShortcodes() {
    new Component(new Template('vr-component.php'));
    new LodgingItemDetails(new Template('vr-details-page.php'));
    new ItemFlag(new Template('vr-item-flag.php'));
  }

  /**
   * Attach output to WP head.
   */
  public function wpHead() {
    $urlMap = new Template('vr-url-map.php');
    print $urlMap->render();
  }

  /**
   * Redirect users to the property details page.
   *
   * @todo: Propbably deprecate this. As I suspect there is a more "wordpress-y"
   * @todo: way to do this.
   */
  public function templateRedirect() {
    $redirect = get_option('rezfusion_hub_redirect_urls');
    $repository = new \Rezfusion\Repository\ItemRepository(self::apiClient());
    if ( $redirect && isset($_GET['pms_id']) ) {
      $id = sanitize_text_field($_GET['pms_id']);
      $posts = $repository->getItemById($id);
      if(!empty($posts) && $link = get_permalink($posts[0]['post_id'])) {
        wp_redirect($link, 301);
        exit();
      }
    }
  }

  /**
   * Get the configured environment.
   *
   * @return string
   */
  public static function env() {
    $env = get_option('rezfusion_hub_env', 'prd');
    if(empty($env)) {
      return 'prd';
    }

    return $env;
  }

  /**
   * Get the blueprint URL.
   *
   * @return string
   */
  public static function blueprint() {
    $env = self::env();
    if($env === 'prd') {
      return "https://blueprint.rezfusion.com/graphql";
    }
    return "https://blueprint.hub-stg.rezfusion.com/graphql";
  }

  /**
   * Provide a factory method for the api client instance for the
   * application.
   *
   * The client's design is such that each method takes a `$channel` param. So
   * that we can use the client as a singleton.
   *
   * @return \Rezfusion\Client\Client|\Rezfusion\Client\CurlClient
   */
  public static function apiClient() {
    return new CurlClient(REZFUSION_PLUGIN_QUERIES_PATH, self::blueprint(), new TransientCache());
  }

  /**
   * Refresh API data.
   */
  public static function refreshData() {
    $client = Plugin::apiClient();
    // During a refresh cycle, we want to skip the read on cache hits.
    // But still write during the end of the cycle.
    $cache = $client->getCache();
    $mode = $cache->getMode();
    $cache->setMode(Cache::MODE_WRITE);
    $channel = get_option('rezfusion_hub_channel');
    $repository = new ItemRepository($client);
    $categoryRepository = new CategoryRepository($client);
    // Prioritize category updates so that taxonomy IDs/information is
    // available during item updates.
    $categoryRepository->updateCategories($channel);
    $repository->updateItems($channel);
    // Restore the cache mode to the previous setting just incase processing
    // will continue after this step.
    $cache->setMode($mode);
  }

}

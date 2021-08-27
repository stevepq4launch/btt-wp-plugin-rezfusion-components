<?php

/**
 * @file - Provide a plugin instance class that boostraps hooks.
 */

namespace Rezfusion;

use Rezfusion\Client\Cache;
use Rezfusion\Client\CurlClient;
use Rezfusion\Client\TransientCache;
use Rezfusion\Controller\ReviewController;
use Rezfusion\Helper\Registerer;
use Rezfusion\Pages\Admin\ConfigurationPage;
use Rezfusion\Pages\Admin\CategoryInfoPage;
use Rezfusion\Pages\Admin\ItemInfoPage;
use Rezfusion\Pages\Admin\ReviewsListPage;
use Rezfusion\PostTypes\VRListing;
use Rezfusion\PostTypes\VRPromo;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Shortcodes\Component;
use Rezfusion\Shortcodes\ItemFlag;
use Rezfusion\Shortcodes\LodgingItemAvailCalendar;
use Rezfusion\Shortcodes\LodgingItemAvailPicker;
use Rezfusion\Shortcodes\LodgingItemDetails;
use Rezfusion\Shortcodes\LodgingItemPhotos;
use Rezfusion\Shortcodes\LodgingGlobalPolicies;
use Rezfusion\Shortcodes\LodgingItemReviews;
use Rezfusion\Shortcodes\LodgingItemAmenities;
use Rezfusion\Shortcodes\LodgingItemFavoriteToggle;
use Rezfusion\Shortcodes\Favorites;
use Rezfusion\Shortcodes\FeaturedProperties;
use Rezfusion\Shortcodes\Search;
use Rezfusion\Shortcodes\PropertiesAd;
use Rezfusion\Shortcodes\Reviews;
use Rezfusion\Shortcodes\ReviewSubmitForm;
use Rezfusion\Templates;

class Plugin
{

  /**
   * Prefix used for namespace various pieces of data in transients and
   * other options.
   */
  const PREFIX = "rzf";

  /**
   * The base `vr_listing` post type name.
   */
  const VR_LISTING_NAME = "vr_listing";
  const VR_PROMO_NAME = "vr_promo";

  /**
   * @var string
   */
  const PLUGIN_NAME = 'Rezfusion';

  /**
   * @var string
   */
  const FEATURED_PROPERTIES_CONFIG_SCRIPT_NAME = 'featured-properties-configuration-component-handler';

  /**
   * @var string
   */
  const FEATURED_PROPERTIES_STYLE_NAME = 'featured-properties-configuration-component-style';

  /**
   * @var \Rezfusion\Plugin
   */
  public static $instance;

  /**
   * @var \Rezfusion\Client\Client
   */
  public static $apiClient;

  /**
   * @var Registerer
   */
  protected $Registerer;

  /**
   * Plugin constructor.
   *
   * Private to enforce this class a singleton that binds
   * hooks only once.
   */
  private function __construct()
  {
    $this->registerPostTypes();
    $this->Registerer = new Registerer();
    add_action('init', [$this, 'registerShortcodes']);
    add_action('init', [$this, 'registerRewriteTags']);
    add_action('init', [$this, 'delayedRewriteFlush']);
    add_action('admin_menu', [$this, 'registerPages']);
    add_action('admin_init', [$this, 'registerSettings']);
    add_action('template_redirect', [$this, 'templateRedirect']);
    add_action('wp_head', [$this, 'wpHead']);
    add_action('admin_enqueue_scripts', [$this, 'loadFontAwesomeIcons']);
    $this->enqueueConfigurationPageScripts();
    $this->enqueueFeaturedPropertiesConfigurationScripts();
    (new ReviewController)->initialize();
    $this->enqueueRezfusionHTML_Components();
  }

  /**
   * Enqueue (and register) HTML components/widgets.
   * 
   * @return void
   */
  protected function enqueueRezfusionHTML_Components(): void
  {
    $this->Registerer->handleStyle('rezfusion-stars-rating.css');
    $this->Registerer->handleScript('rezfusion-stars-rating.js');
    $this->Registerer->handleStyle('rezfusion-fields-validation.css');
    $this->Registerer->handleScript('rezfusion-fields-validation.js');
    $this->Registerer->handleStyle('rezfusion-modal.css');
    $this->Registerer->handleScript('rezfusion-modal.js');
    $this->Registerer->handleScript('rezfusion-review-submit-form.js');
    $this->Registerer->handleScript('rezfusion.js');
  }

  /**
   * Enqueue scripts and styles for configuration page.
   * 
   * @return void
   */
  protected function enqueueConfigurationPageScripts(): void
  {
    add_action('admin_enqueue_scripts', function () {
      $pageName = @$_GET['page'];
      if ($pageName === ConfigurationPage::pageName()) {
        $currentTab = @$_GET['tab'];
        if ($currentTab === ConfigurationPage::generalTabName() || empty($currentTab)) {
          $this->Registerer->handleScript('configuration-page-validation.js');
        }
      } else if ($pageName === ReviewsListPage::pageName()) {
        $this->Registerer->handleScript('rezfusion-table.js');
        $this->Registerer->handleScript('configuration-reviews-list-view-handler.js');
      }
    });
  }

  /**
   * Enqueue required styles and scripts for "Featured Properties" component.
   * 
   * @return void
   */
  protected function enqueueFeaturedPropertiesConfigurationScripts(): void
  {
    add_action('admin_enqueue_scripts', function () {
      wp_register_style(static::FEATURED_PROPERTIES_STYLE_NAME, plugin_dir_url(REZFUSION_PLUGIN) . '/assets/css/featured-properties-configuration.css');
      wp_register_script(static::FEATURED_PROPERTIES_CONFIG_SCRIPT_NAME, plugin_dir_url(REZFUSION_PLUGIN) . '/assets/js/featured-properties-configuration-component-handler.js');
      wp_enqueue_style(static::FEATURED_PROPERTIES_STYLE_NAME);
      wp_enqueue_script(static::FEATURED_PROPERTIES_CONFIG_SCRIPT_NAME);
    });
  }

  /**
   * Create the plugin instance. The main `rezfusion-components` plugin file
   * initializes itself using this function.
   *
   * @return \Rezfusion\Plugin
   */
  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  /**
   * Add a rewrite tag for the query parameter that components uses to identify
   * items in the API.
   */
  public function registerRewriteTags()
  {
    add_rewrite_tag('%pms_id%', '([^&]+)');
  }

  /**
   * Register custom post types.
   */
  public function registerPostTypes()
  {
    new VRListing(self::VR_LISTING_NAME);
    new VRPromo(self::VR_PROMO_NAME);
  }

  /**
   * Add admin settings.
   */
  public function registerSettings()
  {
    register_setting('rezfusion-components', 'rezfusion_hub_channel');
    register_setting('rezfusion-components', 'rezfusion_hub_folder');
    register_setting('rezfusion-components', 'rezfusion_hub_theme');
    register_setting('rezfusion-components', 'rezfusion_hub_env');
    register_setting('rezfusion-components', 'rezfusion_hub_sync_items_post_type');
    register_setting('rezfusion-components', 'rezfusion_hub_sps_domain');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_general');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_pets');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_payment');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_cancellation');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_changing');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_insurance');
    register_setting('rezfusion-components', 'rezfusion_hub_policies_cleaning');
    register_setting('rezfusion-components', 'rezfusion_hub_amenities_featured');
    register_setting('rezfusion-components', 'rezfusion_hub_amenities_general');
    register_setting('rezfusion-components', 'rezfusion_hub_enable_favorites');
  }

  /**
   * Add pages to the admin menu.
   */
  public function registerPages()
  {
    $configTemplate = new Template('configuration.php', REZFUSION_PLUGIN_TEMPLATES_PATH . "/admin");
    $configPage = new ConfigurationPage($configTemplate);
    add_menu_page(
      $this->getPluginName() . ' Components',
      $this->getPluginName(),
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

    add_submenu_page(
      'rezfusion_components_config',
      'Reviews List',
      'Reviews List',
      'administrator',
      ReviewsListPage::pageName(),
      [new ReviewsListPage(new Template(Templates::reviewsListPage(), REZFUSION_PLUGIN_TEMPLATES_PATH . "/admin")), 'display']
    );
  }

  /**
   * @throws \Exception
   */
  public function registerShortcodes()
  {
    new Component(new Template('vr-component.php'));
    new LodgingItemDetails(new Template('vr-details-page.php'));
    new ItemFlag(new Template('vr-item-flag.php'));
    new LodgingItemPhotos(new Template('vr-item-photos.php'));
    new LodgingItemAvailPicker(new Template('vr-item-avail-picker.php'));
    new LodgingItemAvailCalendar(new Template('vr-item-avail-calendar.php'));
    new LodgingGlobalPolicies(new Template('vr-item-policies.php'));
    new LodgingItemReviews(new Template('vr-item-reviews.php'));
    new LodgingItemAmenities(new Template('vr-item-amenities.php'));
    new LodgingItemFavoriteToggle(new Template('vr-favorite-toggle.php'));
    new Favorites(new Template('vr-favorites.php'));
    new Search(new Template('vr-search.php'));
    new PropertiesAd(new Template('vr-properties-ad.php'));
    new FeaturedProperties(new Template(Templates::featuredPropertiesTemplate()));
    new Reviews(new Template(Templates::reviewsTemplate()));
    new ReviewSubmitForm(new Template(Templates::reviewSubmitForm()));
  }

  /**
   * Attach output to WP head.
   */
  public function wpHead()
  {
    wp_enqueue_script(
      'rezfusion_components_bundle',
      plugins_url('rezfusion-components/dist/main.js')
    );
    $urlMap = new Template('vr-url-map.php');
    print $urlMap->render();
  }

  /**
   * Redirect users to the property details page.
   *
   * @todo: Probably deprecate this. As I suspect there is a more "wordpress-y"
   * @todo: way to do this.
   */
  public function templateRedirect()
  {
    $redirect = get_option('rezfusion_hub_redirect_urls');
    $repository = new ItemRepository(self::apiClient());
    if ($redirect && isset($_GET['pms_id'])) {
      $id = sanitize_text_field($_GET['pms_id']);
      $posts = $repository->getItemById($id);
      if (!empty($posts) && $link = get_permalink($posts[0]['post_id'])) {
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
  public static function env()
  {
    $env = get_option('rezfusion_hub_env', 'prd');
    if (empty($env)) {
      return 'prd';
    }

    return $env;
  }

  /**
   * Get the blueprint URL.
   *
   * @return string
   */
  public static function blueprint()
  {
    $env = self::env();
    if ($env === 'prd') {
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
  public static function apiClient()
  {
    return new CurlClient(REZFUSION_PLUGIN_QUERIES_PATH, self::blueprint(), new TransientCache());
  }

  /**
   * Perform a refresh cycle of locally stored lodging/category data.
   */
  public static function refreshData()
  {
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
    // Restore the cache mode to the previous setting just in case processing
    // will continue after this step.
    $cache->setMode($mode);
  }

  public function loadFontAwesomeIcons()
  {
    wp_register_style('fontawesome_admin_icons', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css', '', '5.15.1', 'all');
    wp_enqueue_style('fontawesome_admin_icons');
  }

  public function delayedRewriteFlush()
  {
    if (!$option = get_option('rezfusion_trigger_rewrite_flush')) {
      return false;
    }

    if ($option == 1) {
      flush_rewrite_rules();
      delete_option('rezfusion_trigger_rewrite_flush');
    }
  }

  /**
   * Returns plugin name.
   * 
   * @todo Move to configuration object.
   * 
   * @return string
   */
  public function getPluginName(): string
  {
    return apply_filters('rezfusion_plugin_name', static::PLUGIN_NAME);
  }
}

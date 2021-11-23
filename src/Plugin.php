<?php

/**
 * @file - Provide a plugin instance class that boostraps hooks.
 */

namespace Rezfusion;

use Error;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Factory\PluginArgumentsFactory;
use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\Registerer\ComponentsBundleRegisterer;
use Rezfusion\Registerer\RegistererInterface;
use Rezfusion\Registerer\RegistererNameGetter;
use Rezfusion\Registerer\RegisterersContainer;
use Rezfusion\Service\DataRefreshService;
use Rezfusion\SessionHandler\SessionHandlerInterface;

class Plugin
{

  /**
   * Prefix used for namespace various pieces of data in transients and
   * other options.
   * @var string
   */
  const PREFIX = "rzf";

  /**
   * @var string
   */
  const PLUGIN_NAME = 'Rezfusion';

  /**
   * @var string
   */
  const OPTION_GROUP = 'rezfusion-components';

  /**
   * @var \Rezfusion\Plugin
   */
  public static $instance;

  /**
   * @var \Rezfusion\Client\Client
   */
  public static $apiClient;

  /**
   * @var OptionsHandler
   */
  protected $OptionsHandler;

  /**
   * @var SessionHandlerInterface
   */
  protected $SessionHandler;

  /**
   * @var AssetsRegistererInterface
   */
  protected $AssetsRegisterer;

  /**
   * @var RegisterersContainer
   */
  private $RegisterersContainer;

  /**
   * Plugin constructor.
   *
   * Private to enforce this class a singleton that binds
   * hooks only once.
   * 
   * @param OptionsHandler $OptionsHandler
   * @param SessionHandlerInterface $SessionHandler
   * @param AssetsRegistererInterface $AssetsRegisterer
   * @param RegisterersContainer $RegisterersContainer
   */
  private function __construct(
    OptionsHandler $OptionsHandler,
    SessionHandlerInterface $SessionHandler,
    AssetsRegistererInterface $AssetsRegisterer,
    RegisterersContainer $RegisterersContainer
  ) {
    $this->OptionsHandler = $OptionsHandler;
    $this->SessionHandler = $SessionHandler;
    $this->AssetsRegisterer = $AssetsRegisterer;
    $this->RegisterersContainer = $RegisterersContainer;
    $this->handleRegisterers($this->RegisterersContainer);
  }

  /**
   * Run all registerers.
   * @param RegisterersContainer $RegisterersContainer
   * 
   * @return void
   */
  private function handleRegisterers(RegisterersContainer $RegisterersContainer): void
  {
    foreach ($RegisterersContainer->getAll() as $Registerer) {
      $Registerer->register();
    }
  }

  /**
   * Initializes session.
   *
   * @return void
   */
  public function initializeSession(): void
  {
    (!headers_sent() && !$this->SessionHandler->getSessionId()) && $this->SessionHandler->startSession();
  }

  /**
   * Create the plugin instance. The main `rezfusion-components` plugin file
   * initializes itself using this function.
   *
   * @return \Rezfusion\Plugin
   */
  public static function getInstance(): self
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(...(new PluginArgumentsFactory())->make());
    }
    return self::$instance;
  }

  /**
   * Provide a factory method for the api client instance for the
   * application.
   *
   * The client's design is such that each method takes a `$channel` param. So
   * that we can use the client as a singleton.
   *
   * @return ClientInterface
   */
  public static function apiClient(): ClientInterface
  {
    return (new API_ClientFactory)->make();
  }

  /**
   * Perform a refresh cycle of locally stored lodging/category data.
   * 
   * @return void
   */
  public static function refreshData(): void
  {
    (new DataRefreshService(static::apiClient()))->run();
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
    return apply_filters(Filters::pluginName(), static::PLUGIN_NAME);
  }

  /**
   * Return value for option.
   * 
   * @param string $option
   * @param null $default
   * 
   * @return mixed
   */
  public function getOption($option = '', $default = null)
  {
    return $this->OptionsHandler->getOption($option, $default);
  }

  /**
   * Returns instance of AssetsRegisterer.
   * @return AssetsRegistererInterface
   */
  public function getAssetsRegisterer(): AssetsRegistererInterface
  {
    return $this->AssetsRegisterer;
  }

  /**
   * Returns plugin prefix.
   * @return string
   */
  public static function prefix(): string
  {
    return static::PREFIX;
  }
}

<?php

namespace Rezfusion\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use stdClass;

/**
 * @file Container for configuration.
 */
class HubConfiguration
{

    /**
     * @var string
     */
    const PRODUCTION_ENVIRONMENT = 'prd';

    /**
     * @var string
     */
    const DEVELOPMENT_ENVIRONMENT = 'dev';

    /**
     * @var string
     */
    const PRODUCTION_DEFAULT_BLUEPRINT_URL = 'https://blueprint.rezfusion.com/graphql';

    /**
     * @var string
     */
    const DEVELOPMENT_DEFAULT_BLUEPRINT_URL = 'https://blueprint.hub-stg.rezfusion.com/graphql';

    /**
     * @var string
     */
    const DEFAULT_SPS_DOMAIN = 'https://checkout.rezfusion.com';

    /**
     * The default channel URL, if none is specified.
     * @var string
     */
    const DEFAULT_CHANNEL_URL = 'https://www.rezfusionhubdemo.com';

    /**
     * @var mixed
     */
    protected $configuration;

    /**
     * @var int
     */
    const MAX_REVIEW_RATING = 5;

    /**
     * @var string
     */
    protected $configurationURL = '';

    /**
     * @var ConfigurationStorageInterface
     */
    protected $ConfigurationStorage;

    /**
     * @param string $configurationURL
     * @param ConfigurationStorageInterface $ConfigurationStorage
     */
    public function __construct($configurationURL = '', ConfigurationStorageInterface $ConfigurationStorage)
    {
        $this->configurationURL = $configurationURL;
        $this->ConfigurationStorage = $ConfigurationStorage;
    }

    /**
     * @return string
     */
    public static function productionEnvironment(): string
    {
        return static::PRODUCTION_ENVIRONMENT;
    }

    /**
     * @return string
     */
    public static function developmentEnvironment(): string
    {
        return static::DEVELOPMENT_ENVIRONMENT;
    }

    /**
     * @return string
     */
    public static function defaultProductionBlueprintURL(): string
    {
        return static::PRODUCTION_DEFAULT_BLUEPRINT_URL;
    }

    /**
     * @return string
     */
    public static function defaultDevelopmentBlueprintURL(): string
    {
        return static::DEVELOPMENT_DEFAULT_BLUEPRINT_URL;
    }

    /**
     * Returns the default Channel URL; useful for when none is specified in configuration.
     * @return string
     */
    public static function defaultChannelURL(): string
    {
      return static::DEFAULT_CHANNEL_URL;
    }

    /**
     * @return string
     */
    public static function defaultSPS_Domain(): string
    {
        return static::DEFAULT_SPS_DOMAIN;
    }

    /**
     * @return string
     */
    public static function themeURL_Key(): string
    {
        return "themeURL";
    }

    /**
     * @return string
     */
    public static function fontsURL_Key(): string
    {
        return "fontsURL";
    }

    /**
     * @return string
     */
    public static function componentsBundleURL_Key(): string
    {
        return 'componentsBundleURL';
    }

    /**
     * @return string
     */
    public static function componentsCSS_URL_Key(): string
    {
        return 'componentsCSS_URL';
    }

    /**
     * @return string
     */
    public function getConfigurationURL(): string
    {
        return $this->configurationURL;
    }

    /**
     * @return mixed
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param mixed $configuration
     */
    public function setConfiguration($configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * Load configuration.
     *
     * @return void
     */
    public function loadConfiguration(): void
    {
        $this->setConfiguration($this->ConfigurationStorage->loadConfiguration());
    }

    /**
     * Save configuration.
     *
     * @return void
     */
    public function saveConfiguration(): void
    {
        $this->ConfigurationStorage->saveConfiguration($this->getConfiguration());
    }

    /**
     * Get value by path.
     * @param string $path
     * @param null $default
     *
     * @return mixed
     */
    public function getValue($path = '', $default = null)
    {
        $value = null;
        $parts = explode('.', $path);
        $source = $this->getConfiguration();
        $total = count($parts);
        for ($i = 0; $i < $total; $i++) {
            $key = $parts[$i];
            if (!isset($source->$key))
                break;
            $source = $source->$key;
            if ($i + 1 == $total) {
                $value = $source;
                break;
            }
        }
        return (!empty($value)) ? $value : $default;
    }

    /**
     * Set value by path.
     * @param string $path
     * @param mixed $value
     * 
     * @return void
     */
    public function setValue($path = '', $value): void
    {
        $parts = explode('.', $path);
        $source = $this->getConfiguration();
        $total = count($parts);
        for ($i = 0; $i < $total; $i++) {
            $key = $parts[$i];
            if (!isset($source->$key) && $i < $total) {
                $source->$key = new stdClass();
            }
            if ($i + 1 == $total) {
                $source->$key = $value;
                break;
            } else {
                $source = $source->$key;
            }
        }
    }

    /**
     * @return string
     */
    public function getComponentsURL()
    {
        return $this->getConfigurationURL();
    }

    /**
     * @return string
     */
    public function getChannelURL()
    {
        return $this->getValue('hub_configuration.settings.components.SearchProvider.channels', static::defaultChannelURL());
    }

    /**
     * @return string
     */
    public function getSPS_Domain()
    {
        return $this->getValue('hub_configuration.settings.components.AvailabilitySearchConsumer.spsDomain', static::defaultSPS_Domain());
    }

    /**
     * @return string
     */
    public function getBookingConfirmationURL()
    {
        return $this->getValue('hub_configuration.settings.components.AvailabilitySearchConsumer.confirmationPage', '');
    }

    /**
     * @return string
     */
    public function getFavoritesEnabled()
    {
        return $this->getValue('hub_configuration.settings.favorites.enable', '');
    }

    /**
     * @return string
     */
    public function getMapAPI_Key()
    {
        return $this->getValue('hub_configuration.settings.components.Map.apiKey', '');
    }

    /**
     * @return string
     */
    public function getItemsDetailsPath()
    {
        return $this->getValue('hub_configuration.settings.components.SearchProvider.itemDetailsPath', '');
    }

    /**
     * @return string
     */
    public function getThemeURL()
    {
        return $this->getValue('themeURL', '');
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return OptionManager::get(Options::environment(), static::developmentEnvironment(), static::productionEnvironment());
    }

    /**
     * @return string
     */
    public function getBlueprintURL()
    {
        return ($this->getEnvironment() === static::productionEnvironment())
            ? static::defaultProductionBlueprintURL()
            : static::defaultDevelopmentBlueprintURL();
    }

    /**
     * @return string
     */
    public function getFontsURL()
    {
        return $this->getValue('fontsURL', '');
    }

    /**
     * @return int
     */
    public function getMaxReviewRating(): int
    {
        return static::MAX_REVIEW_RATING;
    }

    /**
     * @return string
     */
    public function getComponentsBundleURL(): string
    {
        return $this->getValue(static::componentsBundleURL_Key(), '');
    }

    /**
     * @return string
     */
    public function getComponentsCSS_URL(): string
    {
        return $this->getValue(static::componentsCSS_URL_Key(), '');
    }

    /**
     * @return array
     */
    public function getHubConfigurationArray(): array
    {
        return (array) $this->getValue('hub_configuration', []);
    }
}

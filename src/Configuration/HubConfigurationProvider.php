<?php

namespace Rezfusion\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\JSON_ConfigurationStorage;
use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;

class HubConfigurationProvider
{
    /**
     * @var HubConfiguration
     */
    private static $Instance;

    /**
     * Get (or create) instance of HubConfiguration object.
     * 
     * @return HubConfiguration
     */
    public static function getInstance(): HubConfiguration
    {
        if (empty(static::$Instance)) {
            $componentsURL = OptionManager::get(Options::componentsURL());
            static::$Instance = new HubConfiguration(
                $componentsURL,
                defined('REZFUSION_TEST')
                    ? new JSON_ConfigurationStorage(REZFUSION_PLUGIN_PATH . '/rzftest-hub-config.json')
                    : new RemoteConfigurationStorage($componentsURL, HubConfiguration::class)
            );
            static::$Instance->loadConfiguration();
        }
        return static::$Instance;
    }
}

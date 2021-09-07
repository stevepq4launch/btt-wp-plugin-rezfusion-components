<?php

namespace Rezfusion\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
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
            static::$Instance = new HubConfiguration(
                get_option(Options::componentsURL()),
                new RemoteConfigurationStorage(get_option(Options::componentsURL()), HubConfiguration::class)
            );
            static::$Instance->loadConfiguration();
        }
        return static::$Instance;
    }
}

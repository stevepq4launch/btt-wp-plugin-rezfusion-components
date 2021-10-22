<?php

namespace Rezfusion\Provider;

use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\OptionsHandler;
use Rezfusion\PluginConfiguration;

class OptionsHandlerProvider implements ProviderInterface
{
    /**
     * @var OptionsHandler
     */
    private static $Instance;

    private function __construct()
    {
    }

    /**
     * @return OptionsHandler
     */
    public static function getInstance()
    {
        if (empty(static::$Instance)) {
            static::$Instance = new OptionsHandler(HubConfigurationProvider::getInstance(), PluginConfiguration::getInstance());
        }
        return static::$Instance;
    }
}

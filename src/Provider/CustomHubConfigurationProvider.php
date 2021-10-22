<?php

namespace Rezfusion\Provider;

use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\ConfigurationProcessor;
use Rezfusion\Factory\CustomHubConfigurationFactory;

class CustomHubConfigurationProvider implements ProviderInterface
{
    /**
     * @var HubConfiguration
     */
    private static $Instance;

    /**
     * @return HubConfiguration
     */
    private static function make(): HubConfiguration
    {
        $CustomConfiguration = (new CustomHubConfigurationFactory())->make();
        $ConfigurationProcessor = new ConfigurationProcessor();
        $ConfigurationProcessor->process($CustomConfiguration);
        return $CustomConfiguration;
    }

    /**
     * @return HubConfiguration
     */
    public static function getInstance(): HubConfiguration
    {
        if (empty(static::$Instance)) {
            static::$Instance = static::make();
        }
        return static::$Instance;
    }
}

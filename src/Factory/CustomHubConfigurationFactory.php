<?php

namespace Rezfusion\Factory;

use Rezfusion\Configuration\ConfigurationStorage\NullConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Options;

class CustomHubConfigurationFactory implements MakeableInterface
{
    /**
     * Creates a custom instance of HubConfiguration.
     * 
     * @return HubConfiguration
     */
    public function make(): HubConfiguration
    {
        $CustomConfiguration = new HubConfiguration(
            get_rezfusion_option(Options::componentsURL()),
            new NullConfigurationStorage()
        );
        /* Do not use existing configuration object, we want a copy. */
        $CustomConfiguration->setConfiguration(unserialize(serialize(HubConfigurationProvider::getInstance()->getConfiguration())));
        return $CustomConfiguration;
    }
}

<?php

namespace Rezfusion\Configuration;

use Exception;
use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;

/**
 * @file Handler for updating HubConfiguration with remote configuration.
 */
class HubConfigurationUpdater
{

    /**
     * @var HubConfiguration
     */
    protected $HubConfiguration;

    /**
     * @var ConfigurationStorageInterface
     */
    protected $ConfigurationStorage;

    /**
     * @param HubConfiguration $HubConfiguration
     * @param ConfigurationStorageInterface $ConfigurationStorage
     */
    public function __construct(HubConfiguration $HubConfiguration, ConfigurationStorageInterface $ConfigurationStorage)
    {
        $this->HubConfiguration = $HubConfiguration;
        $this->ConfigurationStorage = $ConfigurationStorage;
    }

    /**
     * Update configuration object.
     * 
     * @return bool
     */
    public function update(): bool
    {
        $result = false;
        try {
            $this->HubConfiguration->setConfiguration($this->ConfigurationStorage->loadConfiguration());
            $result = true;
        } catch (Exception $Exception) {
        }
        return $result;
    }
}

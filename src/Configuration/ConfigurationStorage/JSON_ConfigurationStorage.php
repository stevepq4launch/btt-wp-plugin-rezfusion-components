<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

/**
 * @file Provides configuration from JSON file.
 */
class JSON_ConfigurationStorage implements ConfigurationStorageInterface
{

    /**
     * @var string
     */
    protected $configurationFilename = '';

    /**
     * @param string $configurationFilename
     */
    public function __construct($configurationFilename = '')
    {
        $this->configurationFilename = $configurationFilename;
    }

    /**
     * @return mixed
     */
    public function loadConfiguration()
    {
        $configuration = [];
        if (file_exists($this->configurationFilename)) {
            if (!empty($json = file_get_contents($this->configurationFilename))) {
                $configuration = json_decode($json);
            }
        }
        return $configuration;
    }

    /**
     * @param mixed $configuration
     */
    public function saveConfiguration($configuration)
    {
        file_put_contents($this->configurationFilename, json_encode($configuration));
    }
}

<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

/**
 * @file Provides configuration from database.
 */
class DatabaseConfigurationStorage implements ConfigurationStorageInterface
{
    /**
     * @var string
     */
    private $optionName = '';

    public function __construct($optionName = '')
    {
        $this->optionName = $optionName;
    }

    /**
     * @return mixed
     */
    public function loadConfiguration()
    {
        return (!empty($configuration = json_decode(get_option($this->optionName))))
            ? $configuration
            : [];
    }

    /**
     * @param mixed $configuration
     */
    public function saveConfiguration($configuration)
    {
        return update_option($this->optionName, json_encode($configuration));
    }
}

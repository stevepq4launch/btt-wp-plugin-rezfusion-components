<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

use Rezfusion\Helper\OptionManager;

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
        return (!empty($configuration = json_decode(OptionManager::get($this->optionName, null))))
            ? $configuration
            : [];
    }

    /**
     * @param mixed $configuration
     */
    public function saveConfiguration($configuration)
    {
        return OptionManager::update($this->optionName, json_encode($configuration));
    }
}

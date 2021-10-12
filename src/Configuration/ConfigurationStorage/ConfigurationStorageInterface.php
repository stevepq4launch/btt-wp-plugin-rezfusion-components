<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

interface ConfigurationStorageInterface
{
    public function loadConfiguration();
    public function saveConfiguration($configuration);
}

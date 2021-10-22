<?php

namespace Rezfusion\Configuration\ConfigurationStorage;

/**
 * @file Provides NULL configuration storage.
 */
class NullConfigurationStorage implements ConfigurationStorageInterface
{
    public function __construct()
    {
    }

    public function loadConfiguration(): void
    {
    }

    public function saveConfiguration($configuration): void
    {
    }
}

<?php

namespace Rezfusion;

use Rezfusion\Helper\OptionManager;

/**
 * @file Class keeps configuration for plugin.
 */
class PluginConfiguration
{

    /**
     * @var string
     */
    const REPOSITORY_URL = "https://github.com/PropertyBrands/btt-wp-plugin-rezfusion-components.git";

    /**
     * @var object
     */
    protected $configuration;

    /**
     * @var PluginConfiguration
     */
    protected static $Instance;

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (!static::$Instance)
            static::$Instance = new self();
        return static::$Instance;
    }

    /**
     * @return string
     */
    public function repositoryURL(): string
    {
        return static::REPOSITORY_URL;
    }

    /**
     * @return string
     */
    public function repositoryToken(): string
    {
        return !empty($repositoryToken = OptionManager::get(Options::repositoryToken())) ? $repositoryToken : "";
    }
}

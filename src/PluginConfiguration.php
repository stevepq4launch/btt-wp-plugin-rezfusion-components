<?php

namespace Rezfusion;

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

    public function __construct()
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
        return !empty($repositoryToken = get_option(Options::repositoryToken())) ? $repositoryToken : "";
    }
}

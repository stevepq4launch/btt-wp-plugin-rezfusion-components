<?php

namespace Rezfusion;

use Exception;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Exception\InvalidOptionNameException;
use Rezfusion\Factory\ValidOptionsFactory;
use Rezfusion\Helper\OptionManager;

/**
 * @file Class maps literal options names to specific class methods.
 */
class OptionsHandler
{
    /**
     * @var HubConfiguration
     */
    private $HubConfiguration;

    /**
     * @var PluginConfiguration
     */
    private $PluginConfiguration;

    /**
     * @var array
     */
    private $hubConfigurationMap = [];

    /**
     * @var array
     */
    private $pluginConfigurationMap = [];

    /**
     * @var string[]
     */
    private $validOptions = [];

    /**
     * @param HubConfiguration $HubConfiguration
     */
    public function __construct(HubConfiguration $HubConfiguration, PluginConfiguration $PluginConfiguration)
    {
        $this->HubConfiguration = $HubConfiguration;
        $this->PluginConfiguration = $PluginConfiguration;
        $this->hubConfigurationMap = $this->makeHubConfigurationMap();
        $this->pluginConfigurationMap = $this->makePluginConfigurationMap();
        $this->validOptions = (new ValidOptionsFactory())->make();
    }

    /**
     * Creates a map of options names to appropriate methods.
     * 
     * @return array
     */
    private function makeHubConfigurationMap(): array
    {
        return [
            Options::componentsURL() => 'getComponentsURL',
            Options::hubChannelURL() => 'getChannelURL',
            Options::bookingConfirmationURL() => 'getBookingConfirmationURL',
            Options::SPS_Domain() => 'getSPS_Domain',
            Options::enableFavorites() => 'getFavoritesEnabled',
            Options::mapAPI_Key() => 'getMapAPI_Key',
            Options::themeURL() => 'getThemeURL',
            Options::blueprintURL() => 'getBlueprintURL',
            Options::fontsURL() => 'getFontsURL',
            Options::environment() => 'getEnvironment',
            Options::maxReviewRating() => 'getMaxReviewRating',
            Options::configuration() => 'getHubConfigurationArray',
            Options::componentsBundleURL() => 'getComponentsBundleURL',
            Options::componentsCSS_URL() => 'getComponentsCSS_URL'
        ];
    }

    /**
     * Creates a map of configuration options
     * to appropriate PluginConfiguration methods.
     * 
     * @return array
     */
    private function makePluginConfigurationMap(): array
    {
        return [
            Options::repositoryURL() => 'repositoryURL',
            Options::repositoryToken() => 'repositoryToken'
        ];
    }

    /**
     * @return array
     */
    public function getHubConfigurationMap(): array
    {
        return $this->hubConfigurationMap;
    }

    /**
     * @return array
     */
    public function getPluginConfigurationMap(): array
    {
        return $this->pluginConfigurationMap;
    }

    /**
     * Check if option name is valid.
     * @param string $option
     * @throws Exception
     * 
     * @return bool
     */
    private function validateOption($option = ''): bool
    {
        if (empty($option)) {
            throw new InvalidOptionNameException();
        }
        return in_array($option, $this->validOptions);
    }

    /**
     * Get option value.
     * 
     * @param string $option
     * @param null $default
     * 
     * @return mixed
     */
    public function getOption($option = '', $default = null)
    {
        $value = null;

        if (array_key_exists($option, $this->pluginConfigurationMap)) {
            $method = $this->pluginConfigurationMap[$option];
            $value = $this->PluginConfiguration->$method();
        } elseif (!empty($this->hubConfigurationMap[$option])) {
            $method = $this->hubConfigurationMap[$option];
            $value = $this->HubConfiguration->$method();
        } elseif ($this->validateOption($option)) {
            $value = OptionManager::get($option, $default);
        } else {
            throw new \Exception(sprintf("Invalid %s option.", $option));
        }

        return (!empty($value)) ? $value : $default;
    }

    /**
     * @param string $option
     * @param mixed $value
     * 
     * @return bool
     */
    public function updateOption($option = '', $value): bool
    {
        return OptionManager::update($option, $value);
    }
}

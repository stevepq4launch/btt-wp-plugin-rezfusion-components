<?php

namespace Rezfusion;

use Rezfusion\Configuration\HubConfiguration;

/**
 * @file Class maps literal options names to HubConfiguration class methods.
 */
class OptionsHandler
{

    /**
     * @var HubConfiguration
     */
    protected $HubConfiguration;

    /**
     * @var array
     */
    protected $optionsMap = [];

    /**
     * @param HubConfiguration $HubConfiguration
     */
    public function __construct(HubConfiguration $HubConfiguration)
    {
        $this->HubConfiguration = $HubConfiguration;
        $this->optionsMap = $this->makeOptionsMap();
    }

    /**
     * Creates a map of options names to appropriate methods.
     * 
     * @return array
     */
    protected function makeOptionsMap(): array
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
            Options::maxReviewRating() => 'getMaxReviewRating'
        ];
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
        if (empty($this->optionsMap[$option])) {
            throw new \Exception(sprintf("Invalid %s option.", $option));
        }
        $method = $this->optionsMap[$option];
        return (!empty($value = $this->HubConfiguration->$method())) ? $value : $default;
    }
}

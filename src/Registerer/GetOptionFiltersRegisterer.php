<?php

namespace Rezfusion\Registerer;

use Rezfusion\Filters;
use Rezfusion\OptionsHandler;

/**
 * @file Handles filtering of Wordpress get_option function.
 */
class GetOptionFiltersRegisterer implements RegistererInterface
{
    /**
     * @var OptionsHandler
     */
    private $OptionsHandler;

    /**
     * @var string[]
     */
    private $optionsNames;

    /**
     * @param OptionsHandler $OptionsHandler Provides values for options.
     * @param array $optionsNames Array of options names to be filtered.
     */
    public function __construct(OptionsHandler $OptionsHandler, $optionsNames = [])
    {
        $this->OptionsHandler = $OptionsHandler;
        $this->optionsNames = $optionsNames;
    }

    /**
     * Adds filters for options.
     * @inheritdoc
     */
    public function register(): void
    {
        foreach ($this->optionsNames as $optionName) {
            add_filter(Filters::option($optionName), function ($value) use ($optionName) {
                return $this->OptionsHandler->getOption($optionName);
            });
        }
    }
}

<?php

namespace Rezfusion\Factory;

use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\SessionHandler\SessionHandler;

class PluginArgumentsFactory
{
    /**
     * Creates a new array of arguments for Plugin.
     * @return array
     */
    public function make(): array
    {
        $AssetsRegisterer = new AssetsRegisterer();
        $OptionsHandler = OptionsHandlerProvider::getInstance();
        return [
            $OptionsHandler,
            SessionHandler::getInstance(),
            $AssetsRegisterer,
            (new RegisterersContainerFactory($AssetsRegisterer, $OptionsHandler))->make()
        ];
    }
}

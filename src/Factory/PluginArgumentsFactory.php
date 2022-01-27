<?php

namespace Rezfusion\Factory;

use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\SessionHandler\SessionHandler;
use Rezfusion\Tests\TestHelper\API_TestClientFactory;

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
            (new RegisterersContainerFactory($AssetsRegisterer, $OptionsHandler))->make(),
            (defined('REZFUSION_TEST') && REZFUSION_TEST) ? new API_TestClientFactory() : new API_ClientFactory()
        ];
    }
}

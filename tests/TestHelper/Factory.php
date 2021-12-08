<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Client\MemoryCache;
use Rezfusion\Options;
use Rezfusion\Plugin;

class Factory
{
    public static function makeAPI_TestClient(): ClientInterface
    {
        return (new API_TestClientFactory())->make();
    }

    public static function makeAPI_ClientMock(): ClientInterface
    {
        return new API_ClientMock(REZFUSION_PLUGIN_QUERIES_PATH, Plugin::getInstance()->getOption(Options::blueprintURL()), new MemoryCache());
    }
}

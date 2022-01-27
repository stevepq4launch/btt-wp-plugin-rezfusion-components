<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Client\FileCache;
use Rezfusion\Factory\MakeableInterface;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Tests\Client\API_TestClient;

class API_TestClientFactory implements MakeableInterface
{
    /**
     * Creates a new instance of API client for tests.
     * @return ClientInterface
     */
    public function make(): ClientInterface
    {
        return new API_TestClient(REZFUSION_PLUGIN_QUERIES_PATH, Plugin::getInstance()->getOption(Options::blueprintURL()), new FileCache(REZFUSION_PLUGIN_PATH . '/test-api-cache.json'));
    }
}

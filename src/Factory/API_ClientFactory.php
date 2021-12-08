<?php

namespace Rezfusion\Factory;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Client\CurlClient;
use Rezfusion\Client\TransientCache;
use Rezfusion\Options;
use Rezfusion\Plugin;

class API_ClientFactory implements MakeableInterface
{
    /**
     * Creates a new instance of API client.
     * @return ClientInterface
     */
    public function make(): ClientInterface
    {
        return new CurlClient(REZFUSION_PLUGIN_QUERIES_PATH, Plugin::getInstance()->getOption(Options::blueprintURL()), new TransientCache());
    }
}

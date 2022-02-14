<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\Client;
use Rezfusion\Client\CurlClient;
use Rezfusion\Client\MemoryCache;
use Rezfusion\Tests\BaseTestCase;

class ClientTest extends BaseTestCase
{
    private function makeBasicClient(): Client
    {
        return new CurlClient('', '', null);
    }

    public function testGetQueryWithInvalidPath(): void
    {
        $invalidQueryPath = REZFUSION_PLUGIN_QUERIES_PATH . '/invalid-query-path.graphql';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('Path for query: %s. Was not found.', $invalidQueryPath));
        $Client = $this->makeBasicClient();
        $Client->getQuery($invalidQueryPath);
    }

    public function testSetCache(): void
    {
        $Cache = new MemoryCache;
        $Client = $this->makeBasicClient();
        $Client->setCache($Cache);
        $this->assertSame($Cache, $Client->getCache());
    }
}

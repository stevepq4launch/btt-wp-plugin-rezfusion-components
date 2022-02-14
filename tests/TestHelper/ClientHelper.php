<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Client\CurlClient;
use Rezfusion\Tests\BaseTestCase;

class ClientHelper extends BaseTestCase
{
    /**
     * @var self
     */
    private static $Instance;

    public static function getInstance(): self
    {
        if (!static::$Instance) {
            static::$Instance = new self;
        }
        return static::$Instance;
    }

    /**
     * Creates a new instance of client that returns specified items.
     * @param array $items
     * 
     * @return ClientInterface
     */
    public function makeClientReturningItems(array $items = []): ClientInterface
    {
        /** @var ClientInterface */
        $API_Client = $this->createMock(CurlClient::class);
        $items = json_decode(json_encode($items), false);
        $API_Client->method('getItems')->willReturn($items);
        return $API_Client;
    }
}

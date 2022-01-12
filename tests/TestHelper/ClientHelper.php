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

    public function makeClientReturningZeroItemMock(): ClientInterface
    {
        /** @var ClientInterface */
        $API_Client = $this->createMock(CurlClient::class);
        $items = json_decode(json_encode([
            'data' => [
                'lodgingProducts' => [
                    'results' => [
                        [
                            'item' => [
                                'id' => 1000
                            ]
                        ]
                    ]
                ]
            ]
        ]), false);
        $API_Client->method('getItems')->willReturn($items);
        return $API_Client;
    }
}

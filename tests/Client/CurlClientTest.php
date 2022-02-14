<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\CurlClient;
use Rezfusion\Client\MemoryCache;
use Rezfusion\Tests\BaseTestCase;

class CurlClientTest extends BaseTestCase
{
    public function testRequestWithInvalidURL(): void
    {
        $malformedURL_Error = 3;
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('Rezfusion Blueprint connection exception. Curl err: %d', $malformedURL_Error));
        $Client = new CurlClient('', '', new MemoryCache);
        $Client->request('fail', []);
    }
}

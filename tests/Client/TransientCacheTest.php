<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\Cache;
use Rezfusion\Client\TransientCache;

class TransientCacheTest extends AbstractCacheTest
{
    protected function makeCache(): Cache
    {
        return new TransientCache();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->Cache->delete($this->testKey);
    }
}

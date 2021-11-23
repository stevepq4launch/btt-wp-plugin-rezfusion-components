<?php

namespace Rezfusion\Tests\TestCleanUp;

use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;

class CleanUpTest extends BaseTestCase
{
    /**
     * Clean up after executing all tests.
     */
    public function testCleanUp()
    {
        (new DeleteDataService)->run();
        $this->assertTrue(true);
    }
}

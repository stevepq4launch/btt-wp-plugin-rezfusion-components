<?php

namespace Rezfusion\Tests\Registerer;

use Rezfusion\Registerer\RegisterersContainer;
use Rezfusion\Tests\BaseTestCase;

class RegisterersContainerTest extends BaseTestCase
{
    public function testFindByInvalidName()
    {
        $RegisterersContainer = new RegisterersContainer([]);
        $Registerer = $RegisterersContainer->find('invalid-registerer');
        $this->assertNull($Registerer);
    }
}

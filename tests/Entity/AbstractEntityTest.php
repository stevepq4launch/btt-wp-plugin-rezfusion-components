<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\NullEntity;
use Rezfusion\Tests\BaseTestCase;

class AbstractEntityTest extends BaseTestCase
{
    public function testToArray()
    {
        $NullEntity = new NullEntity;
        $array = $NullEntity->toArray();
        $this->assertIsArray($array);
        $this->assertCount(0, $array);
    }
}

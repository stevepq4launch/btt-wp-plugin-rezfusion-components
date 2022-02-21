<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\PropertyInterface;
use Rezfusion\Tests\BaseTestCase;

abstract class AbstractPropertyInterfaceTest extends BaseTestCase
{
    abstract protected function makeEntity(): PropertyInterface;

    public function testGettersAndSetters(): void
    {
        $Property = $this->makeEntity();

        $Property->setId(1001);
        $Property->setName("Property Test #1");
        $Property->setPostId(1002);
        $Property->setPostStatus('trash');
        $Property->setPostType('test-post-type');
        $Property->setBeds(5);
        $Property->setBaths(6);

        $this->assertSame(1001, $Property->getId());
        $this->assertSame("Property Test #1", $Property->getName());
        $this->assertSame(1002, $Property->getPostId());
        $this->assertSame('trash', $Property->getPostStatus());
        $this->assertSame('test-post-type', $Property->getPostType());
        $this->assertSame(5, $Property->getBeds());
        $this->assertSame(6, $Property->getBaths());
    }
}

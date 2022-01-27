<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\AbstractEntity;
use Rezfusion\Entity\NullEntity;
use Rezfusion\Tests\BaseTestCase;

class NullEntityTest extends BaseTestCase
{
    private function makeNullEntity(): NullEntity
    {
        $NullEntity = new NullEntity;
        $this->assertInstanceOf(NullEntity::class, $NullEntity);
        $this->assertInstanceOf(AbstractEntity::class, $NullEntity);
        return $NullEntity;
    }

    public function testIdGetterAndSetter(): void
    {
        $NullEntity = $this->makeNullEntity();
        $this->assertNull($NullEntity->setId(1000));
        $this->assertNull($NullEntity->getId());
    }
}

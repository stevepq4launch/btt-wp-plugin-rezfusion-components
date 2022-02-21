<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\Property;
use Rezfusion\Entity\PropertyInterface;

class PropertyTest extends AbstractPropertyInterfaceTest
{
    protected function makeEntity(): PropertyInterface
    {
        return new Property();
    }
}

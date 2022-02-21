<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\HubDataPropertyAdapter;
use Rezfusion\Entity\PropertyInterface;

class HubDataPropertyAdapterTest extends AbstractPropertyInterfaceTest
{
    protected function makeEntity(): PropertyInterface
    {
        return new HubDataPropertyAdapter((object) ['item' => (object)[]]);
    }
}

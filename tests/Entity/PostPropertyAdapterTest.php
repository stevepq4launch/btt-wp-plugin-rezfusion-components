<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\PostPropertyAdapter;
use Rezfusion\Entity\PropertyInterface;
use stdClass;

class PostPropertyAdapterTest extends AbstractPropertyInterfaceTest
{
    public function makeEntity(): PropertyInterface
    {
        return new PostPropertyAdapter(new stdClass, []);
    }
}

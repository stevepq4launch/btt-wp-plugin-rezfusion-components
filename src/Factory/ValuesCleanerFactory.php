<?php

namespace Rezfusion\Factory;

use Rezfusion\Helper\Slugifier;
use Rezfusion\ValuesCleaner;

class ValuesCleanerFactory
{
    /**
     * @return ValuesCleaner
     */
    public function make()
    {
        return new ValuesCleaner(new Slugifier);
    }
}

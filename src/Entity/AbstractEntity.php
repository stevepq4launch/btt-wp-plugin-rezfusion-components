<?php

namespace Rezfusion\Entity;

abstract class AbstractEntity implements EntityInterface
{
    /**
     * Retrieve entity data as an array.
     * 
     * @return array
     */
    public function toArray()
    {
        return [];
    }
}

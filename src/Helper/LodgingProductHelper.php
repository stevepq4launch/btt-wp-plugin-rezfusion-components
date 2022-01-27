<?php

namespace Rezfusion\Helper;

class LodgingProductHelper
{
    /**
     * Gets total count of baths, including half baths.
     * @param object $lodgingProduct
     * 
     * @return float
     */
    public function getTotalBaths(object $lodgingProduct): float
    {
        return $lodgingProduct->baths + (isset($lodgingProduct->half_baths)  ? $lodgingProduct->half_baths * 0.5 : 0);
    }
}

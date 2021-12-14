<?php

namespace Rezfusion\Helper;

class CategoriesItemsCounter
{
    public function count($categories): int
    {
        return array_reduce($categories
            ->data
            ->categoryInfo
            ->categories, function ($carry, $category) {
            if ($count = count($category->values))
                $carry += $count;
            return $carry;
        }, 0);
    }
}

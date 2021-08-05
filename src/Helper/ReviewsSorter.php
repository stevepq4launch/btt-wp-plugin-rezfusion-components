<?php

namespace Rezfusion\Helper;

use Rezfusion\Entity\Review;

class ReviewsSorter
{
    /**
     * @param Review[] $reviews
     */
    public function sortByStayDate(array &$reviews = [])
    {
        usort($reviews, function ($Review1, $Review2) {
            return strtotime($Review2->getStayDate()) - strtotime($Review1->getStayDate());
        });
    }
}

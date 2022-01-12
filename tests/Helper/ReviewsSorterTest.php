<?php

namespace Rezfusion\Helper\Registerer;

use Rezfusion\Entity\Review;
use Rezfusion\Helper\ReviewsSorter;
use Rezfusion\Tests\BaseTestCase;

class ReviewsSorterTest extends BaseTestCase
{
    public function testSortByStayDate(): void
    {
        $ReviewsSorter = new ReviewsSorter();
        $Review1 = new Review();
        $Review2 = new Review();
        $Review3 = new Review();
        $Review4 = new Review();

        $Review1->setStayDate('2022-01-02 12:00:00');
        $Review2->setStayDate('2022-01-01 12:00:00');
        $Review4->setStayDate('2022-01-03 12:00:00');
        $Review3->setStayDate('2022-01-01 13:00:00');
        $reviews = [
            $Review1,
            $Review2,
            $Review3,
            $Review4,
        ];
        $ReviewsSorter->sortByStayDate($reviews);

        $this->assertSame($Review4, $reviews[0]);
        $this->assertSame($Review1, $reviews[1]);
        $this->assertSame($Review3, $reviews[2]);
        $this->assertSame($Review2, $reviews[3]);
    }
}

<?php

namespace Rezfusion\Tests\TestHelper;

use stdClass;

class HubReviewHelper
{
    public static function makeMockReview(): object
    {
        $Review = new stdClass;
        $Review->id = mt_rand(0, 1000);
        $Review->headline = 'Mock Review.';
        $Review->arrival = strtotime('TODAY - 3 MONTHS');
        $Review->rating = mt_rand(1, 5);
        $Review->comment = 'Mock Comment.';
        $Review->guest_name = 'Unknown Visitor';
        return $Review;
    }
}

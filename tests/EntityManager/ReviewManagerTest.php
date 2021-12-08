<?php

namespace Rezfusion\Tests;

use Rezfusion\EntityManager\ReviewManager;
use Rezfusion\Tests\TestHelper\ReviewHelper;

class ReviewManagerTest extends BaseTestCase
{
    private function getLastReviewID(): int
    {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT MAX(comment_ID) FROM $wpdb->comments LIMIT 1"));
    }

    public function testSave(): void
    {
        $ReviewManager = new ReviewManager;
        $Review = ReviewHelper::makeReview(ReviewHelper::makeReviewData(1000, 1001));
        $ReviewManager->save($Review);
        $newReviewId = $Review->getId();
        $lastReviewId = $this->getLastReviewID();
        $this->assertNotEmpty($newReviewId);
        $this->assertIsNumeric($newReviewId);
        $this->assertNotEmpty($lastReviewId);
        $this->assertIsNotArray($lastReviewId);
        $this->assertEquals($lastReviewId, $newReviewId);
        $this->assertSame(intval($lastReviewId), intval($newReviewId));
    }
}

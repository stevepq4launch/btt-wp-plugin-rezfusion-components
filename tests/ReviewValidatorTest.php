<?php

/**
 * @file Tests for ReviewValidator
 */

namespace Rezfusion\Tests;

use DateTime;
use Rezfusion\Entity\Review;
use Rezfusion\Validator\ReviewValidator;

class ReviewValidatorTest extends BaseTestCase
{
    public function testReviewValidator()
    {
        $Review = new Review();
        $Review->setTitle("test-review-1");
        $Review->setReview("content");
        $Review->setGuestName("Guest Name");
        $Review->setStayDate(new DateTime());
        $Review->setRating(5);
        $Review->setPropertyName('Property #1');
        $Review->setPostId(1);
        $ReviewValidator = new ReviewValidator($Review);
        $this->assertTrue($ReviewValidator->validate());

        $Review = new Review();
        $Review->setTitle("test-review-2");
        $ReviewValidator = new ReviewValidator($Review);
        $this->assertFalse($ReviewValidator->validate());
    }
}

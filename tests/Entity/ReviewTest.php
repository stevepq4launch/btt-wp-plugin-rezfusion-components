<?php

namespace Rezfusion\Tests\Entity;

use Rezfusion\Entity\Review;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\ReviewHelper;

class ReviewTest extends BaseTestCase
{
    public function testGetters()
    {
        $Review = new Review;
        $this->assertEmpty($Review->getId());
        $this->assertEmpty($Review->getSource());
        $this->assertEmpty($Review->getRating());
        $this->assertEmpty($Review->getTitle());
        $this->assertEmpty($Review->getReview());
        $this->assertEmpty($Review->getStayDate());
        $this->assertEmpty($Review->getCreatedAt());
        $this->assertEmpty($Review->getGuestName());
        $this->assertEmpty($Review->getApproved());
        $this->assertEmpty($Review->getPostId());
        $this->assertEmpty($Review->getPropertyName());
    }

    public function testSetters()
    {
        $Review = new Review;
        extract(ReviewHelper::makeReviewData(1000, 1001));
        $Review->setId($id);
        $Review->setSource($source);
        $Review->setRating($rating);
        $Review->setTitle($title);
        $Review->setReview($review);
        $Review->setStayDate($stayDate);
        $Review->setCreatedAt($createdAt);
        $Review->setGuestName($guestName);
        $Review->setApproved($approved);
        $Review->setPostId($postId);
        $Review->setPropertyName($propertyName);
        $this->assertSame($id, $Review->getId());
        $this->assertSame($source, $Review->getSource());
        $this->assertSame($rating, $Review->getRating());
        $this->assertSame($title, $Review->getTitle());
        $this->assertSame($review, $Review->getReview());
        $this->assertSame($stayDate, $Review->getStayDate());
        $this->assertSame($createdAt, $Review->getCreatedAt());
        $this->assertSame($guestName, $Review->getGuestName());
        $this->assertSame($approved, $Review->getApproved());
        $this->assertSame($postId, $Review->getPostId());
        $this->assertSame($propertyName, $Review->getPropertyName());
    }

    public function testToArray()
    {
        $expectedArray = ReviewHelper::makeReviewData(1000, 1001);
        $Review = ReviewHelper::makeReview($expectedArray);
        $actualArray = $Review->toArray();
        asort($expectedArray);
        asort($actualArray);
        $this->assertEquals($expectedArray, $actualArray);
    }
}

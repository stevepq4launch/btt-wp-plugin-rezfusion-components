<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Entity\Review;
use Rezfusion\EntityManager\ReviewManager;

class ReviewHelper
{
    public static function makeReviewData($reviewId, $postId): array
    {
        return [
            'id' => $reviewId,
            'source' => "test-source",
            'rating' => 5,
            'title' => "Test Review #1",
            'review' => "Very Good Review.",
            'stayDate' => date('Y-m-d', time()),
            'createdAt' => date('Y-m-d', strtotime('YESTERDAY')),
            'guestName' => "Unknown Guest",
            'approved' => false,
            'postId' => $postId,
            'propertyName' => "Property #1",
        ];
    }

    public static function makeReview($data = []): Review
    {
        $Review = new Review;
        extract($data);
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
        return $Review;
    }

    public static function makeMockReviewsForPost($postId, $count = 3): array
    {
        $reviews = [];
        for ($i = 0; $i < $count; $i++) {
            $reviews[] = static::makeReview(static::makeReviewData($i + 1, $postId));
        }
        return $reviews;
    }

    public static function saveReviews(array $reviews = []): array
    {
        $ReviewManager = new ReviewManager;
        foreach ($reviews as $Review) {
            $ReviewManager->save($Review);
        }
        return $reviews;
    }

    public static function makeAndSaveMockReviewsForPost($postId, $count): array
    {
        return static::saveReviews(static::makeMockReviewsForPost($postId, $count));
    }
}

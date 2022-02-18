<?php

namespace Rezfusion\Tests\Repository;

use Rezfusion\Entity\Review;
use Rezfusion\Entity\ReviewInterface;
use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\ReviewRepository;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\ReviewHelper;

class ReviewRepositoryTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        (new DeleteDataService())->deleteReviews();
    }

    private function makeReviewRepository(): ReviewRepository
    {
        return new ReviewRepository(
            (new API_ClientFactory())->make(),
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    private function assertReview(Review $Review): Review
    {
        $this->assertInstanceOf(ReviewInterface::class, $Review);
        $this->assertInstanceOf(Review::class, $Review);
        return $Review;
    }

    private function assertReviewsArray(array $reviews, $reviewsCount): array
    {
        $this->assertIsArray($reviews);
        $this->assertCount($reviewsCount, $reviews);
        foreach ($reviews as $Review) {
            $this->assertReview($Review);
        }
        return $reviews;
    }

    public function testConstructor(): void
    {
        $ReviewRepository = $this->makeReviewRepository();
        $this->assertInstanceOf(ReviewRepository::class, $ReviewRepository);
    }

    public function testGetReviews(): void
    {
        $postId = PostHelper::getRecentPostId();
        $ReviewRepository = $this->makeReviewRepository();
        $reviewsCount = 5;
        ReviewHelper::makeAndSaveMockReviewsForPost($postId, $reviewsCount);
        $reviews = $ReviewRepository->getReviews();
        $this->assertReviewsArray($reviews, $reviewsCount);
    }

    public function testGetReviewsForPost(): void
    {
        $postId = PostHelper::getRecentPostId();
        $ReviewRepository = $this->makeReviewRepository();
        $reviewsCount = 5;
        ReviewHelper::makeAndSaveMockReviewsForPost($postId, $reviewsCount);
        ReviewHelper::makeAndSaveMockReviewsForPost(100000, $reviewsCount);
        ReviewHelper::makeAndSaveMockReviewsForPost(100001, $reviewsCount);
        $allReviews = $ReviewRepository->getReviews();
        $this->assertReviewsArray($allReviews, 15);
        $reviewsForPost = $ReviewRepository->getReviews($postId);
        $this->assertReviewsArray($reviewsForPost, $reviewsCount);
    }

    public function testDeleteReview(): void
    {
        $postId = PostHelper::getRecentPostId();
        $ReviewRepository = $this->makeReviewRepository();
        ReviewHelper::makeAndSaveMockReviewsForPost($postId, 1);
        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertIsInt($Review->getId());
        $ReviewRepository->deleteReview($Review->getId());
        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(0, $reviews);
    }

    public function testGetReview(): void
    {
        $postId = PostHelper::getRecentPostId();
        $ReviewRepository = $this->makeReviewRepository();
        $reviews = ReviewHelper::makeAndSaveMockReviewsForPost($postId, 1);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $reviewId = $Review->getId();
        $this->assertReview($Review);
        $this->assertIsInt($reviewId);
        $FoundReview = $ReviewRepository->getReview($reviewId);
        $this->assertReview($FoundReview);
        $this->assertIsInt($FoundReview->getId());
        $this->assertSame($reviewId, $FoundReview->getId());
    }

    public function testGetReviewWithInvalidId(): void
    {
        $ReviewRepository = $this->makeReviewRepository();
        $this->assertNull($ReviewRepository->getReview(-1));
    }

    public function testGetReviewsByStatus(): void
    {
        $postId = PostHelper::getRecentPostId();
        $ReviewRepository = $this->makeReviewRepository();
        $reviewsCount = 5;
        $reviews = ReviewHelper::makeMockReviewsForPost($postId, $reviewsCount);
        $this->assertReviewsArray($reviews, $reviewsCount);
        $reviews[3]->setApproved(true);
        $reviews[4]->setApproved(true);
        $reviews = ReviewHelper::saveReviews($reviews);
        $this->assertReviewsArray($reviews, $reviewsCount);
        $notApprovedReviews = $ReviewRepository->getReviews($postId, 0);
        $this->assertReviewsArray($notApprovedReviews, 3);
        $approvedReviews = $ReviewRepository->getReviews($postId, 1);
        $this->assertReviewsArray($approvedReviews, 2);
    }
}

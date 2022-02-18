<?php

namespace Rezfusion\Tests\Controller;

use Rezfusion\Controller\ReviewController;
use Rezfusion\Entity\Review;
use Rezfusion\EntityManager\ReviewManager;
use Rezfusion\Repository\ReviewRepository;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\REST_Helper;
use Rezfusion\Tests\TestHelper\ReviewHelper;

class ReviewControllerTest extends BaseTestCase
{
    private function makeController(ReviewRepository $ReviewRepository): ReviewController
    {
        return new ReviewController($ReviewRepository);
    }

    private function prepareReviews($count = 0, $postId = 0, $approved = false): void
    {
        $ReviewManager = new ReviewManager;
        $reviews = [];
        for ($i = 0; $i < $count; $i++) {
            $Review = ReviewHelper::makeReview(ReviewHelper::makeReviewData(3000 + $i, $postId));
            $Review->setApproved($approved);
            $reviews[] = $Review;
        }
        foreach ($reviews as $Review) {
            $ReviewManager->save($Review);
        }
    }

    private function assertReviewArray(array $review = []): void
    {
        $assertKeys = [
            'id',
            'title',
            'rating',
            'stayDate',
            'review',
            'createdAt',
            'source',
            'guestName',
            'approved',
            'postId',
            'propertyName'
        ];
        $this->assertIsArray($review);
        $this->assertCount(11, $review);
        foreach ($assertKeys as $keyToAssert) {
            $this->assertArrayHasKey($keyToAssert, $review);
        }
    }

    public function testReviews(): void
    {
        (new DeleteDataService)->deleteReviews();
        $totalReviews = 12;
        $this->prepareReviews($totalReviews);
        $Controller = $this->makeController(new ReviewRepository());
        $request = REST_Helper::makeRequest();
        $response = $Controller->reviews($request);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);
        $this->assertIsArray($response->data);
        $this->assertCount($totalReviews, $response->data);
        foreach ($response->data as $review) {
            $this->assertReviewArray($review);
        }
    }

    public function testReviewsFail(): void
    {
        $exceptionMessage = 'fail';
        $ReviewRepository = $this->createMock(ReviewRepository::class);
        $ReviewRepository->method('getReviews')->willThrowException(new \Exception($exceptionMessage));
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeRequest();
        $response = $Controller->reviews($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame($exceptionMessage, $response->data['error']);
    }

    public function testSubmitReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeRequest();
        $postId = PostHelper::getRecentPostId();
        $stayDate = date('Y-m-d H:i:s', time());
        $title = 'Review Title';
        $guestName = 'Test Guest';
        $content = 'Review Content';
        $rating = 3;

        $requestBody = [
            'postId' => $postId,
            'title' => $title,
            'guestName' => $guestName,
            'review' => $content,
            'rating' => $rating,
            'stayDate' => $stayDate
        ];
        $request->set_header('content-type', 'application/json');
        $request->set_body(json_encode($requestBody));
        $response = $Controller->submitReview($request);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame($postId, intval($Review->getPostId()));
        $this->assertSame($title, $Review->getTitle());
        $this->assertSame($guestName, $Review->getGuestName());
        $this->assertSame($content, $Review->getReview());
        $this->assertSame($rating, $Review->getRating());
        $this->assertSame($stayDate, $Review->getStayDate());
    }

    public function testSubmitReviewValidationFail(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'postId' => null
        ]);
        $response = $Controller->submitReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame("Review didn't pass validation.", $response->data['error']);
    }

    public function testApproveReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $postId = PostHelper::getRecentPostId();

        $this->prepareReviews(1, $postId);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(false, $Review->getApproved());

        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => $Review->getId()
        ]);
        $response = $Controller->approveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(true, $Review->getApproved());
    }

    public function testApproveReviewWithInvalidReviewId(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => null
        ]);
        $response = $Controller->approveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Invalid Review ID.', $response->data['error']);
    }

    public function testApproveReviewWithNonExistingReview(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => -1
        ]);
        $response = $Controller->approveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Review not found.', $response->data['error']);
    }

    public function testApproveReviewWithAlreadyApprovedReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $postId = PostHelper::getRecentPostId();

        $this->prepareReviews(1, $postId, true);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(true, $Review->getApproved());

        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => $Review->getId()
        ]);
        $response = $Controller->approveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Review already approved.', $response->data['error']);
    }

    public function testDisapproveReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $postId = PostHelper::getRecentPostId();

        $this->prepareReviews(1, $postId, true);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(true, $Review->getApproved());

        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => $Review->getId()
        ]);
        $response = $Controller->disapproveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(false, $Review->getApproved());
    }

    public function testDisapproveReviewWithInvalidReviewId(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => null
        ]);
        $response = $Controller->disapproveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Invalid Review ID.', $response->data['error']);
    }

    public function testDisapproveReviewWithNonExistingReview(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => -1
        ]);
        $response = $Controller->disapproveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Review not found.', $response->data['error']);
    }

    public function testDisapproveReviewWithAlreadyDisapprovedReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $postId = PostHelper::getRecentPostId();

        $this->prepareReviews(1, $postId, false);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);
        $this->assertSame(false, $Review->getApproved());

        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => $Review->getId()
        ]);
        $response = $Controller->disapproveReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Review is not approved.', $response->data['error']);
    }

    public function testDeleteReview(): void
    {
        (new DeleteDataService)->deleteReviews();
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $postId = PostHelper::getRecentPostId();

        $this->prepareReviews(1, $postId);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(1, $reviews);
        $Review = $reviews[0];
        $this->assertInstanceOf(Review::class, $Review);

        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => $Review->getId()
        ]);
        $response = $Controller->deleteReview($request);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);

        $reviews = $ReviewRepository->getReviews($postId);
        $this->assertCount(0, $reviews);
    }

    public function testDeleteReviewWithInvalidReviewId(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => null
        ]);
        $response = $Controller->deleteReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Invalid Review ID.', $response->data['error']);
    }

    public function testDeleteReviewWithNonExistingReview(): void
    {
        $ReviewRepository = new ReviewRepository;
        $Controller = $this->makeController($ReviewRepository);
        $request = REST_Helper::makeJSON_Request(REST_Helper::postMethod(), [
            'id' => -1
        ]);
        $response = $Controller->deleteReview($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Review not found.', $response->data['error']);
    }
}

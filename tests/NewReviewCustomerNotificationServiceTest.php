<?php

namespace Rezfusion\Tests;

use Rezfusion\Entity\Review;
use Rezfusion\Service\NewReviewCustomerNotificationService;
use Rezfusion\Tests\TestHelper\ReviewHelper;

class NewReviewCustomerNotificationServiceTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->Service = new NewReviewCustomerNotificationService();
    }

    private function makeReview(): Review
    {
        return ReviewHelper::makeReview(ReviewHelper::makeReviewData(1000, 1001));
    }

    public function testInvalidEmail()
    {
        $Review = $this->makeReview();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Empty e-mail address.");
        $this->Service->sendEmailNotification($Review, '');
    }

    public function testFailedSend()
    {
        $Review = new Review;
        $result = $this->Service->sendEmailNotification($Review, 'invalid-mail@q4-launch.com');
        $this->assertFalse($result);
    }

    public function testSend()
    {
        $Review = $this->makeReview();
        $result = $this->Service->sendEmailNotification($Review, 'invalid-mail@q4-launch.com');
        $this->assertFalse($result);
    }
}

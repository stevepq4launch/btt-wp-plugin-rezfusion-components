<?php

namespace Rezfusion\Tests\Repository;

use Rezfusion\Client\MemoryCache;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\HubReviewRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\MockReviewsReturningClient;
use Rezfusion\Tests\TestHelper\PropertiesHelper;

class HubReviewRepositoryTest extends BaseTestCase
{
    public function testGetReviews()
    {
        $MockReviewsReturningClient = new MockReviewsReturningClient(
            REZFUSION_PLUGIN_QUERIES_PATH,
            Plugin::getInstance()->getOption(Options::blueprintURL()),
            new MemoryCache()
        );
        $HubReviewRepository = new HubReviewRepository(
            $MockReviewsReturningClient,
            get_rezfusion_option(Options::hubChannelURL())
        );
        $reviewsCount = 7;

        $MockReviewsReturningClient->setMockReviewsCount(7);
        $propertyId = PropertiesHelper::getRandomPropertyId();
        $reviews = $HubReviewRepository->getReviews([$propertyId]);

        $this->assertCount($reviewsCount, $reviews);
    }
}

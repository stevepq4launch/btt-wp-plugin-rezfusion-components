<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Client\CurlClient;
use Rezfusion\Tests\TestHelper\HubReviewHelper;

class MockReviewsReturningClient extends CurlClient
{
    private $mockReviewsCount = 5;

    public function request($query, $variables = [])
    {
        $result = parent::request($query, $variables);
        if (!empty($result->data->lodgingProducts->results)) {
            foreach ($result->data->lodgingProducts->results as $lodgingProduct) {
                if (empty($lodgingProduct->item->reviews)) {
                    $lodgingProduct->item->reviews = [];
                    for ($i = 0; $i < $this->getMockReviewsCount(); $i++) {
                        $lodgingProduct->item->reviews[] = HubReviewHelper::makeMockReview();
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Get the value of mockReviewsCount
     */
    public function getMockReviewsCount()
    {
        return $this->mockReviewsCount;
    }

    /**
     * Set the value of mockReviewsCount
     *
     * @return  self
     */
    public function setMockReviewsCount($mockReviewsCount)
    {
        $this->mockReviewsCount = $mockReviewsCount;

        return $this;
    }
}

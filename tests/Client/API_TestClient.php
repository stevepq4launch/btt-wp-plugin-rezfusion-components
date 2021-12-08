<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\CurlClient;
use Rezfusion\Tests\TestHelper\HubReviewHelper;
use RuntimeException;

class API_TestClient extends CurlClient
{
    /**
     * @var int
     */
    private $mockReviewsCount = 5;

    /**
     * Get the value of mockReviewsCount
     * 
     * @return int
     */
    public function getMockReviewsCount(): int
    {
        return $this->mockReviewsCount;
    }

    /**
     * @param object $lodgingProduct
     * 
     * @return void
     */
    private function mockReviewsForLodgingProduct(object $lodgingProduct): void
    {
        if (empty($lodgingProduct->item->reviews)) {
            $lodgingProduct->item->reviews = [];
            for ($i = 0; $i < $this->getMockReviewsCount(); $i++) {
                $lodgingProduct->item->reviews[] = HubReviewHelper::makeMockReview();
            }
        }
    }

    /**
     * Removes duplicates from dataset.
     * It allows us to run all the tests ignoring integrity of external data.
     * 
     * @param mixed $data
     * 
     * @return void
     */
    private function removeDuplicates($data): void
    {
        $ids = [];
        if (!empty($data->data->lodgingProducts->results)) {
            foreach ($data->data->lodgingProducts->results as $index => $lodgingProduct) {
                $id = $lodgingProduct->item->id;
                if (empty($id)) {
                    throw new RuntimeException('Invalid property ID.');
                }
                if (in_array($id, $ids)) {
                    unset($data->data->lodgingProducts->results[$index]);
                    continue;
                }
                $ids[] = $id;
            }
        }
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

    /**
     * @inheritdoc
     */
    public function getItems($channel, $query = null)
    {
        $result = parent::getItems($channel, $query);
        if (!empty($result->data->lodgingProducts->results)) {
            $this->removeDuplicates($result);
            foreach ($result->data->lodgingProducts->results as $lodgingProduct) {
                $this->mockReviewsForLodgingProduct($lodgingProduct);
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getItem($itemId, $channel, $query = null)
    {
        $results = parent::getItem($itemId, $channel, $query);
        $this->mockReviewsForLodgingProduct($results->data->lodgingProducts->results[0]);
        return $results;
    }

    /**
     * @inheritdoc
     */
    public function request($query, $variables = [])
    {
        $key = $this->cacheKey($query, $variables);
        if (!$this->cache->has($key)) {
            return parent::request($query, $variables);
        }
        throw new RuntimeException(sprintf('Request called for key %s.', $key));
    }
}

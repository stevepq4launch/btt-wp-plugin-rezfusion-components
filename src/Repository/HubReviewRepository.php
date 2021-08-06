<?php

namespace Rezfusion\Repository;

use Rezfusion\Entity\Review;

class HubReviewRepository extends AbstractHubRepository
{

    protected function convertLodgingProductReviewToEntity($review)
    {
        $Review = new Review();
        $Review->setId($review->id);
        $Review->setTitle($review->headline);
        $Review->setStayDate(date('Y-m-d', strtotime($review->arrival)));
        $Review->setRating(intval($review->rating));
        $Review->setReview($review->comment);
        $Review->setApproved(true);
        $Review->setGuestName($review->guest_name);
        $Review->setCreatedAt(null);
        $Review->setSource('rezfusion-hub');
        $Review->setPostId(null);
        return $Review;
    }

    /**
     * @return Review[]
     */
    public function getReviews(array $itemsIds = []): array
    {
        $reviews = [];
        $query = $this->client->getQuery($this->client->getQueriesBasePath() . "/reviews.graphql");
        $data = $this->client->call($query, [
            'channels' => [
                'url' => $this->channel,
            ],
            'itemIds' => $itemsIds
        ]);
        if(!empty($data->data->lodgingProducts->results)){
            foreach ($data->data->lodgingProducts->results as $lodgingProduct) {
                foreach ($lodgingProduct->item->reviews as $review) {
                    $reviews[] = $this->convertLodgingProductReviewToEntity($review);
                }
            }
        }
        return $reviews;
    }
}

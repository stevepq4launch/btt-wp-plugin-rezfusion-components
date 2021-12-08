<?php

namespace Rezfusion\EntityManager;

use Rezfusion\Entity\Review;
use RuntimeException;

/**
 * Manager for handling operations on Review entities.
 */
class ReviewManager
{
    /**
     * @param Review $Review
     * 
     * @return int|false
     */
    public function save(Review $Review)
    {
        $comment = [
            'comment_approved' => intval($Review->getApproved()),
            'comment_author' => $Review->getGuestName(),
            'comment_content' => $Review->getReview(),
            'comment_type' => 'rezfusion-review',
            'comment_post_ID' => $Review->getPostId(),
            'comment_meta' => [
                'title' => $Review->getTitle(),
                'rating' => $Review->getRating(),
                'stay_date' => $Review->getStayDate(),
                'property_name' => $Review->getPropertyName()
            ]
        ];
        $newId = wp_insert_comment($comment);
        // @codeCoverageIgnoreStart
        if (empty($newId)) {
            throw new RuntimeException("Review save failed.");
        }
        // @codeCoverageIgnoreEnd
        $Review->setId($newId);
        return $Review;
    }
}

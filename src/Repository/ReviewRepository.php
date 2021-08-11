<?php

namespace Rezfusion\Repository;

use Rezfusion\Entity\Review;
use Rezfusion\Entity\ReviewInterface;

class ReviewRepository
{

    /**
     * Convert comment object (and meta) into entity.
     * 
     * @param object $comment
     * @param object $commentMeta
     * 
     * @return ReviewInterface
     */
    protected function convertCommentToReview($comment, $commentMeta)
    {
        $Review = new Review();
        $Review->setId(intval($comment->comment_ID));
        $Review->setTitle($commentMeta['title'][0]);
        $Review->setStayDate($commentMeta['stay_date'][0]);
        $Review->setRating(intval($commentMeta['rating'][0]));
        $Review->setReview($comment->comment_content);
        $Review->setApproved(boolval($comment->comment_approved));
        $Review->setGuestName($comment->comment_author);
        $Review->setCreatedAt($comment->comment_date);
        $Review->setSource('wordpress');
        $Review->setPostId($comment->comment_post_ID);
        $Review->setPropertyName($commentMeta['property_name'][0]);
        return $Review;
    }

    /**
     * Delete review.
     * 
     * @param int $reviewId
     * 
     * @return mixed
     */
    public function deleteReview($reviewId)
    {
        return wp_delete_comment($reviewId, true);
    }

    /**
     * Get array of *Review* entities.
     * 
     * @return Review[]
     */
    public function getReviews($postId = null, $status = null): array
    {
        $reviews = [];
        $queryParams = ['type' => 'rezfusion-review'];
        if (!empty($postId))
            $queryParams['post_id'] = $postId;
        if (!is_null($status))
            $queryParams['status'] = $status;
        foreach (get_comments($queryParams) as $comment) {
            $reviews[] = $this->convertCommentToReview($comment, get_comment_meta($comment->comment_ID));
        }
        return $reviews;
    }

    /**
     * Get single review.
     * 
     * @param int $reviewId
     * 
     * @return Review||null
     */
    public function getReview($reviewId)
    {
        if ($comment = get_comment($reviewId)) {
            return $this->convertCommentToReview($comment, get_comment_meta($comment->comment_ID));
        }
        return null;
    }
}

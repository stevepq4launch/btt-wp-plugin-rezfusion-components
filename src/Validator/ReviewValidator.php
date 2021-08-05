<?php

namespace Rezfusion\Validator;

use Rezfusion\Entity\ReviewInterface;

/**
 * Handles validation of Review entity.
 */
class ReviewValidator
{
    /**
     * @var ReviewInterface
     */
    protected $Review;

    /**
     * @param ReviewInterface $Review
     */
    public function __construct(ReviewInterface $Review)
    {
        $this->Review = $Review;
    }

    /**
     * Validate entity.
     * @return boolean
     */
    public function validate()
    {
        $Review = $this->Review;
        return (empty($Review->getTitle())
            || empty($Review->getReview())
            || empty($Review->getGuestName())
            || empty($Review->getStayDate())
            || empty($Review->getRating())
            || empty($Review->getPropertyName())
            || empty($Review->getPostId())) ? false : true;
    }
}

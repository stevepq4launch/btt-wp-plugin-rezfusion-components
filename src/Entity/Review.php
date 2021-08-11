<?php

namespace Rezfusion\Entity;

class Review extends AbstractEntity implements ReviewInterface
{
    protected $id;
    protected $source;
    protected $rating;
    protected $stayDate;
    protected $title;
    protected $review;
    protected $createdAt;
    protected $guestName;
    protected $approved;
    protected $postId;
    protected $propertyName;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setSource($source)
    {
        $this->source = $source;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getStayDate()
    {
        return $this->stayDate;
    }
    public function setStayDate($stayDate)
    {
        $this->stayDate = $stayDate;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getReview()
    {
        return $this->review;
    }
    public function setReview($review)
    {
        $this->review = $review;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function getGuestName()
    {
        return $this->guestName;
    }
    public function setGuestName($guestName)
    {
        $this->guestName = $guestName;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'rating' => $this->getRating(),
            'stayDate' => $this->getStayDate(),
            'review' => $this->getReview(),
            'createdAt' => $this->getCreatedAt(),
            'source' => $this->getSource(),
            'guestName' => $this->getGuestName(),
            'approved' => $this->getApproved(),
            'postId' => $this->getPostId(),
            'propertyName' => $this->getPropertyName()
        ];
    }

    public function setApproved($approved)
    {
        $this->approved = $approved;
    }
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }
}

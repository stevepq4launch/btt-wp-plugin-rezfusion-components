<?php

namespace Rezfusion\Entity;

interface ReviewInterface
{
    public function getId();
    public function getSource();
    public function getTitle();
    public function getReview();
    public function getGuestName();
    public function getStayDate();
    public function getRating();
    public function getPostId();
    public function getCreatedAt();
    public function getApproved();
    public function setId($id);
    public function setSource($source);
    public function setTitle($title);
    public function setReview($review);
    public function setGuestName($guestName);
    public function setStayDate($stayDate);
    public function setRating($rating);
    public function setPostId($postId);
    public function setCreatedAt($createdAt);
    public function setApproved($approved);
    public function setPropertyName($propertyName);
    public function getPropertyName();
}

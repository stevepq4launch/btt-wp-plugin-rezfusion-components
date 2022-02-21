<?php

namespace Rezfusion\Entity;

/**
 * @file Interface for property.
 */
interface PropertyInterface
{
    public function getId();
    public function setId($id): PropertyInterface;
    public function getName();
    public function setName($name): PropertyInterface;
    public function getBeds();
    public function setBeds($beds): PropertyInterface;
    public function getBaths();
    public function setBaths($baths): PropertyInterface;
    public function getPostId();
    public function setPostId($postId): PropertyInterface;
    public function getPostStatus();
    public function setPostStatus($postStatus): PropertyInterface;
    public function getPostType();
    public function setPostType($postType): PropertyInterface;
}

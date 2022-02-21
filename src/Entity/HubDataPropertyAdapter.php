<?php

namespace Rezfusion\Entity;

/**
 * @file This is adapter for Property that is based on data-item returned from hub.
 */
class HubDataPropertyAdapter implements PropertyInterface
{
    /**
     * @var object
     */
    protected $data;

    protected $postId;

    protected $postStatus;

    protected $postType;

    /**
     * @param object $data Data item from hub.
     */
    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function getId()
    {
        return $this->data->item->id;
    }

    public function setId($id): PropertyInterface
    {
        $this->data->item->id = $id;
        return $this;
    }

    public function getBeds()
    {
        return $this->data->beds;
    }

    public function setBeds($beds): PropertyInterface
    {
        $this->data->beds = $beds;
        return $this;
    }

    public function getBaths()
    {
        return $this->data->baths;
    }

    public function setBaths($baths): PropertyInterface
    {
        $this->data->baths = $baths;
        return $this;
    }

    public function getName()
    {
        return $this->data->item->name;
    }

    public function setName($name): PropertyInterface
    {
        $this->data->item->name = $name;
        return $this;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId($postId): PropertyInterface
    {
        $this->postId = $postId;
        return $this;
    }

    public function getPostStatus()
    {
        return $this->postStatus;
    }

    public function setPostStatus($postStatus): PropertyInterface
    {
        $this->postStatus = $postStatus;
        return $this;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function setPostType($postType): PropertyInterface
    {
        $this->postType = $postType;
        return $this;
    }
}

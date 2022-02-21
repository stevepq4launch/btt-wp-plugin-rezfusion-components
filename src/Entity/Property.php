<?php

namespace Rezfusion\Entity;

class Property implements PropertyInterface
{
    protected $id;
    protected $name;
    protected $status;
    protected $beds;
    protected $baths;
    protected $postStatus;
    protected $postId;
    protected $postType;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  PropertyInterface
     */
    public function setId($id): PropertyInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  PropertyInterface
     */
    public function setName($name): PropertyInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  PropertyInterface
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of beds
     */
    public function getBeds()
    {
        return $this->beds;
    }

    /**
     * Set the value of beds
     *
     * @return  PropertyInterface
     */
    public function setBeds($beds): PropertyInterface
    {
        $this->beds = $beds;

        return $this;
    }

    /**
     * Get the value of baths
     */
    public function getBaths()
    {
        return $this->baths;
    }

    /**
     * Set the value of baths
     *
     * @return  PropertyInterface
     */
    public function setBaths($baths): PropertyInterface
    {
        $this->baths = $baths;

        return $this;
    }

    /**
     * Get the value of postStatus
     */
    public function getPostStatus()
    {
        return $this->postStatus;
    }

    /**
     * Set the value of postStatus
     *
     * @return  PropertyInterface
     */
    public function setPostStatus($postStatus): PropertyInterface
    {
        $this->postStatus = $postStatus;

        return $this;
    }

    /**
     * Get the value of postId
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set the value of postId
     *
     * @return  PropertyInterface
     */
    public function setPostId($postId): PropertyInterface
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Get the value of postType
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * Set the value of postType
     *
     * @return  PropertyInterface
     */
    public function setPostType($postType): PropertyInterface
    {
        $this->postType = $postType;

        return $this;
    }
}

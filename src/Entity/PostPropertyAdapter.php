<?php

namespace Rezfusion\Entity;

use Rezfusion\Metas;

class PostPropertyAdapter implements PropertyInterface
{
    /**
     * @var object
     */
    protected $post;

    /**
     * @var array
     */
    protected $meta;

    /**
     * @param object $post Wordpress post object.
     * @param array $meta Wordpress post meta array.
     */
    public function __construct(object $post, array $meta)
    {
        $this->post = $post;
        $this->meta = $meta;
    }

    public function getId()
    {
        return $this->meta[Metas::itemId()][0];
    }

    public function setId($id): PropertyInterface
    {
        $this->meta[Metas::itemId()][0] = $id;
        return $this;
    }

    public function getPostStatus()
    {
        return $this->post->post_status;
    }

    public function setPostStatus($postStatus): PropertyInterface
    {
        $this->post->post_status = $postStatus;
        return $this;
    }

    public function getPostType()
    {
        return $this->post->post_type;
    }

    public function setPostType($postType): PropertyInterface
    {
        $this->post->post_type = $postType;
        return $this;
    }

    public function getPostId()
    {
        return $this->post->ID;
    }

    public function setPostId($postId): PropertyInterface
    {
        $this->post->ID = $postId;
        return $this;
    }

    public function getBaths()
    {
        return intval($this->meta[Metas::baths()][0]);
    }

    public function setBaths($baths): PropertyInterface
    {
        $this->meta[Metas::baths()][0] = intval($baths);
        return $this;
    }

    public function getBeds()
    {
        return intval($this->meta[Metas::beds()][0]);
    }

    public function setBeds($beds): PropertyInterface
    {
        $this->meta[Metas::beds()][0] = intval($beds);
        return $this;
    }

    public function getName()
    {
        return $this->post->post_title;
    }

    public function setName($name): PropertyInterface
    {
        $this->post->post_title = $name;
        return $this;
    }
}

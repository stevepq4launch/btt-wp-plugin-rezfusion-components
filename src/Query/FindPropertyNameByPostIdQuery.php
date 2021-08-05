<?php

namespace Rezfusion\Query;

class FindPropertyNameByPostIdQuery extends AbstractQuery
{
    /**
     * Find property name (post_title) by post ID.
     * 
     * @param int $postId
     * 
     * @return string|null
     */
    public function execute($postId)
    {
        return $this->wpdb->get_var($this->wpdb->prepare("SELECT post_title FROM {$this->wpdb->posts} WHERE ID = %d LIMIT 1", [$postId]));
    }
}

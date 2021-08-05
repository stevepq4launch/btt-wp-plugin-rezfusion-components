<?php

namespace Rezfusion\Query;

class AbstractQuery
{
    /**
     * @var wpdb
     */
    protected $wpdb;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }
}

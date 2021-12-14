<?php

namespace Rezfusion\Tests;

use Rezfusion\Client\Client;

class MockAPI_Client extends Client
{
    private $categories;

    protected function request($query, $variables = [])
    {
        return [];
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategories($channel, $query = null)
    {
        return $this->categories;
    }
}

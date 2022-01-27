<?php

namespace Rezfusion\Tests\TestHelper;

use Rezfusion\Client\CurlClient;

class API_ClientMock extends CurlClient
{
    /**
     * @param $channel
     * @param null $query
     *
     * @return mixed
     * @throws \Exception
     */
    public function getItems($channel, $query = null)
    {
        $variables = [
            'channels' => [
                'url' => $channel,
            ]
        ];

        if (!$query) {
            $query = $this->getQuery("$this->queriesBasePath/items.graphql");
        }
        $res =  $this->call($query, $variables);
        return $res;
    }

    /**
     * @param $channel
     * @param null $query
     *
     * @return mixed
     * @throws \Exception
     */
    public function getCategories($channel, $query = null)
    {
        $variables = [
            'channels' => [
                'url' => $channel,
            ]
        ];
        if (!$query) {
            $query = $this->getQuery("$this->queriesBasePath/categoryinfo.graphql");
        }
        return $this->call($query, $variables);
    }
}

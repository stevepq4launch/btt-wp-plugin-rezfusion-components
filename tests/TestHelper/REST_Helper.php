<?php

namespace Rezfusion\Tests\TestHelper;

use PHPUnit\Framework\TestCase;
use \WP_REST_Response;
use \WP_REST_Request;

class REST_Helper
{
    public static function getMethod(): string
    {
        return 'GET';
    }

    public static function postMethod(): string
    {
        return 'POST';
    }

    public static function JSON_ContentType(): string
    {
        return 'application/json';
    }

    public static function makeRequest($method = '', $body = '', $route = ''): WP_REST_Request
    {
        $Request = new WP_REST_Request($method, $route);
        $Request->set_body($body);
        return $Request;
    }

    public static function makeJSON_Request($method = '', $body = []): WP_REST_Request
    {
        $Request = static::makeRequest($method, json_encode($body));
        $Request->set_header('content-type', static::JSON_ContentType());
        return $Request;
    }

    /**
     * @param WP_REST_Request $Request
     * 
     * @return WP_REST_Response
     */
    public static function doRequest(WP_REST_Request $Request, TestCase $Test)
    {
        $Response = rest_do_request($Request);
        $Test->assertInstanceOf(WP_REST_Response::class, $Response);
        return $Response;
    }
}

<?php

namespace Rezfusion\Tests\Controller;

use Rezfusion\Controller\ItemController;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\REST_Helper;
use Rezfusion\Tests\TestHelper\UserHelper;

class ItemControllerTest extends BaseTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testFetchData(): void
    {
        UserHelper::logInAdminUser();
        $request = REST_Helper::makeRequest(REST_Helper::getMethod(), '', '/rezfusion/fetch-data');
        $response = REST_Helper::doRequest($request, $this);
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);
        $this->assertSame('Items data refreshed.', $response->data['message']);
    }

    public function testFetchDataFail(): void
    {
        $exceptionMessage = 'Data refresh failed.';
        $Controller = new ItemController(function () use ($exceptionMessage) {
            throw new \Exception($exceptionMessage);
        });
        $request = REST_Helper::makeRequest();
        $response = $Controller->fetchData($request);
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame($exceptionMessage, $response->data['error']);
    }
}

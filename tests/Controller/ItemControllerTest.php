<?php

namespace Rezfusion\Tests\Controller;

use ReflectionClass;
use Rezfusion\Controller\ItemController;
use Rezfusion\LogEntryCollection;
use Rezfusion\Provider\HubDataSynchronizationLogEntryCollectionProvider;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\REST_Helper;
use Rezfusion\Tests\TestHelper\UserHelper;
use RuntimeException;

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
        REST_Helper::assertResponse($this, $response, 400, $exceptionMessage);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDataSyncLogEntriesFail(): void
    {
        $exceptionMessage = 'fail';
        $ReflectionClass = new ReflectionClass(HubDataSynchronizationLogEntryCollectionProvider::class);
        $prop = $ReflectionClass->getProperty('LogEntryCollection');
        $prop->setAccessible(true);
        $LogCollection = $this->createMock(LogEntryCollection::class);
        $LogCollection->method('getEntries')->willThrowException(new RuntimeException($exceptionMessage));
        $prop->setValue($LogCollection);
        $Controller = new ItemController(function () {
        });
        $request = REST_Helper::makeRequest();
        $response = $Controller->dataSyncLogEntries($request);
        REST_Helper::assertResponse($this, $response, 400, $exceptionMessage);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDataSyncLogEntries(): void
    {
        $Controller = new ItemController(function () {
        });
        $Response = $Controller->dataSyncLogEntries(REST_Helper::makeRequest());
        REST_Helper::assertResponse($this, $Response, 200);
        $this->assertArrayHasKey('entries', $Response->data);
        $entries = $Response->data['entries'];
        $this->assertIsArray($entries);
    }
}

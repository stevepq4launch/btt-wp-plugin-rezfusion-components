<?php

namespace Rezfusion\Tests\Controller;

use Rezfusion\Actions;
use Rezfusion\Controller\AbstractController;
use Rezfusion\Controller\ItemController;
use Rezfusion\Registerer\ControllersRegisterer;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\REST_Helper;
use Rezfusion\Tests\TestHelper\TestHelper;
use Rezfusion\Tests\TestHelper\UserHelper;
use Rezfusion\UserRoles;

class ControllerTest extends BaseTestCase
{
    private function makeControllerMock(): AbstractController
    {
        $Controller = $this->createMock(AbstractController::class);
        return $Controller;
    }

    private function doTestRequest(): \WP_REST_Response
    {
        (new ControllersRegisterer)->register();
        $Request = REST_Helper::makeRequest(REST_Helper::getMethod(), '', '/rezfusion/configuration');
        return REST_Helper::doRequest($Request, $this);
    }

    public function testRegisterer(): void
    {
        $Registerer = new ControllersRegisterer();
        $Registerer->register();
        $this->assertTrue(true);
        do_action(Actions::restAPI_Init());
    }

    public function testRoutesAreRegistered(): void
    {
        $Registerer = new ControllersRegisterer();
        $Registerer->register();
        $Request = REST_Helper::makeRequest(REST_Helper::getMethod(), '', '/');
        $Response = REST_Helper::doRequest($Request, $this);
        $existingRoutes = $Response->data['routes'];
        $routesToCheck = [
            '/fetch-data',
            '/submit-review',
            '/reviews',
            '/approve-review/(?P<id>\d+)',
            '/disapprove-review/(?P<id>\d+)',
            '/delete-review/(?P<id>\d+)',
            '/configuration/reload',
            '/configuration',
        ];
        foreach ($routesToCheck as $route) {
            $this->assertArrayHasKey('/rezfusion' . $route, $existingRoutes);
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCheckUserRolesWithValidRole(): void
    {
        $Controller = $this->makeControllerMock();
        UserHelper::logInAdminUser();
        $result = TestHelper::callClassMethod($Controller, 'checkUserRoles', [['administrator']]);
        $this->assertTrue($result);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCheckUserRolesWithInvalidRole(): void
    {
        UserHelper::logInAdminUser();
        $Controller = $this->makeControllerMock();
        $result = TestHelper::callClassMethod($Controller, 'checkUserRoles', [['invalid-role']]);
        $this->assertFalse($result);
    }

    public function testRegisterRoutes(): void
    {
        $Controller = $this->makeControllerMock();
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRequest(): void
    {
        UserHelper::logInAdminUser();
        $response = $this->doTestRequest();
        $this->assertIsObject($response->data);
        $this->assertSame(200, $response->status);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRequestWithInvalidUser(): void
    {
        $response = $this->doTestRequest();
        $this->assertIsArray($response->data);
        $this->assertSame('Access denied.', $response->data['error']);
        $this->assertSame(403, $response->status);
    }
}

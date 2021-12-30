<?php

namespace Rezfusion\Controller;

use Exception;
use Rezfusion\Factory\FloorPlanRepositoryFactory;
use Rezfusion\Repository\FloorPlanRepository;
use Rezfusion\UserRoles;
use RuntimeException;
use \WP_REST_Response;
use \WP_REST_Request;
use \WP_REST_Server;

/**
 * @file Controller for handling floor plans related operations.
 */
class FloorPlanController extends AbstractController
{
    /**
     * @inheritdoc
     */
    protected function makeRoutes(): array
    {
        return [
            '/floor-plans' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'floorPlans',
                'allowedRoles' => [UserRoles::administrator()]
            ],
            '/update-floor-plans' => [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => 'updateFloorPlans',
                'allowedRoles' => [UserRoles::administrator()]
            ]
        ];
    }

    /**
     * @return FloorPlanRepository
     */
    private function makeFloorPlanRepository(): FloorPlanRepository
    {
        return (new FloorPlanRepositoryFactory)->make();
    }

    /**
     * Fetch properties floor plans data.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function floorPlans(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $FloorPlanRepository = $this->makeFloorPlanRepository();
            $returnData = [
                'items' => $FloorPlanRepository->findAll()
            ];
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = ['error' => $Exception->getMessage()];
            $statusCode = 400;
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Update properties floor plans.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function updateFloorPlans(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $requestData = $request->get_json_params();
            $items = @$requestData['items'];
            if (!$items || !is_array($items)) {
                throw new RuntimeException('Invalid items.');
            }
            $FloorPlanRepository = $this->makeFloorPlanRepository();
            foreach ($items as $item) {
                $FloorPlanRepository->save($item);
            }
            $returnData = ['message' => 'Done.'];
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = ['error' => $Exception->getMessage()];
            $statusCode = 400;
        }
        return $this->returnJSON($returnData, $statusCode);
    }
}

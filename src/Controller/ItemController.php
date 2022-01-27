<?php

namespace Rezfusion\Controller;

use Exception;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Provider\HubDataSynchronizationLogEntryCollectionProvider;
use Rezfusion\UserRoles;
use \WP_REST_Response;
use \WP_REST_Request;
use \WP_REST_Server;

/**
 * @file Controller for handling items related operations.
 */
class ItemController extends AbstractController
{
    /**
     * @var callable
     */
    private $refreshData;

    public function __construct(callable $refreshData)
    {
        $this->refreshData = $refreshData;
    }

    /**
     * @inheritdoc
     */
    protected function makeRoutes(): array
    {
        return [
            '/fetch-data' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'fetchData',
                'allowedRoles' => [UserRoles::administrator()]
            ],
            '/data-sync-log-entries' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'dataSyncLogEntries',
                'allowedRoles' => [UserRoles::administrator()]
            ]
        ];
    }

    /**
     * Fetch and update properties data.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function fetchData(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            ($this->refreshData)();
            OptionManager::update(Options::triggerRewriteFlush(), 1);
            $returnData = ['message' => 'Items data refreshed.'];
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = ['error' => $Exception->getMessage()];
            $statusCode = 400;
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Fetch log entries for data synchronization.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function dataSyncLogEntries(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $LogEntryCollection = HubDataSynchronizationLogEntryCollectionProvider::getInstance();
            $entries = array_map(function ($LogEntry) {
                return $LogEntry->toArray();
            }, $LogEntryCollection->getEntries());
            $returnData = ['entries' => $entries];
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = ['error' => $Exception->getMessage()];
        }
        return $this->returnJSON($returnData, $statusCode);
    }
}

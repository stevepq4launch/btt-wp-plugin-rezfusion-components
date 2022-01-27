<?php

namespace Rezfusion\Controller;

use Rezfusion\UserRoles;

use Exception;
use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;
use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Configuration\HubConfigurationUpdater;
use \WP_REST_Response;
use \WP_REST_Request;
use \WP_REST_Server;

/**
 * Controller for handling configuration.
 */
class ConfigurationController extends AbstractController
{
    /**
     * @inheritdoc
     */
    protected function makeRoutes(): array
    {
        return [
            '/configuration/reload' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'reloadConfiguration',
                'allowedRoles' => [UserRoles::administrator()]
            ],
            '/configuration' => [
                'methods' => WP_REST_Server::READABLE,
                'callback' => 'loadConfiguration',
                'allowedRoles' => [UserRoles::administrator()]
            ]
        ];
    }

    public function __construct(
        HubConfiguration $HubConfiguration,
        HubConfigurationUpdater $HubConfigurationUpdater
    ) {
        $this->HubConfiguration = $HubConfiguration;
        $this->HubConfigurationUpdater = $HubConfigurationUpdater;
    }

    /**
     * Reload configuration.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function reloadConfiguration(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            // $Configuration = HubConfigurationProvider::getInstance();
            // $ConfigurationUpdater = new HubConfigurationUpdater(
            //     $Configuration,
            //     new RemoteConfigurationStorage($Configuration->getComponentsURL(), get_class($Configuration))
            // );
            if ($this->HubConfigurationUpdater->update() === false) {
                throw new Exception("Update failed.");
            }
            $this->HubConfiguration->saveConfiguration();
            $returnData = true;
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = $Exception->getMessage();
            $statusCode = 400;
        }
        return $this->returnJSON($returnData, $statusCode);
    }

    /**
     * Fetch configuration.
     * 
     * @param WP_REST_Request
     * 
     * @return WP_REST_Response
     */
    public function loadConfiguration(WP_REST_Request $request): WP_REST_Response
    {
        $returnData = [];
        $statusCode = 400;
        try {
            $returnData = $this->HubConfiguration->getConfiguration();
            $statusCode = 200;
        } catch (Exception $Exception) {
            $returnData = $Exception->getMessage();
            $statusCode = 400;
        }
        return $this->returnJSON($returnData, $statusCode);
    }
}

<?php

namespace Rezfusion\Controller;

use Rezfusion\Actions;
use \WP_REST_Response;

abstract class AbstractController
{

    /**
     * @var string
     */
    const API_URL = 'rezfusion';

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @return array
     */
    abstract protected function makeRoutes(): array;

    /**
     * Registers routes.
     * 
     * @param array $routes
     */
    protected function registerRoutes($routes): void
    {
        foreach ($routes as $route => $routeParameters) {
            add_action(Actions::restAPI_Init(), function () use ($route, $routeParameters) {
                register_rest_route(static::API_URL, $route, [
                    'methods' => $routeParameters['methods'],
                    'callback' => function ($request) use ($routeParameters, $route) {
                        return static::preCallback($route, $routeParameters, $request);
                    }
                ]);
            });
        }
    }

    /**
     * Checks if current user has required roles.
     * 
     * @param string[] $userRoles
     * 
     * @return bool
     */
    protected function checkUserRoles(array $userRoles = []): bool
    {
        $valid = true;
        if (count($userRoles)) {
            $valid = false;
            foreach ($userRoles as $role) {
                if (current_user_can($role)) {
                    $valid = true;
                    break;
                }
            }
        }
        return $valid;
    }

    /**
     * Method executed before every request.
     * 
     * @param mixed $route
     * @param mixed $routeParameters
     * @param mixed $request
     * 
     * @return object
     */
    public function preCallback($route, $routeParameters, $request): object
    {
        if (
            array_key_exists('allowedRoles', $routeParameters)
            && is_array($routeParameters['allowedRoles'])
            && $this->checkUserRoles($routeParameters['allowedRoles']) === false
        )
            return new WP_REST_Response(array('error' => 'Access denied.'), 403);
        $callback = $routeParameters['callback'];
        return $this->$callback($request);
    }

    /**
     * Initialize controller.
     * 
     * @return void
     */
    public function initialize(): void
    {
        if (empty($this->routes))
            $this->routes = $this->makeRoutes();
        $this->registerRoutes($this->routes);
    }

    /**
     * Returns JSON response with status code.
     * 
     * @param mixed $data
     * @param mixed $statusCode
     * 
     * @return WP_REST_Response
     */
    public function returnJSON($data, $statusCode): WP_REST_Response
    {
        return new WP_REST_Response($data, $statusCode);
    }
}

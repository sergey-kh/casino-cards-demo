<?php

namespace TestProject\CasinoCards\RestApi;

use TestProject\CasinoCards\RestApi\Routes\CasinoRoute;

/**
 * RestApiRegister class
 */
class RestApiRegister
{
    private array $routes = [
        CasinoRoute::class
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    /**
     * @return void
     */
    public function registerRoutes(): void
    {
        foreach ($this->routes as $routeClass) {
            $route = new $routeClass();
            foreach ($route->getRoutes() as $path => $args) {
                register_rest_route($route->getNamespace(), '/' . ltrim((string) $path, '/'), $args);
            }
        }
    }
}

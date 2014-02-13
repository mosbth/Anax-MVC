<?php

namespace Anax\Route;

/**
 * A container for routes.
 *
 */
class CRouterBasic
{

    /**
    * Properties
    *
    */
    private $routes;  // All the routes



    /**
     * Add a route to the router.
     *
     * @param string $rule         for this route
     * @param callable $controller callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function add($rule, $controller) 
    {
        $route = new CRouteBasic($rule, $controller);
        $this->routes[] = $route;
        return $route;
    }



    /**
     * Handle the routes and match them towards the request, dispatch them when a match is made.
     *
     * @return $this
     */
    public function handle() 
    {
        ;
    }
}

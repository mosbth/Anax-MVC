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

/*
From Lydia CRequest::Init
        // Set controller, action and arguments
        $controller =  !empty($rp[0]) ? $rp[0] : 'index';
        $action     =  !empty($rp[1]) ? $rp[1] : 'index';
        $arguments  = $splits;
        unset($arguments[0], $arguments[1]); // remove controller & method part from argument list
*/

}

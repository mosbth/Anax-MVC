<?php

namespace Anax\Route;

/**
 * A container for routes.
 *
 */
class CRouterBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
    * Properties
    *
    */
    private $routes;   // All the routes
    private $notFound; // All the routes



    /**
     * Add a route to the router.
     *
     * @param string   $rule   for this route
     * @param callable $action callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function add($rule, $action) 
    {
        $route = new CRouteBasic($rule, $action);
        $this->routes[] = $route;
        return $route;
    }



    /**
     * Add an action for routes not found.
     *
     * @param callable $action callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function addNotFound($action) 
    {
        $this->notFound = new CRouteBasic(null, $action);
        return $this->notFound;
    }



    /**
     * Handle the routes and match them towards the request, dispatch them when a match is made.
     *
     * @return $this
     */
    public function handle() 
    {
        $query = $this->di->request->getRoute();
        $parts = $this->di->request->getRouteParts();

        foreach ($this->routes as $route) {
            if ($route->match($query)) {
                return $route->handle();
            }
        }

        $this->notFound->handle();
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

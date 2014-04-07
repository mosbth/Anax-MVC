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
     * @param string $rule   for this route
     * @param mixed  $action null, string or callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function add($rule, $action = null) 
    {
        $route = $this->di->get('route');
        $route->set($rule, $action);
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
        $route = $this->di->get('route');
        $route->set(null, $action);
        $this->notFound = $route;
        return $route;
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

        // Match predefined routes
        foreach ($this->routes as $route) {
            if ($route->match($query)) {
                return $route->handle();
            }
        }

        // Default handling route as :controller/:action/:params using the dispatcher
        $dispatcher = $this->di->dispatcher;
        $dispatcher->setControllerName(isset($parts[0]) ? $parts[0] : 'index');

        if ($dispatcher->isValidController()) {

            $dispatcher->setActionName(isset($parts[1]) ? $parts[1] : 'index');

            $params = [];
            if (isset($parts[2])) {
                $params = $parts;
                array_shift($params);
                array_shift($params);
            }
            $dispatcher->setParams($params);

            if ($dispatcher->isCallable()) {
                return $dispatcher->dispatch();
            }
        }

        // No route was matched
        $this->notFound->handle();
    }
}

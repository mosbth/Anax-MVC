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
    private $routes;         // All the routes
    private $internalRoutes; // All internal routes



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
     * Add an internal (not exposed to url-matching) route to the router.
     *
     * @param string $rule   for this route
     * @param mixed  $action null, string or callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function addInternal($rule, $action = null)
    {
        $route = $this->di->get('route');
        $route->set($rule, $action);
        $this->internalRoutes[$rule] = $route;
        return $route;
    }



    /**
     * Add an internal (not exposed to url-matching) route to the router.
     *
     * @param string $rule   for this route
     * @param mixed  $action null, string or callable to implement a controller for the route
     *
     * @return class as new route
     */
    public function handleInternal($rule)
    {
        if (isset($this->internalRoutes[$rule])) {
            $route = $this->internalRoutes[$rule];
            $route->handle();
        } else {
            throw new \Anax\Exception\NotFoundException("No internal route to handle: " . $rule);
        }
    }



    /**
     * Handle the routes and match them towards the request, dispatch them when a match is made.
     *
     * @return $this
     */
    public function handle()
    {
        try {

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
            $this->handleInternal('404');
        
        } catch (\Exception $e) {

            // Exception codes can match a route for a http status code
            $code = $e->getCode();
            $statusCodes = [403, 404, 500];
            if (in_array($code, $statusCodes)) {

                $this->di->flash->setMessage($e->getMessage());
                $this->handleInternal($code);
            
            } else {
                throw $e;
            }
        }
    }
}

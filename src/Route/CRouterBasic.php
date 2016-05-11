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
    private $routes         = [];    // All the routes
    private $internalRoutes = [];    // All internal routes
    private $defaultRoute   = null;  // A default rout to catch all



    /**
     * Get all routes.
     *
     * @return array with all routes.
     */
    public function getAll()
    {
        return $this->routes;
    }



    /**
     * Get all internal routes.
     *
     * @return array with internal routes.
     */
    public function getInternal()
    {
        return $this->internalRoutes;
    }



    /**
     * Add a route to the router.
     *
     * @param string $rule   for this route
     * @param mixed  $action null, string or callable to implement a controller for the route
     *
     * @return object as new route
     */
    public function add($rule, $action = null)
    {
        $route = $this->di->get('route');
        $route->set($rule, $action);
        $this->routes[] = $route;

        // Set as default route
        if ($rule == "*") {
            $this->defaultRoute = $route;
        }
        
        return $route;
    }



    /**
     * Add an internal (not exposed to url-matching) route to the router.
     *
     * @param string $rule   for this route
     * @param mixed  $action null, string or callable to implement a controller for the route
     *
     * @return object as new route
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
     * @param string $rule for this route
     *
     * @return object as new route
     * @throws \Anax\Exception\NotFoundException
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
     * @throws \Anax\Exception\NotFoundException
     * @throws \Exception
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

            $dispatcher->setControllerName();

            // Checks if the first part is a valid controller.
            if (isset($parts[0])) {
                $dispatcher->setControllerName($parts[0]);

                // If not valid then ignore the first param and sets the default.
                if ($dispatcher->isValidController()) {
                    array_shift($parts);
                } else {
                    $dispatcher->setControllerName();
                }
            }

            if ($dispatcher->isValidController()) {

                // Checks if a action is set. If not then will use index action.
                $dispatcher->setActionName();

                if (isset($parts[0])) {
                    $dispatcher->setActionName($parts[0]);

                    if ($dispatcher->isCallable()) {
                        array_shift($parts);
                    } else {
                        $dispatcher->setActionName();
                    }
                }

                if ($dispatcher->isCallable()) {

                    $parts = !empty($parts) ? $parts : [];
                    $dispatcher->setParams($parts);

                    // Checks if the are correct number of params that the action accepts
                    if ($dispatcher->isParamsValid()) {
                        return $dispatcher->dispatch();
                    }
                }

            }

            // Use the "catch-all" route
            if ($this->defaultRoute) {
                return $this->defaultRoute->handle();
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

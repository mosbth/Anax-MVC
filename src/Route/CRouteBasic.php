<?php

namespace Anax\Route;

/**
 * A container for routes.
 *
 */
class CRouteBasic
{

    /**
    * Properties
    *
    */
    private $name;       // A name for this route
    private $rule;       // The rule for this route
    private $controller; // The callable controller to handle this route



    /**
     * Construct a new route.
     *
     * @param string   $rule       for this route
     * @param callable $controller callable to implement a controller for the route
     */
    public function __construct($rule, $controller) 
    {
        $this->rule = $rule;
        $this->controller = $controller;
    }



    /**
     * Set the name of the route.
     *
     * @param string $name set a name for the route
     *
     * @return $this
     */
    public function setName($name) 
    {
        $this->name = $name;
        return $this;
    }
}
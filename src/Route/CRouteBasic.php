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
    private $name;   // A name for this route
    private $rule;   // The rule for this route
    private $action; // The controller action to handle this route



    /**
     * Set values for route.
     *
     * @param string   $rule   for this route
     * @param callable $action callable to implement a controller for the route
     *
     * @return $this
     */
    public function set($rule, $action) 
    {
        $this->rule = $rule;
        $this->action = $action;

        return $this;
    }



    /**
     * Check if the route matches a query
     *
     * @param string $query to match against
     *
     * @return boolean true if query matches the route
     */
    public function match($query) 
    {
        if ($this->rule == $query) {
            return true;
        }
        return false;
    }



    /**
     * Handle the action for the route.
     *
     * @return void
     */
    public function handle() 
    {
        return call_user_func($this->action);
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
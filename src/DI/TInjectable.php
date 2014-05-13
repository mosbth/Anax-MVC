<?php

namespace Anax\DI;

/**
 * Interface to implement for DI aware services to let them know of the current $di
 *
 */
trait TInjectable
{

    /**
     * Properties
     */
    protected $di; // the service container



    /**
     * Set the service container to use
     *
     * @param class $di a service container
     *
     * @return $this
     */
    public function setDI($di)
    {
        $this->di = $di;
    }



    /**
     * Magic method to get and create services. 
     * When created it is also stored as a parameter of this object.
     *
     * @param string $service name of class property not existing.
     *
     * @return class as the service requested.
     */
    public function __get($service)
    {
        $this->$service = $this->di->get($service);
        return $this->$service;
    }



   /**
     * Magic method to get and create services as a method call. 
     * When created it is also stored as a parameter of this object.
     *
     * @param string $service   name of class property not existing.
     * @param array  $arguments Additional arguments to sen to the method (NOT IMPLEMENTED).
     *
     * @return class as the service requested.
     */
    public function __call($service, $arguments = [])
    {
        $this->$service = $this->di->get($service);
        return $this->$service;
    }
}

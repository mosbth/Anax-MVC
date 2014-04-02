<?php

namespace Anax\DI;

/**
 * Anax base class implementing Dependency Injection / Service Locator of the services used by the 
 * framework, using lazy loading.
 *
 */
class CDI implements IDI
{

    /**
     * Properties
     *
     */
    public $loaded = [];  // Store all lazy loaded services, ready to be instantiated
    public $active = [];  // A service is instantiated into this array, once its accessed  



    /**
     * Construct.
     *
     */
    public function __construct()
    {
        ;
    }



    /**
     * Set a service and connect it to a task which creates the object (lazy loading).
     *
     * @param string  $service   as a service label, naming this service.
     * @param mixed   $loader    contains a pre-defined object, a string with classname or an
     *      callable which returns an instance of the service object. Its the way to 
     *      actually load, insantiate, the serviceobject.
     * @param boolean $singleton set if service is to act as singleton or not, default is false.
     *
     * @return nothing.
     */
    public function set($service, $loader, $singleton = false)
    {
        $this->loaded[$service]['loader'] = $loader;
        $this->loaded[$service]['singleton'] = $singleton;
    }



    /**
     * Set a singleton service and connect it to a task which creates the object (lazy loading).
     *
     * @param string $service as a service label, naming this service.
     * @param mixed  $loader  contains a pre-defined object, a string with classname or an
     *      callable which returns an instance of the service object. Its the way to 
     *      actually load, insantiate, the serviceobject.
     *
     * @return nothing.
     */
    public function setShared($service, $loader)
    {
        $this->set($service, $loader, true);
    }



    /**
     * Get an instance of the service object, managing singletons.
     *
     * @param string $service as a service label, naming this service.
     *
     * @return object as instance of the service object.
     * @throws Exception when service accessed is not loaded. 
     */
    public function get($service)
    {
        // Is the service active?
        if (isset($this->active[$service])) {
            if ($this->loaded[$service]['singleton']) {
                return $this->active[$service];
            } else {
                return $this->load($service);
            }
        } elseif (isset($this->loaded[$service])) {
            // Is the service loaded?
            return $this->load($service);
        }

        throw new \Exception("The service accessed is not loaded in the DI-container.");
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
        return $this->get($service);
    }



    /**
     * Check if service exists by name.
     *
     * @param string $service as a service label, naming this service.
     *
     * @return boolean true if the service exists, otherwise false.
     */
    public function has($service)
    {
        return isset($this->loaded[$service])
            ? true
            : false;
    }



    /**
     * Lazy load a service object and create an instance of it.
     *
     * @param string $service as a service label, naming this service.
     *
     * @return object as instance of the service object.
     * @throws Exception when service could not be loaded. 
     */
    protected function load($service)
    {
        $sol = isset($this->loaded[$service]['loader']) 
            ? $this->loaded[$service]['loader']
            : null;

        // Load by calling a function
        if (is_callable($sol)) {
            $this->active[$service] = $sol();
        } elseif (is_object($sol)) {
            // Load by pre-instantiated object
            $this->active[$service] = $sol;
        } elseif (is_string($sol)) {
            // Load by creating a new object from class-string
            $this->active[$service] = new $sol();
        } else {
            throw new Exception("The service could not be loaded.");
        }

        $this->$service = $this->active[$service];
        return $this->active[$service];
    }
}

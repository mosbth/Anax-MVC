<?php

namespace Anax\DI;

/**
 * A DI used with Anax should implement this interface.
 *
 */
interface IDI
{
    /**
     * Get an instance of the service object, managing singletons.
     *
     * @param string $service as a service label, naming this service.
     *
     * @return object as instance of the service object.
     * @throws Exception when service accessed is not loaded. 
     */
    public function get($service);
}
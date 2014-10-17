<?php

namespace Anax\DI;

/**
 * Interface to implement for DI aware services to let them know of the current $di
 *
 */
interface IInjectionAware
{
    /**
     * Set the service container to use
     *
     * @param class $di a service container
     *
     * @return $this
     */
    public function setDI($di);
}

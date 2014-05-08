<?php

namespace Anax\DI;

/**
 * Interface to implement for DI aware services to let them know of the current $di
 *
 */
trait TInjectionAware
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
}

<?php

namespace Anax\MVC;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CApplicationBasic
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Construct.
     *
     * @param array $di dependency injection of service container.
     */
    public function __construct($di)
    {
        $this->di = $di;
    }
}

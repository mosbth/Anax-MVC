<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax\Kernel;

class CAnaxSingleton extends CAnax implements \Anax\ISingleton
{
    use \Anax\TSingleton;


    /**
     * Construct.
     *
     * @param array $di
     */
    public function __construct($di)
    {
        parent::__construct($di);
    }
}

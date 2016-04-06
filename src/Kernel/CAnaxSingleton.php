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
     */
    public function __construct()
    {
        parent::__construct();
    }
}

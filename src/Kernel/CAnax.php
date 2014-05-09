<<<<<<< HEAD
<?php

namespace Anax\Kernel;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CAnax
{
    use \Anax\DI\TInjectable;



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
=======
<?php

namespace Anax\Kernel;

/**
 * Anax base class for an application.
 *
 */
class CAnax
{
    use \Anax\DI\TInjectable;



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
>>>>>>> upstream/master

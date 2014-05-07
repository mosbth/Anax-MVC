<?php

namespace Anax\MVC;

/**
 * A container for routes.
 *
 */
class CDispatcherBasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test 
     *
     * @return void
     *
     * @expectedException Exception
     *
     */
    public function testDispatchWrongRoute1()
    {
        $disp = new \Anax\MVC\CDispatcherBasic();
        $disp->dispatch();
    }



    /**
     * Test 
     *
     * @return void
     *
     * @expectedException Exception
     *
     */
    public function testDispatchWrongRoute2()
    {
        $di = new \Anax\DI\CDI();
        $disp = new \Anax\MVC\CDispatcherBasic();
        $disp->setDI($di);

        $disp->setControllerName('not-exists');
        $disp->setActionName('not-exists');
        $disp->dispatch();
    }
}

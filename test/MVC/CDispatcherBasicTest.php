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
        $di = new \Anax\DI\CDI();
        $disp = new \Anax\MVC\CDispatcherBasic();
        $disp->setDI($di);
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



    /**
     * Test
     *
     * @return void
     */
    public function testDispatchParamsValidator()
    {
        $di = new \Anax\DI\CDI();
        $di->set("ErrorController", function () {
            return new \Anax\MVC\ErrorController();
        });
        $disp = new \Anax\MVC\CDispatcherBasic();
        $disp->setDI($di);

        $disp->setControllerName("Error");
        $disp->setActionName("statusCode");

        $disp->setParams(["this", "is", "not", "valid"]);
        $this->assertFalse($disp->isParamsValid());

        $disp->setParams(["very", "valid"]);
        $this->assertTrue($disp->isParamsValid());

        $disp->setParams();
        $this->assertTrue($disp->isParamsValid());
    }
}

<?php

namespace Anax\DI;

/**
 * Testing the Dependency Injector service container.
 *
 */
class CDITest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test 
     *
     * @return void
     *
     * @expectedException \Exception
     */
    public function testLoadFailesInServiceCreation()
    {
        $di = new \Anax\DI\CDI();
        $service = 'failsWithException';

        $di->set($service, function () {
            throw new \Exception("Failed creating service.");
        });

        $di->get($service);
    }



    /**
     * Test 
     *
     * @return void
     *
     */
    public function testOverwritePreviousDefinedService()
    {
        $di = new \Anax\DI\CDIFactoryDefault();
        $service = 'session';

        $di->set($service, function () {
            $session = new \Anax\Session\CSession();
            $session->configure(ANAX_APP_PATH . 'config/session.php');
            $session->name();
            //$session->start();
            return $session;
        });

        $session = $di->get($service);
        $this->assertInstanceOf('\Anax\Session\CSession', $session);
    }
}

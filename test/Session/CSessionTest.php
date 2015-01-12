<?php

namespace Anax\Request;

/**
 * Testing framework session class.
 *
 */
class CSessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test 
     *
     * @return void
     *
     */
    public function testLoadConfig()
    {
        $session = new \Anax\Session\CSession();
        $session->configure(ANAX_APP_PATH . 'config/session.php');
    }



    /**
     * Test 
     *
     * @return void
     *
     */
    public function testSetName()
    {
        $session = new \Anax\Session\CSession();
        $name = "someName";

        $session->name($name);

        $this->assertEquals($name, session_name(), "Session name does not match.");
    }



    /**
     * Test 
     *
     * @return void
     *
     */
    public function testGetSetHas()
    {
        $session = new \Anax\Session\CSession();

        $ret = $session->has('key');
        $this->assertFalse($ret, "Session should not have this entry.");

        $ret = $session->get('key');
        $this->assertNull($ret, "Session should return null for this entry.");

        $ret = $session->set('key', 'value');
        $ret = $session->has('key');
        $this->assertTrue($ret, "Session should have this entry.");

        $ret = $session->get('key');
        $this->assertEquals($ret, 'value', "Session should have a value for this entry.");
    }
}

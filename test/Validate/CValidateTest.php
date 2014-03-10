<?php

namespace Anax\Validate;

/**
 * A helper to validate variables.
 *
 */
class CValidateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provider for test values
     *
     * @return array
     */
    public function providerCheck()
    {
        return [
            [ null, ['pass'] ],
            [ 0, ['int'] ],
            [ 1, ['range' => [1, 100]] ],
            [ 100, ['range' => [1, 100]] ],
      ];
    }



    /**
     * Test 
     *
     * @return void
     *
     * @dataProvider providerCheck
     *
     */
    public function testCheck($value, $rules) 
    {
        $validate = new \Anax\Validate\CValidate();

        $res = $validate->check($value, $rules);
        $this->assertTrue($res, "Should return the tested value.");
    }



    /**
     * Test 
     *
     * @dataProvider providerCheckFail
     *
     * @expectedException Exception
     *
     * @return void
     *
     */
    public function testValidationRuleMissing() 
    {
        $validate = new \Anax\Validate\CValidate();
        $validate->check(0, ['not_exists']);
    }



    /**
     * Provider for test values
     *
     * @return array
     */
    public function providerCheckFail()
    {
        return [
            [ null, ['fail'] ],
            [ "moped", ['int'] ],
            [ 0, ['range' => [1, 100]] ],
            [ 101, ['range' => [1, 100]] ],
        ];
    }



    /**
     * Test 
     *
     * @dataProvider providerCheckFail
     *
     * @expectedException Exception
     *
     * @return void
     *
     */
    public function testCheckFailException($value, $rules) 
    {
        $validate = new \Anax\Validate\CValidate();
        $validate->check($value, $rules, true);
    }



    /**
     * Test 
     *
     * @dataProvider providerCheckFail
     *
     * @return void
     *
     */
    public function testCheckFail($value, $rules) 
    {
        $validate = new \Anax\Validate\CValidate();
        $res = $validate->check($value, $rules);
        $this->assertFalse($res, "Should return the tested value.");
    }
}
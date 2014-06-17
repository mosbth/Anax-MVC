<?php

namespace Anax\Content;

/**
 * Tests.
 *
 */
class CTextFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test 
     *
     * @return void
     *
     *
     */
    public function testFilterNl2br()
    {
        $tf = new \Anax\Content\CTextFilter();

        $html = "hi\nhi";
        $expected = "hi<br />\nhi";
        $res = $tf->doFilter($html, 'nl2br');
        $this->assertEquals($expected, $res, "Filter nl2bt failed.");
    }
}

<?php

namespace Anax\Url;

/**
 * A helper to create urls.
 *
 */
class CUrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provider for various siteUrls
     *
     * @return array
     */
    public function providerSiteUrl()
    {
        return [
            [
                "http://dbwebb.se", 
                "http://dbwebb.se",
                "http://dbwebb.se",
            ],
            [
                "http://dbwebb.se/", 
                "http://dbwebb.se/",
                "http://dbwebb.se",
            ],
            [
                "//dbwebb.se", 
                "//dbwebb.se",
                "//dbwebb.se",
            ],
        ];
    }



    /**
     * Test 
     *
     * @param string $route the route part
     *
     * @return void
     *
     * @dataProvider providerSiteUrl
     *
     */
    public function testCreateAsSiteUrl($siteUrl, $route, $result) 
    {
        $url = new \Anax\Url\CUrl();

        $res = $url->setSiteUrl($siteUrl);
        $this->assertInstanceOf(get_class($url), $res, "setSiteUrl did not return this.");

        $res = $url->create($route);
        $this->assertEquals($result, $res, "Created url did not match expected.");
    }



    /**
     * Provider for routes
     *
     * @return array
     */
    public function providerRoute()
    {
        $siteUrl = "http://dbwebb.se";
        $baseUrl = $siteUrl;
        $scriptName = "index.php";
        $urlType = \Anax\Url\CUrl::URL_APPEND;

        return [
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "",
                "$baseUrl",
            ],
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "/",
                "$siteUrl",
            ],
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "controller",
                "$baseUrl/$scriptName/controller",
            ],
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "controller/action",
                "$baseUrl/$scriptName/controller/action",
            ],
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "controller/action/arg1",
                "$baseUrl/$scriptName/controller/action/arg1",
            ],
            [
                $siteUrl, 
                $baseUrl,
                $scriptName,
                $urlType,
                "controller/action/arg1/arg2",
                "$baseUrl/$scriptName/controller/action/arg1/arg2",
            ],
        ];
    }



    /**
     * Test 
     *
     * @param string $route the route part
     *
     * @return void
     *
     * @dataProvider providerRoute
     *
     */
    public function testCreateUrlAppend($siteUrl, $baseUrl, $scriptName, $urlType, $route, $result) 
    {
        $url = new \Anax\Url\CUrl();

        $res = $url->setSiteUrl($siteUrl);
        $this->assertInstanceOf(get_class($url), $res, "setSiteUrl did not return this.");

        $res = $url->setBaseUrl($baseUrl);
        $this->assertInstanceOf(get_class($url), $res, "setBaseUrl did not return this.");

        $res = $url->setScriptName($scriptName);
        $this->assertInstanceOf(get_class($url), $res, "setScriptName did not return this.");

        $res = $url->setUrlType($urlType);
        $this->assertInstanceOf(get_class($url), $res, "setUrlType did not return this.");

        $res = $url->create($route);
        $this->assertEquals($result, $res, "Created url did not match expected.");
    }
}
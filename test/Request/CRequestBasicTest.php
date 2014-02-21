<?php

namespace Anax\Request;

/**
 * Storing information from the request and calculating related essentials.
 *
 */
class CRequestBasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Properties
     */
    private $request;



    /**
     * Set up a request object
     *
     * @return void
     */
    public function setUp()
    {
        $this->request = new \Anax\Request\CRequestBasic();
        $this->request->setGlobals(
            [
                'REQUEST_SCHEME' => "http",
                'HTTPS'       => null, //"on",
                'SERVER_NAME' => "dbwebb.se",
                'SERVER_PORT' => "80",
                'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                'SCRIPT_NAME' => "/anax-mvc/webroot/app.php",
            ]
        );
    }



    /**
     * Provider for routes
     *
     * @return array
     */
    public function providerRoute()
    {
        return [
            [""],
            ["controller"],
            ["controller/action"],
            ["controller/action/arg1"],
            ["controller/action/arg1/arg2"],
            ["controller/action/arg1/arg2/arg3"],
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
    public function testGetRoute($route) 
    {
        $uri = $this->request->getServer('REQUEST_URI');
        $this->assertEmpty($uri, "REQUEST_URI is empty.");

        $this->request->setServer('REQUEST_URI', $uri . '/' . $route);
        $this->assertEquals($route, $this->request->extractRoute(), "Failed extractRoute: " . $route);

        $this->assertEquals($route, $this->request->getRoute(), "Failed getRoute: " . $route);
    }



    /**
     * Provider for $_SERVER
     *
     * @return array
     */
    public function providerGetCurrentUrl()
    {
        return [
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "80",
                    'REQUEST_URI' => "/",
                    'url'         => "http://dbwebb.se",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "80",
                    'REQUEST_URI' => "/img",
                    'url'         => "http://dbwebb.se/img",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "80",
                    'REQUEST_URI' => "/img/",
                    'url'         => "http://dbwebb.se/img",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "80",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'url'         => "http://dbwebb.se/anax-mvc/webroot/app.php",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "8080",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'url'         => "http://dbwebb.se:8080/anax-mvc/webroot/app.php",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => "on", //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "443",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'url'         => "https://dbwebb.se/anax-mvc/webroot/app.php",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => "on", //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "8080",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'url'         => "https://dbwebb.se:8080/anax-mvc/webroot/app.php",
                ]
            ],
        ];
    }



    /**
     * Test 
     *
     * @param string $server the $_SERVER part
     *
     * @return void
     *
     * @dataProvider providerGetCurrentUrl
     *
     */
    public function testGetCurrentUrl($server) 
    {
        $this->request->setServer('REQUEST_SCHEME', $server['REQUEST_SCHEME']);
        $this->request->setServer('HTTPS', $server['HTTPS']);
        $this->request->setServer('SERVER_NAME', $server['SERVER_NAME']);
        $this->request->setServer('SERVER_PORT', $server['SERVER_PORT']);
        $this->request->setServer('REQUEST_URI', $server['REQUEST_URI']);

        $url = $server['url'];

        $res = $this->request->getCurrentUrl();

        $this->assertEquals($url, $res, "Failed url: " . $url);
    }



    /**
     * Provider for $_SERVER
     *
     * @return array
     */
    public function providerInit()
    {
        return [
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "80",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'SCRIPT_NAME' => "/anax-mvc/webroot/app.php",
                    'siteUrl'     => "http://dbwebb.se",
                    'baseUrl'     => "http://dbwebb.se/anax-mvc/webroot",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => null, //"on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "8080",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'SCRIPT_NAME' => "/anax-mvc/webroot/app.php",
                    'siteUrl'     => "http://dbwebb.se:8080",
                    'baseUrl'     => "http://dbwebb.se:8080/anax-mvc/webroot",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => "on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "8080",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'SCRIPT_NAME' => "/anax-mvc/webroot/app.php",
                    'siteUrl'     => "https://dbwebb.se:8080",
                    'baseUrl'     => "https://dbwebb.se:8080/anax-mvc/webroot",
                ]
            ],
            [
                [
                    'REQUEST_SCHEME' => "http",
                    'HTTPS'       => "on",
                    'SERVER_NAME' => "dbwebb.se",
                    'SERVER_PORT' => "443",
                    'REQUEST_URI' => "/anax-mvc/webroot/app.php",
                    'SCRIPT_NAME' => "/anax-mvc/webroot/app.php",
                    'siteUrl'     => "https://dbwebb.se",
                    'baseUrl'     => "https://dbwebb.se/anax-mvc/webroot",
                ]
            ]            
        ];
    }



    /**
     * Test 
     *
     * @param string $server the route part
     *
     * @return void
     *
     * @dataProvider providerInit
     *
     */
    public function testInit($server) 
    {
        $this->request->setServer('REQUEST_SCHEME', $server['REQUEST_SCHEME']);
        $this->request->setServer('HTTPS', $server['HTTPS']);
        $this->request->setServer('SERVER_NAME', $server['SERVER_NAME']);
        $this->request->setServer('SERVER_PORT', $server['SERVER_PORT']);
        $this->request->setServer('REQUEST_URI', $server['REQUEST_URI']);
        $this->request->setServer('SCRIPT_NAME', $server['SCRIPT_NAME']);

        $siteUrl = $server['siteUrl'];
        $baseUrl = $server['baseUrl'];

        $res = $this->request->init();
        $this->assertInstanceOf(get_class($this->request), $res, "Init did not return this.");

        $this->assertEquals($siteUrl, $this->request->getSiteUrl(), "Failed siteurl: " . $siteUrl);
        $this->assertEquals($baseUrl, $this->request->getBaseUrl(), "Failed baseurl: " . $baseUrl);
    }
}


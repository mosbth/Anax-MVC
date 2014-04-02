<?php

namespace Anax\Request;

/**
 * Storing information from the request and calculating related essentials.
 *
 */
class CRequestBasic
{


    /**
    * Properties
    *
    */
    private $requestUri; // Request URI from $_SERVER
    private $scriptName; // Scriptname from $_SERVER, actual scriptname part
    private $path;       // Scriptname from $_SERVER, path-part

    private $route;      // The route
    private $routeParts; // The route as an array
 

    private $currentUrl; // Current url
    private $siteUrl;    // Url to this site, http://dbwebb.se
    private $baseUrl;    // Url to root dir, siteUrl . /some/installation/directory/

    private $server; // Mapped to $_SERVER
    private $get;    // Mapped to $_GET
    private $post;   // Mapped to $_POST



    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setGlobals();
    }



    /**
     * Read info from the globals.
     *
     * @return void
     */
    public function setGlobals() 
    {
        $this->server = $_SERVER;
        $this->get    = $_GET;
        $this->post   = $_POST;
    }



    /**
     * Init the request class by reading information from the request.
     *
     * @return $this
     */
    public function init() 
    {
        $this->requestUri = $this->getServer('REQUEST_URI');
        $scriptName = $this->getServer('SCRIPT_NAME');
        $this->path = rtrim(dirname($scriptName), '/');
        $this->scriptName = basename($scriptName);

        // The route and its parts
        $this->extractRoute();

        // Prepare to create siteUrl and baseUrl by using currentUrl
        $this->currentUrl = $this->getCurrentUrl();
        $parts = parse_url($this->currentUrl);
        $this->siteUrl = "{$parts['scheme']}://{$parts['host']}" . (isset($parts['port']) 
            ? ":{$parts['port']}" 
            : '');
        $this->baseUrl = $this->siteUrl . $this->path;

        return $this;
    }



    /**
     * Get site url.
     *
     * @return string
     */
    public function getSiteUrl() 
    {
        return $this->siteUrl;
    }



    /**
     * Get base url.
     *
     * @return string
     */
    public function getBaseUrl() 
    {
        return $this->baseUrl;
    }



    /**
     * Get script name.
     *
     * @return string
     */
    public function getScriptName() 
    {
        return $this->scriptName;
    }



    /**
     * Get route parts.
     *
     * @return array
     */
    public function getRouteParts() 
    {
        return $this->routeParts;
    }



    /**
     * Get the route.
     *
     * @return string as the current extracted route
     */
    public function getRoute() 
    {
        return $this->route;
    }



    /**
     * Extract the part containing the route.
     *
     * @return string as the current extracted route
     */
    public function extractRoute() 
    {
        $requestUri = $this->getServer('REQUEST_URI');
        $scriptName = $this->getServer('SCRIPT_NAME');
        $scriptPath = dirname($scriptName);
        $scriptFile = basename($scriptName);

        // Compare REQUEST_URI and SCRIPT_NAME as long they match, 
        // leave the rest as current request.
        $i = 0;
        $len = min(strlen($requestUri), strlen($scriptPath));
        while ($i < $len 
               && $requestUri[$i] == $scriptPath[$i]
        ) {
            $i++;
        }
        $route = trim(substr($requestUri, $i), '/');
     
        // Does the request start with script-name - remove it.
        $len1 = strlen($route);
        $len2 = strlen($scriptFile);

        if ($len2 <= $len1
            && substr_compare($scriptFile, $route, 0, $len2, true) === 0
        ) {
            $route = substr($route, $len2 + 1);
        }

        // Remove the ?-part from the query when analysing controller/metod/arg1/arg2
        $queryPos = strpos($route, '?');
        if ($queryPos !== false) {
            $route = substr($route, 0, $queryPos);
        }

        $this->route = $route;
        $this->routeParts = explode('/', trim($route, '/'));

        return $route;
    }



    /**
     * Get the current url.
     *
     * @return string as current url.
     */
    public function getCurrentUrl() 
    {
        $rs    = $this->getServer('REQUEST_SCHEME');
        $https = $this->getServer('HTTPS') == 'on' ? true : false;
        $sn    = $this->getServer('SERVER_NAME'); 
        $ru    = rtrim($this->getServer('REQUEST_URI'), '/'); 
        $port  = $this->getServer('SERVER_PORT'); 

        $port  = ($port == '80') 
            ? '' 
            : (($port == 443 && $https) 
                ? '' 
                : ':' . $port);

        $url  = $rs ? $rs : 'http';
        $url .= $https ? 's' : '';
        $url .= '://';
        $url .= $sn . $port . htmlspecialchars($ru);

        return $url;
    }



    /**
     * Get a value from the _SERVER array and use default if it is not set.
     *
     * @param string $key     to check if it exists in the $_SERVER variable
     * @param string $default value to return as default
     *
     * @return mixed
     */
    public function getServer($key, $default = null) 
    {
        return isset($this->server[$key]) ? $this->server[$key] : $default;
    }



    /**
     * Set variable in the server array.
     *
     * @param mixed  $key   the key an the , or an key-value array
     * @param string $value the value of the key
     *
     * @return $this
     */
    public function setServer($key, $value = null) 
    {
        if (is_array($key)) {
            $this->server = array_merge($this->server, $key);
        } else {
            $this->server[$key] = $value;
        }
    }



    /**
     * Get a value from the _GET array and use default if it is not set.
     *
     * @param string $key     to check if it exists in the $_GET variable
     * @param string $default value to return as default
     *
     * @return mixed
     */
    public function getGet($key, $default = null) 
    {
        return isset($this->get[$key]) ? $this->get[$key] : $default;
    }



    /**
     * Get a value from the _POST array and use default if it is not set.
     *
     * @param string $key     to check if it exists in the $_POST variable
     * @param string $default value to return as default
     *
     * @return mixed
     */
    public function getPost($key = null, $default = null) 
    {
        if ($key) {
            return isset($this->post[$key]) ? $this->post[$key] : $default;
        } else {
            return $this->post;
        }
    }

}
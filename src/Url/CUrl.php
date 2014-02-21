<?php

namespace Anax\Url;

/**
 * A helper to create urls.
 *
 */
class CUrl
{

    /**
     * Properties
     *
     */
    const URL_CLEAN  = 'clean';  // controller/action/param1/param2
    const URL_APPEND = 'append'; // index.php/controller/action/param1/param2

    private $UrlType = self::URL_APPEND; // What type of urls to generate

    private $siteUrl = ''; // Siteurl to prepend to all absolute urls created

    private $baseUrl = ''; // Baseurl to prepend to all relative urls created

    private $scriptName = ''; // Name of the frontcontroller script



    /**
     * Create an url and prepending the baseUrl.
     *
     * @param string $uri part of uri to use when creating an url.
     *
     * @return string as resulting url.
     */
    public function create($uri)
    {
        if(empty($uri)) {
            
            // Empty url means baseurl
            return $this->baseUrl;

        } elseif (substr($uri, 0, 7) == "http://" || substr($uri, 0, 2) == "//") {
            
            // Fully qualified, just leave as is.
            return rtrim($uri, '/');

        } elseif ($uri[0] == '/') {

            // Absolute urls, prepend with siteUrl
            return rtrim($this->siteUrl . '/' . rtrim($uri, '/'), '/');

        }

        $uri = rtrim($uri, '/');
        if ($this->urlType == self::URL_APPEND) {
            return $this->baseUrl . '/' . $this->scriptName . '/' . $uri; 
        }

        return $this->baseUrl . '/' . $uri; 
    }



    /**
     * Set the siteUrl to prepend all absolute urls created.
     *
     * @param string $url part of url to use when creating an url.
     *
     * @return $this
     */
    public function setSiteUrl($url)
    {
        $this->siteUrl = rtrim($url, '/');
        return $this;
    }



    /**
     * Set the baseUrl to prepend all relative urls created.
     *
     * @param string $url part of url to use when creating an url.
     *
     * @return $this
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = rtrim($url, '/');
        return $this;
    }



    /**
     * Set the scriptname to use when creating URL_APPEND urls.
     *
     * @param string $name as the scriptname, for example index.php.
     *
     * @return $this
     */
    public function setScriptName($name)
    {
        $this->scriptName = $name;
        return $this;
    }



    /**
     * Set the type of urls to be generated, URL_CLEAN, URL_APPEND.
     *
     * @param string $type what type of urls to create.
     *
     * @return $this
     */
    public function setUrlType($type)
    {
        if (!in_array($type, [self::URL_APPEND, self::URL_CLEAN])) {
            throw new \Exception("Unsupported Url type.");
        }

        $this->urlType = $type;
        return $this;
    }
}
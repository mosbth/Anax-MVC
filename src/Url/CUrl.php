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

    private $baseUri = ''; // Base uri to prepend to all urls created



    /**
     * Create a url by prepending the baseUri.
     *
     * @param string $uri part of uri to use when creating an url.
     *
     * @return string as resulting url.
     */
    public function create($uri)
    {
        return $this->baseUri . $uri;
    }



    /**
     * Set the baseUri to prepend all urls created.
     *
     * @param string $uri part of uri to use when creating an url.
     *
     * @return $this
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;
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
        $this->urlType = $type;
        return $this;
    }
}
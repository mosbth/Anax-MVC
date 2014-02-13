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
    private $baseUri = ''; // Base uri to prepend to all urls created



    /**
     * Create a url by prepending the baseUri.
     *
     * @param string $uri part of uri to use when creating an url.
     *
     * @return string as resulting url.
     */
    public function get($uri)
    {
        return $this->baseUri . $uri;
    }
}
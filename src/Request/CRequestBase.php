<?php
namespace Anax\Request;

/**
 * Storing information on the request.
 *
 */
class CRequestBase 
{

    /**
    * Properties
    *
    */



    /**
     * Get a value from the _GET array and use default if it is not set.
     *
     * @param string $key to check if it exists in the $_GET variable
     * @param string $default value to return as default
     * @return mixed
     */
    public function get($key, $default = null) 
    {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
}
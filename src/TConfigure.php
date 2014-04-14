<?php

namespace Anax;

/**
 * Trait implementing reading from config-file and storing options in $this->config.
 *
 */
trait TConfigure
{

    /**
     * Properties
     *
     */
    private $config = [];  // Store all config as an array



    /**
     * Read configuration from file or array'.
     *
     * @param array/string $what is an array with key/value config options or a file
     *      to be included which returns such an array.
     * @return $this for chaining.
     */
    public function configure($what)
    {
        if (is_array($what)) {
            $options = $what;
        }
        elseif (is_readable($what)) {
            $options = include $what;
        }
        else {
            throw new Exception("Configure item '" . htmlentities($what) 
                . "' is not an array nor a readable file.");
        }

        $this->config = array_merge($this->config, $options);
        return $this->config;
    }
}

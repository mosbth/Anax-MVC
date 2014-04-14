<?php
/**
 * Trait implementing singleton design pattern.
 */

namespace Anax;

trait TSingleton
{
    /**
     * Properties
     *
     */
    static private $instance = null;



    /**
     * Create or get singleton instance of class.
     *
     */
    static public function instance()
    {
        return isset(static::$instance) 
            ? self::$instance
            : self::$instance = new static; 
    }
}

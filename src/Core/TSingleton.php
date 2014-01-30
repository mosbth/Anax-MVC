<?php
/**
 * Inteface for classes implementing singleton design pattern.
 */

namespace Anax\Core;

trait TSingleton
{
    /**
     * Properties
     *
     */
    static private $instance;



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

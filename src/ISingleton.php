<?php
/**
 * Inteface for classes implementing singleton design pattern.
 */

namespace Anax;

interface ISingleton
{
    /**
     * Return or create an instance of the class.
     */
    public function instance();
}

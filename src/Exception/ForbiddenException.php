<?php

namespace Anax\Exception;

/**
 * Anax base class for wrapping sessions.
 *
 */
class ForbiddenException extends \Anax\Exception
{
    /**
     * Construct.
     *
     * @param string $message the Exception message to throw.
     * @param Exception previous the previous exception used for the exception chaining.
     */
    public function __construct($message = "", $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}

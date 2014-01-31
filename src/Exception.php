<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax;

class Exception
{
    /**
     * Construct.
     *
     * @param message string The Exception message to throw.
     * @param code int The Exception code.
     * @param previous Exception The previous exception used for the exception chaining.
     */
    private function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $prevoious);
    }
}

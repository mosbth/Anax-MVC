<?php
/**
 * Bootstrapping functions, essential and needed for Anax to work together with some common helpers. 
 *
 */

/**
 * Default exception handler.
 *
 */
set_exception_handler(function ($exception) {
    echo "Anax: Uncaught exception: <p>" . 
        $exception->getMessage() . "</p><pre>" . 
        $exception->getTraceAsString() . "</pre>";
});



/**
 * Utility for debugging.
 *
 */
function dump($array) {
    echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

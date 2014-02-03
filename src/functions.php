<?php
/**
 * Bootstrapping functions, essential and needed for Anax to work together with some common helpers. 
 *
 */



/**
 * Utility for debugging.
 *
 */
function dump($array) {
    echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

<?php
/**
 * Config-file for sessions. 
 */

return [

    // Session name
    'name' => preg_replace('/[^a-z\d]/i', '', __DIR__),
    
];

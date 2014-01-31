<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax\Core;

class CSession 
{

    /**
     * Construct and start session.
     *
     * @param array $options to configure options.
     */
    public function __construct($options = [])
    {
        $default = [
            'name' => preg_replace('/[^a-z\d]/i', '', ANAX_APP_PATH), 
        ]
        $options = array_merge($default, $options);
        
        session_name($options['name']);
        session_start();
    }

}

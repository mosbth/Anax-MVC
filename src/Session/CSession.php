<?php

namespace Anax\Session;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CSession
{
    use \Anax\TConfigure;



    /**
     * Construct session.
     *
     * @param array $options to configure options.
     */
    public function __construct($options = [])
    {
        ;
    }



    /**
     * Set a session name or use one from config.
     *
     * @param array $aName to set as session name, default is null and then use name from config.
     */
    public function name($aName = null)
    {
        $name = isset($aName)
            ? $aName
            : (isset($this->config['name'])
                ? $this->config['name']
                : "anax");

        session_name($name);
    }


    /**
     * Start session.
     *
     * @param array $options to configure options.
     */
    public function start($options = [])
    {
        session_start();
    }



    /**
     * Get values from session.
     *
     * @param string $key     in session variable.
     * @param mixed  $default default value to return when key is not set in session.
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($_SESSION) && isset($_SESSION[$key])
            ? $_SESSION[$key]
            : $default;
    }



    /**
     * Set values in session.
     *
     * @param string $key   in session variable.
     * @param mixed  $value to set in session.
     *
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }



    /**
     * Check if a value is set in the session.
     *
     * @param string $key   in session variable.
     *
     * @return boolean true if $key is set, else false.
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }
}

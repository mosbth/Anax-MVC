<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax\Kernel;

class CAnax
{

    /**
     * Properties
     *
     */
    protected $di = null;  // Dependency injection of service container
 


    /**
     * Construct.
     *
     * @param array $di dependency injection of service container.
     */
    public function __construct($di)
    {
        $this->di = $di;
    }



    /**
     * Magic method to get and create services using service locator. 
     * When created it is also stored as a parameter of this object.
     *
     * @param string $service name of class property not existing.
     */
    public function __get($service)
    {
        $this->$service = $this->di->get($service);
        return $this->$service;
    }



    /**
     * Configure from applications config-files.
     *
     * @param array $options to change presets.
     */
    /*public function config($options = [])
    {
        $default = [
            'error_reporting' => 'config/error_reporting.php', 
            'theme' => 'config/theme.php', 
        ];
        $options = array_merge($default, $options);
        
        $appPath = ANAX_APP_PATH;
        if (!is_dir($appPath)) {
            throw new Exception("Application directory does not exists.");
        }

        foreach ($options as $key => $val) {
            $file = $appPath . $val;
            if (!is_readable($file)) {
                throw new Exception("Application config file is not readable.");
            }

            // Config file miht return an array to be stored as part of $this->config
            $ret = include $file;
            if(is_array($ret)) {
                $this->config[$key] = $ret;    
            }
        }
    }*/



    /**
     * Bootstrap the system.
     *
     * @param array $options to change presets.
     */
    /*public function bootstrap($options = [])
    {
        $default = [
            'file'   => ANAX_SOURCE_PATH . 'bootstrap.php', 
        ];
        $options = array_merge($default, $options);
        
        if (!is_readable($options['file'])) {
            throw new Exception("Bootstrap-file is not readable.");
        }

        include $options['file'];
    }*/



    /**
     * Render the response using the theme engine.
     *
     * @param array $options to change presets.
     */
    /*public function render($options = [])
    {
        $default = [
            'data' => [], 
        ];
        $options = array_merge($default, $options);

        include ANAX_THEME_PATH . "render.php";
    }*/


}

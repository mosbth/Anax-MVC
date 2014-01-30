<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax\Core;

class CAnax implements ISingleton
{
    use TSingleton;



    /**
     * Properties
     *
     */
    public $config = [];        // Store all configuration options here



    /**
     * Construct.
     *
     * @param array $options to configure options.
     */
    private function __construct($options = [])
    {
        ;
    }



    /**
     * Configure from applications config-files.
     *
     * @param array $options to change presets.
     */
    public function config($options = [])
    {
        $default = [
            'error_reporting' => 'config/error_reporting.php', 
            'theme' => 'config/theme.php', 
        ];
        $options = array_merge($default, $options);
        
        $appPath = ANAX_APP_PATH;
        if (!is_dir($appPath)) {
            throw new \Exception("Application directory does not exists.");
        }

        foreach ($options as $key => $val) {
            $file = $appPath . $val;
            if (!is_readable($file)) {
                throw new \Exception("Application config file is not readable.");
            }

            // Config file miht return an array to be stored as part of $this->config
            $ret = include $file;
            if(is_array($ret)) {
                $this->config[$key] = $ret;    
            }
        }
    }



    /**
     * Bootstrap the system.
     *
     * @param array $options to change presets.
     */
    public function bootstrap($options = [])
    {
        $default = [
            'file'   => ANAX_SOURCE_PATH . 'bootstrap.php', 
        ];
        $options = array_merge($default, $options);
        
        if (!is_readable($options['file'])) {
            throw new \Exception("Bootstrap-file is not readable.");
        }

        include $options['file'];
    }



    /**
     * Render the response using the theme engine.
     *
     * @param array $options to change presets.
     */
    public function render($options = [])
    {
        $default = [
            'data' => [], 
        ];
        $options = array_merge($default, $options);

        include ANAX_THEME_PATH . "render.php";
    }
}

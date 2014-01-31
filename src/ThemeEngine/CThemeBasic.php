<?php
/**
 * Anax base class for wrapping sessions.
 */

namespace Anax\ThemeEngine;

class CThemeBasic implements IThemeEngine
{
    use \Anax\TConfigure;


    /**
     * Properties
     *
     */
    protected $data = []; // Array with variables to provide to template files.



    /**
     * Construct.
     *
     */
    public function __construct()
    {
        ;
    }



    /**
     * Set a variable which will be exposed to the template files during render.
     *
     * @param string $which variable to set value of.
     * @param mixed $value of the variable.
     * @return nothing
     */
    public function setVariable($which, $value)
    {
        $this->data[$which] = $value;
    }



    /**
     * Get a value of a variable which will be exposed to the template files 
     * during render.
     *
     * @param string $which variable to get value of.
     * @return mixed as value of variable, or null if value is not set.
     */
    public function getVariable($which)
    {
        if (isset($this->data[$which])) {
            return $this->data[$which];
        }
        elseif (isset($this->config['data'])) {
            return $this->config['data'][$which];
        }

        return null;
    }



    /**
     * Render the theme by applying the variables onto the template files.
     *
     */
    public function render()
    {
        // Extract data variables
        extract($this->config['data']);
        extract($this->data);
        
        // Prepare details
        $path       = $this->config['settings']['path'];
        $name       = $this->config['settings']['name'] . '/';
        $template   = 'index.tpl.php';
        $functions  = 'functions.php';

        // Include global theme functions file
        $file = $path . $functions;
        if(is_readable($file)) {
            include $file;
        }

        // Include theme specific functions file
        $file = $path . $name . $functions;
        if(is_readable($file)) {
            include $file;
        }

        // Include template file
        $file = $path . $name . $template;
        if(is_readable($file)) {
            include $file;
        }
    }
}
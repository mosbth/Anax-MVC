<?php

namespace Anax\ThemeEngine;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CThemeBasic implements IThemeEngine, \Anax\DI\IInjectionAware
{
    use \Anax\TConfigure,
        \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    protected $data = []; // Array with variables to provide to template files.



    /**
     * Shortcut to set title.
     *
     * @param string $value of the variable.
     *
     * @return $this
     */
    public function setTitle($value)
    {
        return $this->setVariable('title', $value);
    }



    /**
     * Set a variable which will be exposed to the template files during render.
     *
     * @param string $which variable to set value of.
     * @param mixed  $value of the variable.
     *
     * @return $this
     */
    public function setVariable($which, $value)
    {
        $this->data[$which] = $value;
        return $this;
    }



    /**
     * Get a value of a variable which will be exposed to the template files 
     * during render.
     *
     * @param string $which variable to get value of.
     *
     * @return mixed as value of variable, or null if value is not set.
     */
    public function getVariable($which)
    {
        if (isset($this->data[$which])) {
            return $this->data[$which];
        } elseif (isset($this->config['data'])) {
            return $this->config['data'][$which];
        }

        return null;
    }



    /**
     * Add a stylesheet.
     *
     * @param string $uri to add.
     *
     * @return $this
     */
    public function addStylesheet($uri)
    {
        $this->config['data']['stylesheets'][] = $uri;
        return $this;
    }



    /**
     * Add a javascript asset.
     *
     * @param string $uri to add.
     *
     * @return $this
     */
    public function addJavaScript($uri)
    {
        $this->config['data']['javascript_include'][] = $uri;
        return $this;
    }



    /**
     * Render the theme by applying the variables onto the template files.
     * 
     * @return void
     */
    public function render()
    {
        // Prepare details
        $path       = $this->config['settings']['path'];
        $name       = $this->config['settings']['name'] . '/';
        $template   = 'index.tpl.php';
        $functions  = 'functions.php';

        // Include theme specific functions file
        $file = $path . $name . $functions;
        if (is_readable($file)) {
            include $file;
        }

        // Create views for regions, from config-file
        if (isset($this->config['views'])) {
            foreach ($this->config['views'] as $view) {
                $this->di->views->add($view['template'], $view['data'], $view['region'], $view['sort']);
            }
        }

        // Sen response headers, if any.
        $this->di->response->sendHeaders();

        // Create a view to execute the default template file
        $tpl  = $path . $name . $template;
        $data = array_merge($this->config['data'], $this->data);
        $view = $this->di->get('view');
        $view->set($tpl, $data);
        $view->setDI($this->di);
        $view->render();
    }
}
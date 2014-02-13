<?php

namespace Anax\View;

/**
 * A view connected to a template file.
 *
 */
class CViewBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
    * Properties
    *
    */
    private $template;  // Template file
    private $data = []; // Data to send to template file



    /**
     * Add a view to be included as a template file.
     *
     * @param string $template the actual template file
     * @param array  $data     variables to make available to the view, default is empty
     *
     * @return $this
     */
    public function __construct($template, $data = []) 
    {
        if (!is_readable($template)) {
            throw new \Exception("Could not find template file: " . $template);
        }

        $this->template = $template;
        $this->data     = $data;
    }



    /**
     * Render the view.
     *
     * @return void
     */
    public function render() 
    {
        extract($this->data);
        $di = $this->di; // Allow $di to be used in views
        include $this->template;
    }
}
<?php

namespace Anax\View;

/**
 * A view connected to a template file.
 *
 */
class CViewBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
    * Properties
    *
    */
    private $templateFile;          // Template file
    private $templateFileData = []; // Data to send to template file



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

        $this->templateFile     = $template;
        $this->templateFileData = $data;
    }



    /**
     * Render the view.
     *
     * @return void
     */
    public function render() 
    {   
        extract($this->templateFileData);
        include $this->templateFile;
    }
}
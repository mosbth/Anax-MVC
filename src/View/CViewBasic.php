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
    private $sortOrder;             // For sorting views



    /**
     * Set values for the view.
     *
     * @param string $template the actual template file
     * @param array  $data     variables to make available to the view, default is empty
     * @param int    $sort     which order to display the views, if suitable
     *
     * @return $this
     */
    public function set($template, $data = [], $sort = 0) 
    {
        if (!is_readable($template)) {
            throw new \Exception("Could not find template file: " . $template);
        }

        $this->templateFile     = $template;
        $this->templateFileData = $data;
        $this->sortOrder        = $sort;
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



    /**
     * Give the sort order for this view.
     *
     * @return int
     */
    public function sortOrder() 
    {   
        return $this->sortOrder;
    }
}
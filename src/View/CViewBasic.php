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
    private $template;          // Template file or array 
    private $templateData = []; // Data to send to template file
    private $sortOrder;         // For sorting views
    private $type;              // Type of view



    /**
     * Set values for the view.
     *
     * @param string/array $template the template file, or array 
     * @param array        $data     variables to make available to the view, default is empty
     * @param int          $sort     which order to display the views, if suitable
     * @param string       $type     which type of view
     *
     * @return $this
     */
    public function set($template, $data = [], $sort = 0, $type = 'file') 
    {
        $this->template     = $template;
        $this->templateData = $data;
        $this->sortOrder    = $sort;
        $this->type         = $type;
    }



    /**
     * Render the view.
     *
     * @return void
     */
    public function render() 
    {
        switch ($this->type) {

            case 'file':

                if (!is_readable($this->template)) {
                    throw new \Exception("Could not find template file: " . $this->template);
                }

                extract($this->templateData);
                include $this->template;

                break;

            case 'callback':
    
                if (!isset($this->template['callback']) || !is_callable($this->template['callback'])) {
                    throw new \Exception("View missing callback.");
                }

                echo call_user_func($this->template['callback']);

                break;

            case 'string':

                echo $this->template;

                break;

            default:
                throw new \Exception("Not a valid template type: " . $this->type);
        }
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
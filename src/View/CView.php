<?php
namespace Anax\View;

/**
 * A view container, store all views per region, render at will.
 *
 */
class CView 
{

    /**
    * Properties
    *
    */
    private $suffix;    // Template file suffix



    /**
     * Add a view to be included as a template file.
     *
     * @param string $region where should the theme include this
     * @param string $template the name of the template file to include
     * @param array $data variables to make available to the view
     * @return $this
     */
    public function add($region, $template, $data) 
    {
        ;
    }



    /**
     * Set the suffix of the template files to include.
     *
     * @param string $suffix
     * @return $this
     */
    public function setFileSuffix($suffix) 
    {
        $this->suffix = $suffix;
    }
}
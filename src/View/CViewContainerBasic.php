<?php

namespace Anax\View;

/**
 * A view container, store all views per region, render at will.
 *
 */
class CViewContainerBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    private $views = []; // Array for all views
    private $suffix;     // Template file suffix
    private $path;       // Base path for views



    /**
     * Add a view to be included as a template file.
     *
     * @param string $template the name of the template file to include
     * @param array  $data     variables to make available to the view, default is empty
     * @param string $region   which region to attach the view
     * @param int    $sort     which order to display the views
     *
     * @return $this
     */
    public function add($template, $data = [], $region = 'main', $sort = 0) 
    {
        $view = $this->di->get('view');

        if (is_string($template)) {
            $tpl = $this->path . $template . $this->suffix;
            $type = 'file';
        } elseif (is_array($template)) {
            $tpl = $template;
            $type = 'callback';
        }

        $view->set($tpl, $data, $sort, $type);
        $view->setDI($this->di);
        $this->views[$region][] = $view;

        return $this;
    }



    /**
     * Add a string as a view.
     *
     * @param string $content the content
     * @param string $region  which region to attach the view
     * @param int    $sort    which order to display the views
     *
     * @return $this
     */
    public function addString($content, $region = 'main', $sort = 0) 
    {
        $view = $this->di->get('view');
        $view->set($content, [], $sort, 'string');
        $view->setDI($this->di);
        $this->views[$region][] = $view;
        
        return $this;
    }



    /**
     * Set the suffix of the template files to include.
     *
     * @param string $suffix file suffix of template files, append to filenames for template files
     *
     * @return $this
     */
    public function setFileSuffix($suffix) 
    {
        $this->suffix = $suffix;
    }



    /**
     * Set base path where  to find views.
     *
     * @param string $path where all views reside
     *
     * @return $this
     */
    public function setBasePath($path) 
    {
        if (!is_dir($path)) {
            throw new \Exception("Base path for views is not a directory: " . $path);
        }
        $this->path = rtrim($path, '/') . '/';
    }



    /**
     * Check if a region has views to render.
     *
     * @param string $region which region to check
     *
     * @return $this
     */
    public function hasContent($region) 
    {
        return isset($this->views[$region]);
    }



    /**
     * Render all views for a specific region.
     *
     * @param string $region which region to use
     *
     * @return $this
     */
    public function render($region = 'main') 
    {
        if (!isset($this->views[$region])) {
            return $this;
        }

        mergesort($this->views[$region], function($a, $b) {
            $sa = $a->sortOrder();
            $sb = $b->sortOrder();

            if ($sa == $sb) {
                return 0;
            }

            return $sa < $sb ? -1 : 1;
        });

        foreach ($this->views[$region] as $view) {
            $view->render();
        }

        return $this;
    }
}
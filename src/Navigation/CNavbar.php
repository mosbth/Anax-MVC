<?php

namespace Anax\Navigation;

/**
 * Helper to create a navbar for sites by reading its configuration from file
 * and then applying some code while rendering the resultning navbar.
 *
 */
class CNavbar
{
    use \Anax\TConfigure,
        \Anax\DI\TInjectionAware;



    /**
     * Create a navigation bar / menu, with submenu.
     * 
     * @return string with html for the menu.
     *
     * @link http://dbwebb.se/coachen/skapa-en-dynamisk-navbar-meny-med-undermeny-via-php
     */
    public function create()
    {
        // Keep default options in an array and merge with incoming options that can override the defaults.
        $default = array(
          'id'      => null,
          'class'   => null,
          'wrapper' => 'nav',
          'create_url' => function($url) {
            return $url;
          },
        );
        $menu = array_replace_recursive($default, $this->config);

        // Function to create urls
        $createUrl = $menu['create_url'];

        // Create the ul li menu from the array, use an anonomous recursive function that returns an array of values.
        $createMenu = function($items, $callback) use (&$createMenu, $createUrl) 
        {
          $html = null;
          $hasItemIsSelected = false;

          foreach ($items as $item) {

            // has submenu, call recursivly and keep track on if the submenu has a selected item in it.
            $submenu        = null;
            $selectedParent = null;
            if (isset($item['submenu'])) {
              list($submenu, $selectedParent) = $createMenu($item['submenu']['items'], $callback);
              $selectedParent = $selectedParent ? " selected-parent" : null;
            }

            // Check if the current menuitem is selected
            $selected = $callback($item['url']) ? 'selected' : null;
            if ($selected) {
              $hasItemIsSelected = true;
            }

            $selected = ($selected || $selectedParent) ? " class='${selected}{$selectedParent}' " : null;      
            $url = $createUrl($item['url']);
            $html .= "\n<li{$selected}><a href='{$url}' title='{$item['title']}'>{$item['text']}</a>{$submenu}</li>\n";
          }

          return array("\n<ul>$html</ul>\n", $hasItemIsSelected);
        };

        // Call the anonomous function to create the menu, and submenues if any.
        list($html, $ignore) = $createMenu($menu['items'], $menu['callback']);


        // Set the id & class element, only if it exists in the menu-array
        $id      = isset($menu['id'])    ? " id='{$menu['id']}'"       : null;
        $class   = isset($menu['class']) ? " class='{$menu['class']}'" : null;
        $wrapper = $menu['wrapper'];

        return "\n<{$wrapper}{$id}{$class}>{$html}</{$wrapper}>\n";
    }
}

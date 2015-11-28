<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'collapse navbar-collapse',
    'id' => 'bs-example-navbar-collapse-1',
    
 
    // Here comes the menu strcture
    'items' => [
        
//        'class' => 'nav navbar-nav',

        // This is a menu item
        'Startsida'  => [
            'text'  => 'Startsida',
            'url'   => $this->di->get('url')->create('index'),
            'title' => '',
        ],
 
        // This is a menu item
        'Frågor'  => [
            'text'  => 'Frågor',
            'url'   => $this->di->get('url')->create('questions/list/timestamp'),
            'title' => 'Frågor',

        ],
 

         // This is a menu item
        'tags' => [
            'text'  =>'Taggar',
            'url'   => $this->di->get('url')->create('tags/list'),
            'title' => 'Alla taggar',
        ],
        
        // This is a menu item
        'users' => [
            'text'  =>'Alla användare',
            'url'   => $this->di->get('url')->create('users/all'),
            'title' => 'Alla användare',
        ],
        
        
        // This is a menu item
        'askquestions' => [
            'text'  =>'Ställ en fråga',
            'url'   => $this->di->get('url')->create('questions/add'),
            'title' => 'Ställ en fråga',
        ],
        
        // This is a menu item
        'login' => [
            'text'  =>'Logga in/Logga ut',
            'url'   => $this->di->get('url')->create('users/login'),
            'title' => 'Logga in',
        ],
        
        // This is a menu item
        'profil' => [
            'text'  =>'Din sida',
            'url'   => $this->di->get('url')->create('users/profile'),
            'title' => 'Min sidaLogga in',
        ],
        
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];


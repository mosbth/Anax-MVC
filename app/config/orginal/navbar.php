<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',   
            'url'   => 'index.php',  
            'title' => 'Some title 1'
        ],
 
        // This is a menu item
        'test'  => [
            'text'  => 'Test with submenu',   
            'url'   => 'test.php',   
            'title' => 'Some title 2',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => 'Item 1',   
                        'url'   => 'item1.php',  
                        'title' => 'Some item 1'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => 'Item 2',   
                        'url'   => 'item2.php',  
                        'title' => 'Some item 2'
                    ],
                ],
            ],
        ],
 
        // This is a menu item
        'about' => [
            'text'  =>'About', 
            'url'   =>'about.php',  
            'title' => 'Some title 3'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];

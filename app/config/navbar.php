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
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home route of current frontcontroller'
        ],
 
        // This is a menu item
        'test'  => [
            'text'  => 'Submenu',
            'url'   => $this->di->get('url')->create('submenu'),
            'title' => 'Submenu with url as internal route within this frontcontroller',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 0'  => [
                        'text'  => 'Item 0',
                        'url'   => $this->di->get('url')->create('submenu/item-0'),
                        'title' => 'Url as internal route within this frontcontroller'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => '/humans.txt',
                        'url'   => $this->di->get('url')->asset('/humans.txt'),
                        'title' => 'Url to sitespecific asset',
                        'class' => 'italic'
                    ],

                    // This is a menu item of the submenu
                    'item 3'  => [
                        'text'  => 'humans.txt',
                        'url'   => $this->di->get('url')->asset('humans.txt'),
                        'title' => 'Url to asset relative to frontcontroller',
                    ],
                ],
            ],
        ],
 
        // This is a menu item
        /*
        'relative' => [
            'text'  =>'Relative',
            'url'   => $this->di->get('url')->createRelative('navigation-bar.php'),
            'title' => 'Url to relative frontcontroller, other file'
        ],
        */

        // This is a menu item
        'about' => [
            'text'  =>'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Internal route within this frontcontroller'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($this->di->get('request')->getCurrentUrl($url) == $this->di->get('url')->create($url)) {
                return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];

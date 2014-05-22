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
            'text' => 'Hem',
            'url'   => '',
            'title' => '',
        ],
        'questions' => [
            'text' => 'Frågor',
            'url' => 'questions',
            'title' => 'Visa frågor',
        ],
        'tags' => [
            'text' => 'Taggar',
            'url' => 'questions/tags',
            'title' => '',
        ],
        'about' => [
            'text'  =>'Om', 
            'url'   =>'about',  
            'title' => 'Denna sidan',
        ]
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

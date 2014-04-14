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
        'home' => [
            'text' => 'Hem',
            'url' => '',
            'title' => "Hem"
        ],
        'redovisning'  => [
            'text'  => 'Redovisning',   
            'url'   => 'redovisning',   
            'title' => 'Redovisning',
        ],
        'source' => [
            'text'  =>'Source', 
            'url'   =>'source',  
            'title' => 'Source'
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
    'views' => [
 
    // View for header
 
    // View for footer
 
    [
        'region' => 'navbar', 
        'template' => [
            'callback' => function() {
                return $this->di->navbar->create();
            },
        ], 
        'data' => [], 
        'sort' => -1
    ],
],
];

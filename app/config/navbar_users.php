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
        'back' => [
            'text' => '<i class="fa fa-home"></i> Hem',
            'url' => 'index.php',
            'title' => "Back"
        ],
        'add' => [
            'text' => '<i class="fa fa-plus"></i> Lägg till',
            'url' => 'users/add',
            'title' => ''
        ],
        'delete' => [
            'text' => '<i class="fa fa-minus"></i> Uppdatera',
            'url' => 'users/update',
            'title' => '',
        ],

        'list' => [
            'text' => '<i class="fa fa-users"></i> Visa alla',
            'url' => 'users/list',
            'title' => ''
        ],
        'visa' => [
            'text' => '<i class="fa fa-user"></i> Visa',
            'url' => 'users/id',
            'title' => '',
        ],
        'papperskorg' => [
            'text' => '<i class="fa fa-trash-o"></i> Papperskorg',
            'url' => 'users/inactive',
            'title' => '',
        ],
        'active' => [
            'text' => '<i class="fa fa-power-off"></i> Aktiva',
            'url' => 'users/active',
            'title' => '',
        ],
        'setup' => [
            'text' => '<i class="fa fa-cogs"></i> Setup',
            'url' => 'users/setup',
            'title' => ''
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

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
        'questions' => [
            'text'  =>'Frågor',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Frågor',
        ],

        // This is a menu item
        'tags' => [
            'text'  =>'Kategorier',
            'url'   => $this->di->get('url')->create('tags/list'),
            'title' => 'Kategorier',
        ],

        // This is a menu item
        'users' => [
            'text'  =>'Användare',
            'url'   => $this->di->get('url')->create('users/list'),
            'title' => 'Användare',
        ],

        // This is a menu item
        'ask' => [
            'text'  => 'Fråga',
            'url'   => $this->di->get('url')->create('questions/ask'),
            'title' => 'Fråga en fråga',
        ],
        'loginout' => [
            // 'text'  => $this->di->get('users')->loggedIn() ? 'true text' : 'false text',
            'text'  => 'Login',
            'url'   => $this->di->get('url')->create('users/login'),
            'title' => 'Logga in eller ut',
        ],


        // This is a menu item
        // TODO: Make visible for admin logged in.
        'admin' => [
            'text'  =>'Admin',
            'url'   => $this->di->get('url')->create('admin'),
            'title' => 'Admin',
            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [
                'items' => [

                    // This is a menu item of the submenu
                    'adminquestions'  => [
                        'text'  => 'Frågor',
                        'url'   => $this->di->get('url')->create('adminquestions'),
                        'title' => 'Frågor'
                    ],
                    // This is a menu item of the submenu
                    'admincontacts'  => [
                        'text'  => 'Meddelanden',
                        'url'   => $this->di->get('url')->create('admincontacts'),
                        'title' => 'Meddelanden'
                    ],
                    // This is a menu item of the submenu
                    'useradmin'  => [
                        'text'  => 'Användare',
                        'url'   => $this->di->get('url')->create('users'),
                        'title' => 'Användare'
                    ],
                    'commentadmin' => [
                        'text'  =>'Kommentarer',
                        'url'   => $this->di->get('url')->create('commentadmin'),
                        'title' => 'Comment administration page',
                        // Here we add the submenu, with some menu items, as part of a existing menu item
                        'submenu' => [
                            'items' => [

                                // This is a menu item of the submenu
                                'lorem'  => [
                                    'text'  => 'Commenting test',
                                    'url'   => $this->di->get('url')->create('commentadmin/lorem'),
                                    'title' => 'Commenting test'
                                ],

                            ],
                        ],
                    ],

                ],
            ],
        ],

        // This is a menu item
        'source' => [
            'text'  =>'Källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => 'Sourcecode browser'
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

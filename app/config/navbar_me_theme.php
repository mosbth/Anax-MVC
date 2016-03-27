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
            'text'  => 'Om mig',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Sidan om mig'
        ],

        // This is a menu item
        'report' => [
            'text'  =>'Redovisning',
            'url'   => $this->di->get('url')->create('redovisning'),
            'title' => 'Redovisning',
        ],

        // This is a menu item
        'regioner' => [
            'text'  =>'Regioner',
            'url'   => $this->di->get('url')->create('regioner'),
            'title' => 'Regioner',
            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [
                'items' => [

                    // This is a menu item of the submenu
                    'typography'  => [
                        'text'  => 'Typography',
                        'url'   => $this->di->get('url')->create('regioner/typography'),
                        'title' => 'Typography'
                    ],
                    // This is a menu item of the submenu
                    'font-awesome'  => [
                        'text'  => 'Font Awesome',
                        'url'   => $this->di->get('url')->create('regioner/fontawesome'),
                        'title' => 'Font Awesome'
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

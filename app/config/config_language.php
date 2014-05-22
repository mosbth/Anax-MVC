<?php
return [
    /**
     * Default settings.
     * 
     */
    'default' => [
        'lang' => 'sv',
        'navbar' => ANAX_APP_PATH . 'config/navbar.php',
        'about' => ANAX_APP_PATH . 'content/about.md',
        'keywords' => 'Default keywords',
        'description' => 'Default description',
    ],

     /**
     * Path settings. 
     * This is the paths to all content-files
     * 
     * If you add some "element" like: content
     * it might be a good idea to add it default too
     */
    'paths' => [
        'navbar' => ANAX_APP_PATH . 'content/$1/navbar.php',
        'profile_text' => ANAX_APP_PATH . 'content/$1/profile_text.php',
        'about' => ANAX_APP_PATH . 'content/$1/about.md',
        'fontpage' => ANAX_APP_PATH . 'content/$1/fontpage.md',
        'titles'    => ANAX_APP_PATH . 'content/$1/titles.php',
    ],

    /**
     * Meta settings
     *
     */
    'meta' => [
        'sv' => [
            'keywords' => 'Svensk keywords',
            'description' => 'Svensk description',
        ],
        'en' => [
            'keywords' => 'English keywords',
            'description' => 'English description',
        ],
    ],
];

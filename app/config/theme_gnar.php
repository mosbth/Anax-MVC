<?php
/**
 * Config-file for Anax, theme related settings, return it all as array.
 *
 */
return [

    /**
     * Settings for Which theme to use, theme directory is found by path and name.
     *
     * path: where is the base path to the theme directory, end with a slash.
     * name: name of the theme is mapped to a directory right below the path.
     */
    'settings' => [
        'path' => ANAX_INSTALL_PATH . 'theme/',
        'name' => 'gnar',
    ],

    
    /** 
     * Add default views.
     */
    'views' => [
      ['region' => 'header', 'template' => 'gnar/header', 'data' => [], 'sort' => -1],
		
        
		//View for footer
        ['region' => 'footer', 'template' => 'gnar/footer', 'data' => [], 'sort' => -1],
	
		//View for navbar
 		['region' => 'navbar', 
        'template' => [
            'callback' => function() {
                return $this->di->navbar->create();
            }
        ],
        'data' => [], 
        'sort' => -1 ],
],



    /** 
     * Data to extract and send as variables to the main template file.
     */
    'data' => [

        // Language for this page.
        'lang' => 'sv',

        // Append this value to each <title>
        'title_append' => 'Shreddin the gnar',

        // Stylesheets
        'stylesheets' => ['css/normalize.css', 'css/bootstrap-theme.min.css', 'css/bootstrap.min.css', 'css/font-awesome-4.4.0/css/font-awesome.min.css','css/formValidation.min.css', 'css/bootstrap-tagsinput.css','css/gnar.css'],
        

        // Inline style
        'style' => null,

        // Favicon
        'favicon' => 'favicon.ico',
        
        'logomenu' => 'img/loggagnarwhite.png',
        
        'annons' => 'img/reklam.jpg',

        // Path to modernizr or null to disable
        'modernizr' => 'js/modernizr.js',

        // Path to jquery or null to disable
        'jquery' => 'js/jquery-2.1.4.min.js',

        // Array with javscript-files to include
        'javascript_include' => ['js/main.js', 'js/bootstrap.min.js', 'js/bootstrap-tagsinput.js', 'js/formValidation.min.js', 'js/bootstrapform.min.js', 'js/sv_SE.js'],

        // Use google analytics for tracking, set key or null to disable
        'google_analytics' => null,
    ],
];

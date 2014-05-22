<?php
/**
 * Enable configuration details for style.php.
 *
 * Make configurations here to make it easer to use one installed base of lessphp on a server 
 * and to make it easier to make non breaking updates to style.php.
 *
 */
return [
     /**
     * Filename for style.less, without prefix .less
     * Allowed characters [a-zA-Z0-9_-]
     * the varible to change is $fileName
     */
    'style_file' => function() use ($app) {
        $settings = $app->theme->getVariable('settings');
        $path = $settings['path'];
        $name = $settings['name'];
        $fileName = 'style';
        return $path . $name . '/css/' . $fileName;
    },
    /*
    'style_file' => function () use ($app) {
        $settings = $app->theme->getVariable('settings');
        $path = $settings['path'];
        $name = $settings['name'];
        $fileName = 'style';
        return $fileName;
    },*/

    /**
     * Include import paths for compiler
     */
    'imports' => null,
    //'imports' => ['../../theme/anax-grid/css/'],
    //TODO: fixa så att style.php exekveras i importsmapparna me!
    

    /**
     * Output format for resulting css-code, set to null for default.
     *
     * lessjs (default) — Same style used in LESS for JavaScript
     * compressed — Compresses all the unrequired whitespace
     * classic — lessphp’s original formatter
     */
    //'formatter' => null,
    'formatter' => 'compressed',
    //$config['formatter'] = 'compressed',


    /**
     * Preserve comments in output, true to preserve comments.
     */
    'comments' => false,


    /**
     * Extend less language by register own functions to lessphp compiler.
     *
     */
    'functions' => array(

        /**
        * Function unit
        *
        * mixins.less:  font: 100.01%/(unit((@magicNumber)/unit(@fontSizeBody))) @fontFamilyBody;
        * mixins.less:  line-height: unit(@magicNumber/(@fontSize*@fontSizeBody)); 
        */
        'unit' => function($arg) {
            list($type, $value) = $arg;
            return array($type, $value);
        },
    ),
];

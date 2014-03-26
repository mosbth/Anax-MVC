<?php
/**
 * Enable configuration details for style.php.
 *
 * Make configurations here to make it easer to use one installed base of lessphp on a server 
 * and to make it easier to make non breaking updates to style.php.
 *
 */
return array(
    /**
     * Path to lessphp compiler include script 
     */
    'path_lessphp' => __DIR__."/lessphp/lessc.inc.php",


    /**
     * Filename for style.less, without prefix .less
     * Allowed characters [a-zA-Z0-9_-]
     */
    //'style_file' => isset($_GET['file']) ? $_GET['file'] : 'style',
    'style_file' => 'style',


    /**
     * Include import paths for compiler
     */
    'imports' => null,


    /**
     * Output format for resulting css-code, set to null for default.
     *
     * lessjs (default) — Same style used in LESS for JavaScript
     * compressed — Compresses all the unrequired whitespace
     * classic — lessphp’s original formatter
     */
    'formatter' => null,
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
);

<?php
/**
 * Enable autoloaders.
 *
 */


/**
 * Default Anax autoloader, and the add specifics through a self invoking anonomous function.
 */
require ANAX_INSTALL_PATH . 'src/Loader/CPsr4Autoloader.php';

call_user_func(function() {
    $loader = new \Anax\Loader\CPsr4Autoloader();
    //$loader->addNameSpace('namespace', ANAX_APP_PATH . 'src');
    $loader->addNameSpace('Anax', ANAX_INSTALL_PATH . 'src');
    $loader->register();
});



/**
 * Including composer autoloader if available.
 *
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
if(is_file(ANAX_INSTALL_PATH . 'vendor/autoload.php')) {
    include ANAX_INSTALL_PATH . 'vendor/autoload.php';
}


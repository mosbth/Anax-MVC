<?php
/**
 * Enable autoloaders.
 *
 */


/**
 * Default Anax autoloader, and the add specifics.
 */
include ANAX_INSTALL_PATH . 'src/autoload.php'; 



/**
 * Including composer autoloader if available.
 *
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
if(is_file(ANAX_INSTALL_PATH . 'vendor/autoload.php')) {
    include ANAX_INSTALL_PATH . 'vendor/autoload.php');
}



/**
 * Register additional dirs for autoloading.
 */
\Anax\CLoader::registerDirs(
    [
        '../app/controllers/',
        '../app/models/'
    ]
);


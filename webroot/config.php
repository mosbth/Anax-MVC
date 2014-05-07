<?php
/**
 * Sample configuration file for Anax webroot.
 *
 */


/**
 * Define essential Anax paths, end with /
 *
 */
define('ANAX_INSTALL_PATH', realpath(__DIR__ . '/../') . '/');
define('ANAX_APP_PATH',     ANAX_INSTALL_PATH . 'app/');



/**
 * Include autoloader.
 *
 */
include(ANAX_APP_PATH . 'config/autoloader.php');



/**
 * Include global functions.
 *
 */
include(ANAX_INSTALL_PATH . 'src/functions.php');

/**
 * Includes database options
 */


// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactory();
$app = new \Anax\Kernel\CAnax($di);

// Sets the timezone
date_default_timezone_set('Europe/Stockholm');

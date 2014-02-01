<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
include(__DIR__ . '/config.php'); 


$di = new \Anax\DI\CDI();

$di->setShared('log', function () {
    $log = new \Anax\Logger\CLog();
    return $log;
});

$di->setShared('request',   '\Anax\Request\CRequest');
$di->setShared('response',  '\Anax\Response\CResponse');
$di->setShared('url',       '\Anax\CUrl');

$di->setShared('session', function() {
    $session = new \Anax\Session\CSession();
    $session->name(preg_replace('/[^a-z\d]/i', '', __DIR__));
    $session->start();
    return $session;
});

$di->setShared('theme', function() {
    $themeEngine = new \Anax\ThemeEngine\CThemeBasic();
    $themeEngine->configure(ANAX_APP_PATH . 'config/theme.php') ;
    return $themeEngine;
});


// Create the app-object anax and inject service container.
$anax = new \Anax\Kernel\CAnax($di);


// Prepare the page content
$anax->theme->setVariable('title', "Hello World Pagecontroller");

$anax->theme->setVariable('main', "
    <h1>Hello World Pagecontroller</h1>
    <p>This is a sample pagecontroller that shows how to use Anax with its base theme, <i>anax-base</i>.</p>
");



// Finally, leave to theme engine to render page.
$anax->theme->render();

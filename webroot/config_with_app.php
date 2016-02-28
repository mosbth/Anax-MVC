<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php';

// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactory();

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('FormController', function () use ($di) {
    $controller = new \Anax\Users\FormController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function () use ($di) {
    $controller = new \Anax\CommentDb\CommentController();
    $controller->setDI($di);
    return $controller;
});

// $app = new \Anax\Kernel\CAnax($di);
$app = new \Anax\MVC\CApplicationBasic($di);

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
// On production server, set pretty urls and use rewrite in .htaccess
$app->url->setUrlType(
    ($_SERVER['SERVER_NAME']=='localhost') ?
    \Anax\Url\CUrl::URL_APPEND : \Anax\Url\CUrl::URL_CLEAN
);
// $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$app->theme->addStylesheet('css/me.css');
$app->theme->addStylesheet('css/comments.css');
$app->theme->addStylesheet('css/users.css');

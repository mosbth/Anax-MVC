<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

//Clean URL's
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 
//Add theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme_gnar.php');
//Add Navbar
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_gnar.php');

$di->set('form', '\Mos\HTMLForm\CForm');
$di->set('time', '\Anax\Content\CTime');

//Lägger till databasen
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

//$di->set('CommentController', function() use ($di) {
//    $controller = new Phpmvc\Comment\CommentController();
//    $controller->setDI($di);
//    return $controller;
//});

//Users Contoller
$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('QuestionsController', function() use ($di) {
    $controller = new \Anax\Questions\QuestionsController();
    $controller->setDI($di);
    return $controller;
});
$di->set('TagsController', function() use ($di) {
    $controller = new \Anax\Tags\TagsController();
    $controller->setDI($di);
    return $controller;
});




$app->session(); 




<?php
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential settings.
require __DIR__.'/config_with_app.php';
// TODO: when using pretty urls index is used to serve page.
 // This page is then not called. 1st workaround: copy code to
 // index.php. 2nd workaround: call page-with-comments.php from
 // index.php.

// Create services and inject into the app.
// $di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function () use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

// $app = new \Anax\Kernel\CAnax($di);



// Home route
$app->router->add('', function () use ($app) {

    $app->theme->setTitle("Welcome to Anax Guestbook");
    $app->views->add('comment/index');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
    ]);
});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

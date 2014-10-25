<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/../config.php';

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryTest();
$app = new \Anax\Kernel\CAnax($di);


$app->router->add('', function () use ($app, $di) {

    $html  = "<pre>" . print_r($di->getServices(), true) . "</pre>";
    $html .= "<h2>These services are active</h2>";
    $html .= "<pre>" . print_r($di->getActiveServices(), true) . "</pre>";

    $app->theme->setTitle("Display available services in \$di");
    $app->views->add('default/page', [
        'title'     => "These services are available in \$di.",
        'content'   => $html,
    ]);

});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

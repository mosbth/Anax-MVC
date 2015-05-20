<?php 
/**
 * app is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/../config.php';


// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryTest();
$app = new \Anax\Kernel\CAnax($di);



// Create the home route
$app->router->add('', function () use ($app) {

    $app->theme->setTitle("Wrong route error verbosity");
    $app->views->add('default/page', [
        'title' => "Verbose error message using wrong route",
        'content' => "Examples of wrong routes, to display verbose error messages.",
        'links' => [
            [
                'href' => $app->url->create("missing-route"),
                'text' => "A non existing route",
            ],
        ]
    ]);

});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();



// Render the page
$app->theme->render();

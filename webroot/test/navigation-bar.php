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
$app->router->add('*', function () use ($app) {

    $app->theme->setTitle("Testing navigation bar");
    $app->views->add('default/page', [
        'title' => "Test navigation bar",
        'content' => "<p>Testing the navigation bar and linking within it. The urls are just for show and clicking them may result in 404. Review how links are created by seeing the source for the configuration of the navbar in site/config/navbar.php.</p> <p>To try out the menu-choice that is marked when descendents are visited - manually add actions to the url.</p>",
    ]);

    // Create the navbar as a view
    $app->theme->addStylesheet('css/navbar.css');
    $app->views->addCallback(
        function () use ($app) {
            return $app->navbar->create();
        },
        [],
        'navbar'
    );

});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();



// Render the page
$app->theme->render();

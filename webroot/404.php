<?php 
/**
 * This is a Anax frontcontroller.
 *
 */
// Get environment & autoloader.
require __DIR__.'/config_with_app.php';



// Home route
$app->router->add('', function () use ($app) {
    throw new \Anax\Exception\NotFoundException();
});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

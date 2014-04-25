<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

// Set the title of the page
$app->theme->setVariable('title', "Hello World Pagecontroller");

// Add a view
$app->views->add('welcome/hello_world');

// Render the response using theme engine.
$app->theme->render();

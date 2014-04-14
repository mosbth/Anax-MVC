<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 



// Prepare the page content
$app->theme->setVariable('title', "Hello World Pagecontroller")
           ->setVariable('main', "
    <h1>Hello World Pagecontroller</h1>
    <p>This is a sample pagecontroller that shows how to use Anax.</p>
");



// Render the response using theme engine.
$app->theme->render();

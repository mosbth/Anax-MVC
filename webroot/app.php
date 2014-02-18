<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php';

dump($_SERVER);

// Add extra assets
$app->theme->addStylesheet('css/dice.css');



// Home route
$app->router->add('', function() {

    $app->views->add('welcome/index');
    $app->theme->setTitle("Welcome to Anax");

})->setName('home');



// Main route to show welcome to dice
$app->router->add('dice', function() {

    $app->views->add('dice/index');
    $app->theme->setTitle("Roll a dice");

})->setName('dice');



// Route to roll dice and show results
$app->router->add('dice/roll', function() use ($app) {

    // Check how many rolls to do
    $roll = $app->request->get('roll', 1);
    $app->validate->check($roll, ['int', 'range' => [1, 100]]);

    // Make roll and prepare reply
    $dice = new \Mos\Dice\CDice();

    $app->views->add('dice/index', [
        'roll'      => $roll,
        'results'   => $dice->getResults,
        'total'     => $dice->getTotal(),
    ]);

    $app->theme->setTitle("Rolled a dice");

})->setName('dice-roll');

$app->router->handle();

$app->views->add('welcome/index');
$app->theme->setTitle("Welcome to Anax");


// Render the response using theme engine.
$app->theme->render();

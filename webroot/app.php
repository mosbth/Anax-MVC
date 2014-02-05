<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
include(__DIR__.'/config_pagecontroller.php'); 



// Add extra assets
$app->theme->addStylesheet("css/dice.css");



// Main route to show welcome to dice
$app->route->add('dice', function() {

    $app->view->add('main', 'dice/index');
    $app->theme->setTitle("Roll a dice");

})->setName('dice');



// Route to roll dice and show results
$app->route->add('dice/roll', function() use ($app) {

    // Check how many rolls to do
    $roll = $app->request->get('roll', 1);
    $app->validate->check($roll, ['int', 'range' => [1, 100]]);

    // Make roll and prepare reply
    $dice = new \Mos\Dice\CDice();

    $app->view->add('dice/index', [
        'roll'      => $roll,
        'results'   => $dice->getResults,
        'total'     => $dice->getTotal(),
    ]);

    $app->theme->setTitle("Rolled a dice");

})->setName('dice-roll');



// Render the response using theme engine.
$app->theme->render();

<?php
require __DIR__.'/config.php';
$app->router->add('', function() use($app) {    
    $app->theme->setTitle("Regioner");
    $app->views->add('grid/page', [
        'content' => 'Coolt som fan'
    ]); 
});

$app->router->handle();
$app->theme->render();

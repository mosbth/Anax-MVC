<?php

require __DIR__.'/config_with_app.php';

$app->theme->addStylesheet('css/users.css');


// Home route
$app->router->add('', function () use ($app) {

    // temp
    $app->theme->setTitle("User administration");
    $app->views->add('default/page', [
        'title' => "User administration",
        'content' => "Page to test user administration. List users in order to edit or delete users. ",
        'links' => [
            [
                'href' => $app->url->create('users/setup'),
                'text' => "Setup user table with test data",
            ],
            [
                'href' => $app->url->create('users/list'),
                'text' => "List all users",
            ],
            [
                'href' => $app->url->create('users/active'),
                'text' => "List active users",
            ],
            [
                'href' => $app->url->create('users/inactive'),
                'text' => "List inactive users",
            ],
            [
                'href' => $app->url->create('users/wastebasket'),
                'text' => "List users in wastebasket",
            ],
            [
                'href' => $app->url->create('users/add'),
                'text' => "Add user",
            ],
            [
                'href' => $app->url->create('lorem'),
                'text' => "Test page for user comments",
            ],
            [
                'href' => $app->url->create('comment/setup'),
                'text' => "Setup comment system",
            ],
            [
                'href' => $app->url->create('comment/add'),
                'text' => "Add comment",
            ],
        ],
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);


});

// Test route subpage with dummy content to test comment flow.
$app->router->add('lorem', function () use ($app) {
    $route = $app->request->getRoute();
    $app->theme->setTitle("Test comment flow");
    $app->views->add('default/page', [
        'title' => "Test comment flow",
        'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras turpis nisi, cursus ac leo ac, tempor faucibus lacus. Etiam iaculis ornare libero, elementum sagittis est finibus sed. Route is <em>$route</em>.",
    ]);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

});

// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

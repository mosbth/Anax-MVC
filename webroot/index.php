<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';

// Add alias to root home-page.
$app->router->add('home', function () use ($app) {
    $app->redirectTo('');
});
// Home page listing recent questions, most popular tags, most active users.
$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Hem");
    // dispatcher for recent Questions
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => 'recentquestions',
        'params'    => [ 3, ],
    ]);

    // dispatcher for most popular Tags mostpopular
    $app->dispatcher->forward([
        'controller' => 'tags',
        'action'     => 'mostpopular',
        'params'    => [ 3, ],
    ]);

    // dispatcher for most active Users
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'mostactive',
        'params'    => [ 3, ],
    ]);

});

$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("Om oss");
    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('report.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

// Route to all questions. Alias for route /questions/list.
$app->router->add('questions', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => 'list',
    ]);
});

// Route to source code page
$app->router->add('source', function () use ($app) {
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);

});


// Route to user administration
$app->router->add('users', function () use ($app) {
    $app->theme->setTitle("User administration");
    $app->views->add('default/page', [
        'title' => "User administration",
        'content' => "Page to test user administration. List users in order to edit or delete users. ",
        'links' => [
            [
                'href' => $app->url->create('users/setup'),
                'text' => "Setup user table with test data (erases current user table)",
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
        ],
    ]);

});

$app->router->add('admin', function () use ($app) {
    $app->theme->setTitle("Admin page");

    $app->views->add('default/page', [
        'title' => "Admin page",
        'content' => "Page for various administration tasks.",
        'links' => [
            [
                'href' => $app->url->create('admin/setup'),
                'text' => "Initialize complete database (warning: will erase all)",
            ],
            [
                'href' => $app->url->create('answers/setup'),
                'text' => "Initialize Answers model",
            ],
            [
                'href' => $app->url->create('tags/setup'),
                'text' => "Initialize Tags model",
            ],
            [
                'href' => $app->url->create('adminquestions'),
                'text' => "Administrate Questions",
            ],
            [
                'href' => $app->url->create('users'),
                'text' => "Administrate users",
            ],
        ],
    ]);

});

// Questions admin
$app->router->add('adminquestions', function () use ($app) {
    $app->theme->setTitle("Admin Questions");

    $app->views->add('default/page', [
        'title' => "Admin Questions",
        'content' => "Page for Question administration.",
        'links' => [
            [
                'href' => $app->url->create('questions/setup'),
                'text' => "Setup Question table with test data (first time setup, erases all current Questions)",
            ],
            [
                'href' => $app->url->create('questions'),
                'text' => "Questions page",
            ],
        ],
    ]);

});

//Route to initialize and setup complete database with all tables.
$app->router->add('admin/setup', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => 'setup',
    ]);
    $app->dispatcher->forward([
        'controller' => 'answers',
        'action'     => 'setup',
    ]);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'setup',
    ]);
    $app->dispatcher->forward([
        'controller' => 'tags',
        'action'     => 'setup',
    ]);
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'setup',
    ]);
    $app->theme->setTitle("Reset db");
    $app->views->add('default/page', [
        'title' => "Reset of database",
        'content' => "The complete database has been reset.",
        'links' => [
            [
                'href' => $app->url->create('questions/list'),
                'text' => "Goto Questions page",
            ],
            [
                'href' => $app->url->create('users/list'),
                'text' => "Goto Users page",
            ],
        ],
    ]);
});



$app->router->handle();
$app->theme->render();

<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';


// TODO: Learn/adapt how to add external resources e.g. fonts
// $app->theme->addStylesheet('https://fonts.googleapis.com/css?family=Raleway:400,200');
// $app->theme->setVariable('me-fonts', 'https://fonts.googleapis.com/css?family=Pragati+Narrow');
$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Om mig");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
});

$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("Om oss");
    // TODO: write a about in md
    $content = $app->fileContent->get('me.md');
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

// Route to all questions
// TODO: remove this route and use /questions/list instead. change in menu. Or keep as alias.
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
        ],
    ]);

});

// Route to administer comments
$app->router->add('commentadmin', function () use ($app) {
    $app->theme->setTitle("Comments administration");
    $app->views->add('default/page', [
        'title' => "Comments administration",
        'content' => "Page to test comments administration. ",
        'links' => [
            [
                'href' => $app->url->create('comment/setup'),
                'text' => "Setup comment system",
            ],
            [
                'href' => $app->url->create('comment/list'),
                'text' => "List all comments in comment system",
            ],
            [
                'href' => $app->url->create('commentadmin/lorem'),
                'text' => "Test page for user comments on subpage",
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
                'href' => $app->url->create('admincontacts'),
                'text' => "Administrate messages from contact form",
            ],
            [
                'href' => $app->url->create('users'),
                'text' => "Administrate users",
            ],
            [
                'href' => $app->url->create('commentadmin'),
                'text' => "Administrate comments",
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

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

// TODO: move to config_with_app
// Load Contact Form Controller
$di->set('ContactformController', function () use ($di) {
    $controller = new \Fnlive\Contactform\ContactFormController();
    $controller->setDI($di);
    return $controller;
});

$app->theme->addStylesheet('css/dice.css');
// Route to show welcome to dice
$app->router->add('dice', function () use ($app) {

    $app->views->add('dice/index');
    $app->theme->setTitle("Roll a dice");

    $app->dispatcher->forward([
        'controller' => 'contactform',
        'action'     => 'display',
    ]);

});

// Route to calendar
$app->router->add('calendar', function () use ($app) {
    $app->theme->addStylesheet('css/calendar.css');
    $app->theme->setTitle("Kalender");

    $today = new DateTime();
    $date = $app->request->getGet('date', $today->format('Y-m-d'));
    $calendar = new \Fnlive\Calendar\CCalendar($date);
    // $calendar = new \Mos\Calendar\CCalendar($date);

    $app->views->add('calendar/index', [
        'prevMonth' => $calendar->prevMonth(),
        'nextMonth' => $calendar->nextMonth(),
        'prevMonthDate' => $calendar->prevMonthDate(),
        'nextMonthDate' => $calendar->nextMonthDate(),
        'thisMonth' => $calendar->thisMonth(),
        'dates' => $calendar->datesInMonth(),
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

});

// Route to roll dice and show results
$app->router->add('dice/roll', function () use ($app) {

    // Check how many rolls to do
    $roll = $app->request->getGet('roll', 1);
    $app->validate->check($roll, ['int', 'range' => [1, 100]])
        or die("Roll out of bounds");

    // Make roll and prepare reply
    $dice = new \Mos\Dice\CDice();
    $dice->roll($roll);

    $app->views->add('dice/index', [
        'roll'      => $dice->getNumOfRolls(),
        'results'   => $dice->getResults(),
        'total'     => $dice->getTotal(),
    ]);

    $app->theme->setTitle("Rolled a dice");

});

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


// Home route
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


// Test route subpage with dummy content to test comment flow.
$app->router->add('commentadmin/lorem', function () use ($app) {
    $route = $app->request->getRoute();
    $app->theme->setTitle("Test comment flow");
    $app->views->add('default/page', [
        'title' => "Test comment flow",
        'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.
         Cras turpis nisi, cursus ac leo ac, tempor faucibus lacus. Etiam iaculis ornare libero,
         elementum sagittis est finibus sed. Route is <em>$route</em>.",
    ]);
    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

});

$app->router->add('admin', function () use ($app) {
    $app->theme->setTitle("Admin page");

    $app->views->add('default/page', [
        'title' => "Admin page",
        'content' => "Page for various administration tasks.",
        'links' => [
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


// TODO: move to config_with_app???
// Load Contact Form controller
$di->set('ContactformadminController', function () use ($di) {
    $controller = new \Fnlive\Contactform\ContactFormAdminController();
    $controller->setDI($di);
    return $controller;
});

$app->router->add('admincontacts', function () use ($app) {
    $app->theme->setTitle("Admin contacts");

    $app->views->add('default/page', [
        'title' => "Admin contacts",
        'content' => "Page for testing contact form message administration.",
        'links' => [
            [
                'href' => $app->url->create('contactformadmin/setup'),
                'text' => "Setup user table with test data (first time setup, erases all current messages)",
            ],
            [
                'href' => $app->url->create('dice'),
                'text' => "Check usage of comment form on Dice page",
            ],
        ],
    ]);

    $app->dispatcher->forward([
        'controller' => 'contactformadmin',
        // 'controller' => 'ContactFormAdminController',
        'action'     => 'list',
    ]);
});



$app->router->handle();
$app->theme->render();

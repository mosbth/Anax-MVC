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

$app->theme->addStylesheet('css/dice.css');
// Route to show welcome to dice
$app->router->add('dice', function () use ($app) {

    $app->views->add('dice/index');
    $app->theme->setTitle("Roll a dice");

});

// Route to calendar
$app->router->add('calendar', function () use ($app) {
    $app->theme->addStylesheet('css/calendar.css');
    $app->theme->setTitle("Kalender");

    $today = new DateTime();
    $date = $app->request->getGet('date', $today->format('Y-m-d'));
    $calendar = new \Mos\Calendar\CCalendar($date);

    $app->views->add('calendar/index', [
        'prevMonth' => $calendar->prevMonth(),
        'nextMonth' => $calendar->nextMonth(),
        'prevMonthDate' => $calendar->prevMonthDate(),
        'nextMonthDate' => $calendar->nextMonthDate(),
        'thisMonth' => $calendar->thisMonth(),
        'dates' => $calendar->datesInMonth(),
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

// Add page with comment system
$di->set('CommentController', function () use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

// Home route
$app->router->add('comment', function () use ($app) {

    $app->theme->setTitle("Welcome to Anax Guestbook");
    $app->views->add('comment/index');

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
    ]);

    $app->views->add('comment/form', [
        'mail'      => null,
        'web'       => null,
        'name'      => null,
        'content'   => null,
        'output'    => null,
    ]);
});

$app->router->handle();
$app->theme->render();

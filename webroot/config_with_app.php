<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */
mb_internal_encoding();
mb_http_output();

// Get environment & autoloader.
require __DIR__.'/config.php';

// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactory();

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('FormController', function () use ($di) {
    $controller = new \Anax\Users\FormController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function () use ($di) {
    $controller = new \Anax\CommentDb\CommentController();
    $controller->setDI($di);
    return $controller;
});
// Load Questions Controller
$di->set('QuestionsController', function () use ($di) {
    $controller = new \Anax\Questions\QuestionsController();
    $controller->setDI($di);
    return $controller;
});
// Load Tags Controller
$di->set('TagsController', function () use ($di) {
    $controller = new \Anax\Tags\TagsController();
    $controller->setDI($di);
    return $controller;
});
// Load Answers Controller
$di->set('AnswersController', function () use ($di) {
    $controller = new \Anax\Answers\AnswersController();
    $controller->setDI($di);
    return $controller;
});

// $app = new \Anax\Kernel\CAnax($di);
$app = new \Anax\MVC\CApplicationBasic($di);

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
// On production server, set pretty urls and use rewrite in .htaccess
$app->url->setUrlType(
    ($_SERVER['SERVER_NAME']=='localhost') ?
    \Anax\Url\CUrl::URL_APPEND : \Anax\Url\CUrl::URL_CLEAN
);
// $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// $app->theme->addStylesheet('css/me.css');
// $app->theme->addStylesheet('css/comments.css');
// $app->theme->addStylesheet('css/users.css');


// $di->set('answers', '\Anax\Answers\CAnswers');
// $di->set('comments', '\Anax\CommentDb\CommentsInDb');
// $di->set('users', '\Anax\Users\User');


// $app->comments = new \Anax\CommentDb\CommentsInDb();
// $app->comments->setDI($di);
// $app->answers = new \Anax\Answers\CAnswers();
// $app->answers->setDI($di);
$app->users = new \Anax\Users\User();
$app->users->setDI($di);

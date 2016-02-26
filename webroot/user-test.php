<?php

require __DIR__.'/config_with_app.php';

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});


// $app->router->add('setup', function () use ($app) {
//
//     $app->db->setVerbose();
//
//     $app->db->dropTableIfExists('user')->execute();
//
//     $app->db->createTable(
//         'user',
//         [
//             'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
//             'acronym' => ['varchar(20)', 'unique', 'not null'],
//             'email' => ['varchar(80)'],
//             'name' => ['varchar(80)'],
//             'password' => ['varchar(255)'],
//             'created' => ['datetime'],
//             'updated' => ['datetime'],
//             'deleted' => ['datetime'],
//             'active' => ['datetime'],
//         ]
//     )->execute();
//
//     $app->db->insert(
//         'user',
//         ['acronym', 'email', 'name', 'password', 'created', 'active']
//     );
//
//     $now = gmdate('Y-m-d H:i:s');
//
//     $app->db->execute([
//         'admin',
//         'admin@dbwebb.se',
//         'Administrator',
//         password_hash('admin', PASSWORD_DEFAULT),
//         $now,
//         $now
//     ]);
//
//     $app->db->execute([
//         'doe',
//         'doe@dbwebb.se',
//         'John/Jane Doe',
//         password_hash('doe', PASSWORD_DEFAULT),
//         $now,
//         $now
//     ]);
//
//     $app->theme->setTitle("Testing Creation of database");
//     $app->views->add('default/page', [
//         'title' => "Setting up a database table",
//         'content' => "A user db table is set up.",
//     ]);
//
// });

// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

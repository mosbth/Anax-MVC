<?php

require __DIR__.'/config.php';

$app->theme->configure(ANAX_APP_PATH. 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH .'config/navbar_users.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->setShared('db', function() use ($di) {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$app->router->add('setup', function() use ($app) {
    $s = date(DATE_RFC2822);
    $app->theme->setTitle('Setup');

    //$app->db->setVerbose();

    $app->db->dropTableIfExists('user')->execute();

    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();

    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );

    $now = date(DATE_RFC2822);

    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);

    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);


    $app->views->add('me/page', [
        'content' => '<h3>Hello setup here and stuff'
    ]);

});
$app->router->add('list', function() use ($app) {

});
$app->router->handle();
$app->theme->render();

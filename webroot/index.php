<?php
require __DIR__.'/config.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->set('CommentController', function() use ($di) {
    $controller = new \Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('db', function() use ($app) {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . "config/config_mysql.php");
    $db->connect();
    return $db;
});

$app->router->add('', function() use($app) {
	$app->theme->setTitle('Hem');
  $content = $app->fileContent->get('me.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

  $byline = $app->fileContent->get('byline.md');
  $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

  $app->views->add('me/page', [
    'content' => $content,
    'byline' => $byline,
  ]);
});

$app->router->add('source', function() use ($app) {
    $app->theme->addStylesheet('css/anax-base/source.css');
    $app->theme->setTitle("Source");
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});


$app->router->add('redovisning', function() use ($app) {
 	$app->theme->setTitle('Redovisning');
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown, bbcode');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
    ]);

    $app->views->add('comment/form', [
      'mail'      => null,
      'web'       => null,
      'name'      => null,
      'content'   => null,
      'output'    => null,
    ]);
});


$app->router->add('tema', function() use ($app) {
    $app->theme->setTitle('Mitt tema');

    $main = '<p>Testar lite Awesome-font <br><i class="fa fa-camera-retro fa-lg"></i> fa-camera-retro</p>
    <p><i class="fa fa-camera-retro fa-2x"></i> fa-camera-retro</p>
    <p><i class="fa fa-camera-retro fa-3x"></i> fa-camera-retro</p>
    <p><i class="fa fa-camera-retro fa-4x"></i> fa-camera-retro</p>
    <p><i class="fa fa-camera-retro fa-5x"></i> fa-camera-retro</p>';

    $sidebar = "<h3>Fin exepeltext</h3>";
    for ($i=0; $i < 3; $i++) {
        $sidebar .= "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
    }


    $app->views->addString('Fin flash text här.', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->add('grid/page', [
                        'content' => $main,
                        'byline' => null,
                ])
               ->addString($sidebar, 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
});


$app->router->handle();
$app->theme->render();

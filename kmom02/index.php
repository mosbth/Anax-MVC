<?php
require __DIR__.'/config.php';

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
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
    $app->theme->addStylesheet('css/source.css');
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
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
 
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

$app->router->handle();
$app->theme->render();

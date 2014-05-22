<?php
require __DIR__.'/config.php';

$app->withSession();

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->dispatcher->forward([
    'controller' => 'Complementary',
    'action'     => 'all',
]);

$app->router->add('', function() use ($app) {
    $app->theme->setTitle($app->getConfig('titles')['home']);

    $content = $app->lang->get('fontpage');
  
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
   
    $flash = $app->sflash->get();
    $app->views->add('grid/page', [
        'content' => $content,
    ]);
});

$app->router->add('about', function() use ($app) {
    $app->theme->setTitle($app->getConfig('titles')['about']);

    $content = $app->lang->get('about');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
   
    $app->views->add('default/article', [
        'content' => $content,
    ]);
});

$app->router->add('source', function() use ($app) {
    $app->theme->addStylesheet('css/anax-base/source.css');
    $app->theme->setTitle($app->getConfig('titles')['source']);
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});

$app->router->handle();
$app->theme->render();

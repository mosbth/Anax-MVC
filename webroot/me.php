<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Om mig");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    // $app->views->add('me');
    $app->views->add('me/page', [
        'content' => $content,
        // TODO: Add byline stuff
        // 'byline' => $byline,
    ]);
});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('report.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    // $byline  = $app->fileContent->get('byline.md');
    // $app->views->add('me/redovisning');
    $app->views->add('me/page', [
        'content' => $content,
        // 'byline' => $byline,
    ]);

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

$app->router->handle();
$app->theme->render();

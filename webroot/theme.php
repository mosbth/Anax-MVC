<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me_theme.php');

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

if ($app->request->getGet('show-grid', 0)) {
    $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
}

$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("Om mig");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->addString($content, 'main')
               ->addString($byline, 'triptych-1');

});

$app->router->add('regioner', function () use ($app) {

    $app->theme->setTitle("Regioner");
    $grid = $app->fileContent->get('show_grid.php');

    $app->views->addString('flash', 'flash')
                ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString($grid, 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');

});

$app->router->add('regioner/typography', function () use ($app) {
    $app->theme->setTitle("Typography");

    $grid = $app->fileContent->get('show_grid.php');
    $contentFlash = $app->fileContent->get('typography-flash.php');
    $content = $app->fileContent->get('typography.php');
    $contentShort = $app->fileContent->get('typography_short.php');
    $contentParagraph = $app->fileContent->get('typography_p.php');
    $contentFaWebApps = $app->fileContent->get('font-awesome-webapps.php');
    $contentFaEx = $app->fileContent->get('font-awesome-ex.php');

    $app->views->addString($contentFlash, 'flash')
                ->addString($grid, 'featured-1')
               ->addString($contentParagraph, 'featured-2')
               ->addString($contentFaWebApps, 'featured-3')
               ->addString($content, 'main')
               ->addString($contentShort, 'sidebar')
               ->addString($contentParagraph, 'triptych-1')
               ->addString($contentParagraph, 'triptych-2')
               ->addString($contentParagraph, 'triptych-3')
               ->addString($contentFaWebApps, 'footer-col-1')
            //    ->addString('footer-col-2', 'footer-col-2')
               ->addString($contentFaEx, 'footer-col-3')
            //    ->addString('footer-col-4', 'footer-col-4')
            ;

});

$app->router->add('regioner/fontawesome', function () use ($app) {
    $app->theme->setTitle("Fontawesome");

    $grid = $app->fileContent->get('show_grid.php');
    $contentParagraph = $app->fileContent->get('typography_p.php');
    $contentFaWebApps = $app->fileContent->get('font-awesome-webapps.php');
    $contentFaEx = $app->fileContent->get('font-awesome-ex.php');

    $app->views->addString($contentFaWebApps, 'triptych-1')
               ->addString($contentFaEx, 'triptych-2')
               ->addString($contentParagraph, 'triptych-3')
               ->addString($grid, 'footer-col-1')
               ;
});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('report.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->addString($content, 'main')
            ->addString($byline, 'triptych-1');
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

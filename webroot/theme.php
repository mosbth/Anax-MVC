<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

$app->router->add('regioner', function () use ($app) {

    // $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");

    $app->views->addString('flash', 'flash')
               ->addString(file_get_contents('css/anax-grid/font-awesome-ex.php'), 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString(file_get_contents('css/anax-grid/typography.php'), 'main')
               ->addString(file_get_contents('css/anax-grid/typography.php'), 'sidebar')
            //    ->addString(file_get_contents('css/anax-grid/font-awesome-ex.html'), 'sidebar')
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

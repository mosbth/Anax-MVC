<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 



// Read another config-file for the theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar-grid.php');

if (isset($_GET['show-grid'])) {
    $app->theme->addStylesheet('css/anax-grid/display_grid.css');
}

$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Nytt tema");

    $content = $app->fileContent->get('theme-home.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('welcome/page', [
        'content' => $content,
    ]);

});



$app->router->add('grid', function() use ($app) {

    $app->theme->addStylesheet('css/anax-grid/display_grid.css');
    $app->theme->setTitle("Visa rutnät");

    $content = $app->fileContent->get('theme-home.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('welcome/page', [
        'content' => $content,
    ]);

});




$app->router->add('regioner', function() use ($app) {

    $app->theme->addStylesheet('css/anax-grid/regions_demo.css');
    $app->theme->setTitle("Regioner");

    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');

});





$app->router->add('typografi', function() use ($app) {

    $app->theme->setTitle("Typografi");

    $content = $app->fileContent->get('typography.html');

    $app->views->add('welcome/page', ['content' => $content]);
    $app->views->add('welcome/page', ['content' => $content], 'sidebar');

});




$app->router->add('font-awesome', function() use ($app) {

    $app->theme->setTitle("Använd Font Awesome");

    $content = $app->fileContent->get('fontawesome.html');
    $app->views->add('welcome/page', ['content' => $content]);

    $content = $app->fileContent->get('fontawesome2.html');
    $app->views->add('welcome/page', ['content' => $content], 'sidebar');

});




$app->router->add('source', function() use ($app) {

    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Redovisning");

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);

});




// Handle routes and render the page
$app->router->handle();
$app->theme->render();


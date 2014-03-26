<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php'; 



// Read another config-file for the theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);



// Add extra assets
$app->theme->addStylesheet('css/dice.css');



// Home route
$app->router->add('', function() use ($app) {

    $app->theme->setTitle("Om mig");

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('welcome/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});




// Route to Redovisningar
$app->router->add('redovisning', function() use ($app) {

    $app->theme->setTitle("Redovisning");

    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('welcome/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});




// Route to Visa källkod
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

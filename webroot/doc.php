<?php
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php';



// Create services and inject into the app.
$di  = new \Anax\DI\CDIFactoryDocumentation();
$app = new \Anax\Kernel\CAnax($di);

//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_demo.php');

// Set title for all pages
$app->theme->setBaseTitle(" - Anax documentation");



// Valid pages
$pages = [
    ''                  => ['title' => 'Home', 'file' => 'index.md'],
    'http-error-codes'  => ['title' => 'Exceptions as HTTP error codes'],
    'create-urls'       => ['title' => 'Creating urls'],
    'create-urls-in-md' => ['title' => 'Creating urls in text or Markdown'],
];



// Create a default route to catch all
$app->router->add('*', function () use ($app, $pages) {

    // Get current route
    $route = $app->request->getRoute();

    if (!isset($pages[$route])) {
        throw new \Anax\Exception\NotFoundException("The documentation page does not exists.");
    }

    $title = $pages[$route]['title'];
    $file  = isset($pages[$route]['file'])
        ? $pages[$route]['file']
        : $route . ".md";

    $app->theme->setTitle($title);

    $content = $app->documentation->get($file);
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('default/article', [
        'content' => $content,
    ]);

});






// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();



// Render the page
$app->theme->render();

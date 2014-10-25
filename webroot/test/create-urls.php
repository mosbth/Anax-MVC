<?php 
/**
 * app is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/../config.php';


// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryTest();
$app = new \Anax\Kernel\CAnax($di);



// Create the home route
$app->router->add('*', function () use ($app) {

    $app->theme->setTitle("Creating urls");
    $app->views->add('default/page', [
        'title' => "Create urls to routes, resources and assets",
        'content' => "Examples to create urls. The urls are just for show and clicking them may result in 404.",
        'links' => [
            [
                'href' => $app->url->create(),
                'text' => "Home route of this frontcontroller",
            ],
            [
                'href' => $app->url->create('about'),
                'text' => "Local route to this frontcontroller names 'about'",
            ],
            [
                'href' => $app->url->create('about/me'),
                'text' => "Local route to this frontcontroller names 'about/me'",
            ],
            [
                'href' => $app->url->create('/sitemap.xml'),
                'text' => "Sitespecifik resource as '/sitemap.xml'",
            ],
            [
                'href' => $app->url->create('/robots.xml'),
                'text' => "Sitespecifik resource as '/robots.xml'",
            ],
            [
                'href' => $app->url->createRelative('doc.php'),
                'text' => "Relative current frontcontroller 'doc.php'",
            ],
            [
                'href' => $app->url->createRelative('../doc.php'),
                'text' => "Relative current frontcontroller '../doc.php'",
            ],
            [
                'href' => $app->url->createRelative('test'),
                'text' => "Relative current frontcontroller 'test'",
            ],
            [
                'href' => $app->url->createRelative('test/testcase.php'),
                'text' => "Relative current frontcontroller 'test/testcase.php'",
            ],
            [
                'href' => $app->url->asset('css/style.css'),
                'text' => "Asset relative current frontcontroller 'css/style.css'",
            ],
            [
                'href' => $app->url->asset('/css/style.css'),
                'text' => "Asset sitespecifik '/css/style.css'",
            ],
        ]
    ]);

});



// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();



// Render the page
$app->theme->render();

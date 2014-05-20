<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php';

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);


$di->set('TestController', function () use ($di) {
    $controller = new TestController();
    $controller->setDI($di);
    return $controller;
});


class TestController
{
    use \Anax\DI\TInjectable;

    public function indexAction()
    {
        $this->theme->setTitle("Anax MVC error reporting");
        $this->views->add('default/page', [
            'title' => "Testing error reporting from Anax MVC",
            'content' => "Trying out some missusage of Anax MVC to see if the errors are easy to understand.",
            'links' => [
                [
                    'href' => $this->url->create('t1'),
                    'text' => "Using not defined service as property of \$app",
                ],
                [
                    'href' => $this->url->create('t2'),
                    'text' => "Using not defined service as method of \$app",
                ],
                [
                    'href' => $this->url->create('t3'),
                    'text' => "Forward to non-existing controller",
                ],
                [
                    'href' => $this->url->create('t4'),
                    'text' => "Forward to non-existing action",
                ],
            ]
        ]);
    }
}



$app->router->add('', function () use ($app) {

    $app->dispatcher->forward(['controller' => 'test']);

});


$app->router->add('t1', function () use ($app) {

    $app->dispatchNO;

    $app->dispatcher->forward(['controller' => 'test']);

});


$app->router->add('t2', function () use ($app) {

    $app->dispatchNO();

    $app->dispatcher->forward(['controller' => 'test']);

});


$app->router->add('t3', function () use ($app) {

    $app->dispatcher->forward(['controller' => 'testNO']);

    $app->dispatcher->forward(['controller' => 'test']);

});


$app->router->add('t4', function () use ($app) {

    $app->dispatcher->forward(['controller' => 'test', 'action' => 'NONE']);

    $app->dispatcher->forward(['controller' => 'test']);

});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

<?php 
/**
 * This is a Anax frontcontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/../config.php';

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryTest();
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
        $this->theme->setTitle("Delegate view creation to other methods/actions and use forward");
        $this->views->add('default/page', [
            'title' => "Delegate view creation to other methods and use forward",
            'content' => "Add views by using forward. This page is built up by several views, combined in one controller/action but added using dispatcher->forward().",
        ]);

        $this->dispatcher->forward([
            'controller' => 'test',
            'action' => 'addView1',
        ]);

        $this->dispatcher->forward([
            'controller' => 'test',
            'action' => 'addView2',
            'params' => ["A_PARAMETER", "ANOTHER PARAM"],
        ]);

        $this->views->add('default/page', [
            'title' => "Last view",
            'content' => "This view is created in indexAction()",
        ]);
    }

    public function addView1Action()
    {
        $this->views->add('default/page', [
            'title' => "View 1.1",
            'content' => "This view is created in addView1Action()",
        ]);

        $this->views->add('default/page', [
            'title' => "View 1.2",
            'content' => "This view is created in addView1Action()",
        ]);
    }

    public function addView2Action($str1, $str2)
    {
        $this->views->add('default/page', [
            'title' => "View 2",
            'content' => "This view is created in addView1Action(), the parameter values are: $str1, $str2",
        ]);
    }
}



$app->router->add('', function () use ($app) {

    $app->dispatcher->forward(['controller' => 'test']);
});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();

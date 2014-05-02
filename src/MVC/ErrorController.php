<?php

namespace Anax\MVC;

/**
 * Anax base class implementing Dependency Injection / Service Locator 
 * of the services used by the framework, using lazy loading.
 *
 */
class ErrorController
{
    use \Anax\DI\TInjectionAware;



   /**
     * Display a page for a HTTP status code.
     *
     * @param string header  status code to set the http header.
     * @param string message an optional message to display together with the error code.
     *
     * @return void
     */
    public function statusCodeAction($code, $message = null)
    {
        $codes = [
            403 => "403 Forbidden",
            404 => "404 Not Found",
            500 => "500 Internal Server Error",
        ];

        if (!in_array($code, $codes)) {
            throw new \Anax\Excpeption\NotFoundException("Not a valid HTTP status code.");
        }

        $title = $codes[$code];
        $this->di->response->setHeader($code);
        $this->di->theme->setTitle($title);
        $this->di->views->add('default/error', [
            'title' => $title,
            'content' => $message,
        ]);
    }
}

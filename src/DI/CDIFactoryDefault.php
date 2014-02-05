<?php

namespace Anax\DI;

/**
 * Anax base class implementing Dependency Injection / Service Locator 
 * of the services used by the framework, using lazy loading.
 *
 */
class CDIFactoryDefault extends CDI
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setShared('log', function () {
            $log = new \Anax\Logger\CLog();
            $log->setContext('development');
            return $log;
        });

        $this->setShared('request',   '\Anax\Request\CRequestBase');
        $this->setShared('response',  '\Anax\Response\CResponse');
        $this->setShared('url',       '\Anax\Url\CUrl');
        $this->setShared('validate',  '\Anax\Validate\CValidate');

        $this->setShared('view', function() {
            $view = new \Anax\View\CViewBasic();
            $view->setFileSuffix('.tpl.php');
            return $view;   
        });

        $this->setShared('route', function() {
            $route = new \Anax\Route\CRoute();
            $route->add('403', function() {
                $this->response->setHeader('403');
                $this->view->add('main', 'error/403');
            });
            $route->add('404', function() {
                $this->response->setHeader('404');
                $this->view->add('main', 'error/404');
            });
            return $route;
        });

        $this->setShared('session', function() {
            $session = new \Anax\Session\CSession();
            $session->configure(ANAX_APP_PATH . 'config/session.php');
            $session->name();
            $session->start();
            return $session;
        });

        $this->setShared('theme', function() {
            $themeEngine = new \Anax\ThemeEngine\CThemeBasic();
            $themeEngine->configure(ANAX_APP_PATH . 'config/theme.php');
            return $themeEngine;
        });
    }
}

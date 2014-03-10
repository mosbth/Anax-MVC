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

        $this->setShared('response',  '\Anax\Response\CResponseBasic');
        $this->setShared('validate',  '\Anax\Validate\CValidate');
        
        $this->set('view',  '\Anax\View\CViewBasic');
        $this->set('route', '\Anax\Route\CRouteBasic');

        $this->setShared('log', function () {
            $log = new \Anax\Logger\CLog();
            $log->setContext('development');
            return $log;
        });

        $this->setShared('request', function() {
            $request = new \Anax\Request\CRequestBasic();
            $request->init();
            return $request;
        });

        $this->setShared('url', function() {
            $url = new \Anax\Url\CUrl();
            $url->setSiteUrl($this->request->getSiteUrl());
            $url->setBaseUrl($this->request->getBaseUrl());
            $url->setScriptName($this->request->getScriptName());
            $url->setUrlType($url::URL_APPEND);
            return $url;
        });

        $this->setShared('views', function() {
            $views = new \Anax\View\CViewContainerBasic();
            $views->setFileSuffix('.tpl.php');
            $views->setBasePath(ANAX_APP_PATH . 'view');
            $views->setDI($this);
            return $views;   
        });

        $this->setShared('router', function() {
            
            $router = new \Anax\Route\CRouterBasic();
            $router->setDI($this);

            $router->add('403', function() {
                $this->response->setHeader('403');
                $this->theme->setTitle("Forbidden");
                $this->views->add('error/403');
            })->setName('403');

            $router->addNotFound(function() {
                $this->response->setHeader('404');
                $this->theme->setTitle("Not Found");
                $this->views->add('error/404');
            })->setName('404');
            
            return $router;
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
            $themeEngine->setDI($this);
            return $themeEngine;
        });
    }
}

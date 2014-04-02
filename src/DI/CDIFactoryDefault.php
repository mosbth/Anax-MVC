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

        require ANAX_APP_PATH . 'config/error_reporting.php';

        $this->setShared('response',  '\Anax\Response\CResponseBasic');
        $this->setShared('validate',  '\Anax\Validate\CValidate');
        
        $this->set('route', '\Anax\Route\CRouteBasic');
        $this->set('view', '\Anax\View\CViewBasic');

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
            $views->setBasePath(ANAX_APP_PATH . 'view');
            $views->setFileSuffix('.tpl.php');
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

        $this->setShared('dispatcher', function() {
            $dispatcher = new \Anax\MVC\CDispatcherBasic();
            $dispatcher->setDI($this);
            return $dispatcher;   
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

        $this->setShared('navbar', function() {
            $navbar = new \Anax\Navigation\CNavbar();
            $navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
            $navbar->setDI($this);
            return $navbar;
        });

        $this->set('fileContent', function() {
            $fc = new \Anax\Content\CFileContent();
            $fc->setBasePath(ANAX_APP_PATH . 'content/');
            return $fc;
        });

        $this->setShared('textFilter', function() {
            $filter = new \Anax\Content\CTextFilter();
            $filter->configure(ANAX_APP_PATH . 'config/text_filter.php');
            return $filter;
        });
    }
}

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

        $this->setShared('request',   '\Anax\Request\CRequest');
        $this->setShared('response',  '\Anax\Response\CResponse');
        $this->setShared('url',       '\Anax\CUrl');

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

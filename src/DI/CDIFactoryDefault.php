<?php
/**
 * Anax base class implementing Dependency Injection / Service Locator of the services used by the 
 * framework, using lazy loading.
 */

namespace Anax\DI;

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
            return $log;
        });

        $this->setShared('request',   '\Anax\Request\CRequest');
        $this->setShared('response',  '\Anax\Response\CResponse');
        $this->setShared('url',       '\Anax\CUrl');

        $this->setShared('session', function() {
            $session = new \Anax\Session\CSession();
            $session->name(preg_replace('/[^a-z\d]/i', '', __DIR__));
            $session->start();
            return $session;
        });

        $this->setShared('theme', function() {
            $themeEngine = new \Anax\ThemeEngine\CThemeBasic();
            $themeEngine->configure(ANAX_APP_PATH . 'config/theme.php') ;
            return $themeEngine;
        });
    }
}

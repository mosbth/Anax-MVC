<?php

namespace Anax\DI;

/**
 * My extended factory
 */
class CDIFactory extends CDIFactoryDefault
{
    public function __construct()
    {
        parent::__construct();

        // adds the db connection
        $this->setShared('db', function() {
            $db = new \Anax\Database\CDatabaseBasic();
            $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
            $db->connect();
            return $db;
        });

        // adds the userController
        $this->set('UsersController', function() {
            $controller = new \Anax\Users\UsersController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('CommentsController', function() {
            $controller = new \Anax\Comment\CommentsController();
            $controller->setDi($this);
            return $controller;
        });

        $this->setShared('ComplementaryController', function() {
            $controller = new \Anax\Complementary\ComplementaryController();
            $controller->setDi($this);
            return $controller;
        });


        $this->setShared('sflash', function() {
            $flash = new \Anax\Flash\CFlash();
            return $flash;
        });

        $this->setShared('lang', function() {
            $conf = require ANAX_APP_PATH . 'config/config_language.php';
            $lang = new \Anax\Language\Language($conf, false);
            $lang->setDi($this);
            return $lang;
        });

        $this->setShared('auth', function() {
            $conf = require ANAX_APP_PATH . 'config/auth_config.php';
            $auth = new \Anax\MVC\CAuthentication($conf);
            $auth->setDI($this);
            $auth->initialize();
            return $auth;
        });

        $this->setShared('QuestionsController', function() {
            $controller = new \Anax\Questions\QuestionsController();
            $controller->setDi($this);
            return $controller;
        });
  
        // adds CForm
        $this->set('form', '\Anax\HTMLForm\CForm');

        $this->set('time', '\kalkih\Time\CTime');

    }
}

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
        
        $this->setShared('lang', function() {
            $conf = require ANAX_APP_PATH . 'config/config_language.php';
            $lang = new \Anax\Language\Language($conf);
            return $lang;
        });

        // adds CForm
        $this->set('form', '\Mos\HTMLForm\CForm');

    }
}

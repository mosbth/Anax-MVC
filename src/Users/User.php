<?php

namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
    public $loggedIn;
    public $auth;
    public $username;
    public $id;

    public function __construct($auth = 0)  
    {
        $this->auth = $auth;
        $this->loggedIn = (bool)false;
        $this->username = "unkown";
    }
}

<?php

namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
    private $loggedIn;
    private $auth;
    private $username;

    /**
     * Login the user
     *
     * @param $username
     * @param $password
     *
     * @return bool
     */
    public function login($username, $password)
    {
        $hashed = hash_password($password);
        $this->db->select()
                ->from($this->getSource())
                ->where('username = ?')
                ->andWhere('password = ?');

        $this->db->execute([$username, $hashed]);

        if ($r = $this->db->fetchAll()) {
            $this->loggedIn = true;

            $this->auth = $r->userLevel;
            $this->username = $r->username;
            $this->session->set('user', true);
        } else {
            $this->loggedIn = false;
        }

        return $this->loggedIn;
    }
    /**
     * Returns whether the user is logged in
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->loggedIn;
    }

    /**
     * Unsets the user session
     *
     * @return void
     */
    public function logOut()
    {
        $this->session->remove('user');
    }
}

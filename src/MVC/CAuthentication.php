<?php

namespace Anax\MVC;

/**
* A simple class for authenticate a user
*
* @author Jonatan Karlsson <me@jonatankarlsson.se>
* @version 0.0.1
* @license MIT
*/
class CAuthentication extends \Anax\MVC\CDatabaseModel
{
    private $options;

    public function __construct($options) 
    {
        $this->options = $options;
    }

    /**
     * Initialize the session
     * @return void
     */
    public function initialize() 
    {
        // user is new on site
        if (is_null($this->session->get('user'))) {
            $user = new \Anax\Users\User($this->options['levels']['guest']);
            $this->session->set('user', $user);
        }
    }

    /**
     * Preforms a login
     * @param string $username 
     * @param string $password
     * @return whether the authentication went through or not
     */
    public function authenticate($username, $password)
    {
        $success = false;
        $this->initialize();
        // Gets the already existing user        
        $user = $this->session->get('user');

        $this->db->select()
                 ->from($this->options['database']['table'])
                 ->where('acronym = ?');

        if (!$this->db->execute([
            $username,
        ])) {
            throw new \Exception("Execute failed in authenticate");
        } 

        $r = $this->db->fetchAll();
        if (!is_null($r) && password_verify($password, $r[0]->password)) {        
            $user->auth = $r[0]->level;
            $user->id = $r[0]->id;
            $user->username = $r[0]->acronym;
            $user->loggedIn = true;

            // Unsets the session. 
            $this->session->remove('user');
            // adds the user again
            $this->session->set('user', $user);

            $success = true;
        }
    
        return $success;
    }
    
    /**
     * Returns whether the user is logged in
     * @throws Exception If user is null
     * @return bool
     */
    public function isAuthenticated()
    {     
        $user = $this->session->get('user');
        return $user->auth > 0 ? true : false;
    }

    /**
     * Unsets the user session
     * @return void
     */
    public function logOut()
    {        
        $this->session->remove('user');
        $this->initialize();
    }

    /**
     * Returns if user is admin
     * @throws Exception If user is null
     * @return bool
     */
    public function isAdmin() 
    {        
        $user = $this->session->get('user');
        return $user->auth >= $this->options['levels']['admin'];
    }

    /**
     * Returns if user has user-privileges or higher
     * @throws Exception If user is null
     * @return bool
     */
    public function isUser() 
    {        
        $user = $this->session->get('user');
        return $user->auth >= $this->options['levels']['user'];
       
    }

    /**
     * Returns if user is guest
     * @throws Exception If user is null
     * @return bool
     */
    public function isGuest() 
    {
        $user = $this->session->get('user');
        return $user->auth == $this->options['levels']['guest'];   
    }

    /**
     * Returns the authentic levels / value of the level
     * @return interger 
     */
    public function getAuth($level = null) 
    {
        if ($level == null) {
            return $this->session->get('user')->auth;
        } else {
            $levels = array_flip($this->options['levels']);
            return $levels[$level];
        }
    }
}

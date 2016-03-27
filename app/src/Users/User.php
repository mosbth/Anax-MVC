<?php
namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        // $this->db->setVerbose();
        $this->db->dropTableIfExists('user')->execute();

        $this->db->createTable(
            'user',
            [
               'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
               'acronym' => ['varchar(20)', 'unique', 'not null'],
               'email' => ['varchar(80)'],
               'name' => ['varchar(80)'],
               'points' => ['int'],
               'password' => ['varchar(255)'],
               'created' => ['datetime'],
               'updated' => ['datetime'],
               'deleted' => ['datetime'],
               'active' => ['datetime'],
            ]
        )->execute();
        $this->db->insert(
            'user',
            ['acronym', 'email', 'name', 'points', 'password', 'created', 'active']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            'admin',
            'admin@dbwebb.se',
            'Administrator',
            0,
            md5('admin'),
            $now,
            $now
        ]);

        $this->db->execute([
            'bob',
            'bob@dbwebb.se',
            'Byggare Bob',
            0,
            md5('bob'),
            $now,
            $now
        ]);

        $this->db->execute([
            'fnlive',
            'fn@live.se',
            'Fredrik Nilsson',
            0,
            md5('qwerty'),
            $now,
            $now
        ]);

    }

    public function find($id)
    {
        $user = parent::find($id);
        // Add Gravatar
        $gravatarSize = 80;
        $user->gravatar = $this->getGravatar($user->email, $gravatarSize);
        return $user;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function getGravatar($email, $s = 80, $d = 'monsterid', $r = 'g', $img = false, $atts = array())
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }

    public function loggedIn()
    {
        if (null!==$this->session->get('user_logged_in')) {
            // echo "You are logged in, {$this->session->get('user')}";
            return true;
        }
        // echo "You are logged out";
        return false;
    }
    /**
     * Get user with acronym.
     *
     * @return array $user
     */
    public function loggedInUser()
    {
        $userAcronym = $this->session->get('user_logged_in');
        $user = $this->query()
        ->where('acronym =' . "'$userAcronym'")
        ->execute()[0];
        return $user;
    }
}

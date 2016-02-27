<?php
/**
 * class for commenting. Model for comments.
 */
namespace Anax\CommentDb;

class CommentsInDb extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('commentsindb')->execute();

        $this->db->createTable(
            'commentsindb',
            [
               'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
               'flow' => ['varchar(80)'],
               'name' => ['varchar(80)'],
               'mail' => ['varchar(80)'],
               'web' => ['varchar(80)'],
               'content' => ['varchar(1024)'],
               'created' => ['datetime'],
            ]
        )->execute();
        $this->db->insert(
            'commentsindb',
            ['flow', 'name', 'mail', 'web', 'content', 'created']
        );

        $now = time();

        $this->db->execute([
            '',
            'Bo Jonsson Grip',
            'admin@dbwebb.se',
            'bosse.dbwebb.se',
            'Jag är Bo Jonsson Grip. Även kallad Bosse. ',
            $now
        ]);

        $this->db->execute([
            '',
            'Jane Doe',
            'doe@dbwebb.se',
            'jane.dbwebb.se',
            'Jag heter Jane. Jag jobbar på BTH. Vilken bra sida detta är.',
            $now
        ]);

    }
    private function humanTiming($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'år',
            2592000 => 'månader',
            604800 => 'veckor',
            86400 => 'dagar',
            3600 => 'timmar',
            60 => 'minuter',
            1 => 'sekunder'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' ':'');
        }
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
    private function getGravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
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

    /**
     * Find and return all comments within the page comment flow.
     *
     * @return array with all comments.
     */
    public function findAll()
    {
        // TODO: Filter flow?
        $comments = parent::findAll();

    //     $flow = $this->request->getRoute();
        foreach ($comments as $id => $comment) {
            $comment->since_time = $this->humanTiming($comment->created);
            $comment->gravatar = $this->getGravatar($comment->mail);
        }
        // echo __FILE__ . " : " . __LINE__ . "<br>";dump($comments);
        return $comments;
    }

    /**
     * Update a comment.
     *
     * @param array $comment with all details.
     * @param integer $id of comment to be updated
     *
     * @return void
     */
    // public function update($comment, $id)
    // {
    //     $comments = $this->session->get('comments', []);
    //     $comments[$id] = $comment;
    //     $this->session->set('comments', $comments);
    // }
}

<?php
/**
 * class for commenting
 */
namespace Loom\Comment;

class CommentsInSession extends \Phpmvc\Comment\CommentsInSession
{

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
        $result = array();
        // TODO: add flow tag through object instantiation instead?
        $flow = $this->request->getRoute();
        $comments = $this->session->get('comments', []);
        foreach ($comments as $id => $comment) {
            if ($comment['comment-flow']==$flow) {
                $comment['since-time'] = $this->humanTiming($comment['timestamp']);
                $comment['id'] = $id;
                $comment['gravatar'] = $this->getGravatar($comment['mail']);
                $result[] = $comment;
            }
        }
        return $result;
    }

    /**
     * Update a comment.
     *
     * @param array $comment with all details.
     * @param integer $id of comment to be updated
     *
     * @return void
     */
    public function update($comment, $id)
    {
        $comments = $this->session->get('comments', []);
        $comments[$id] = $comment;
        $this->session->set('comments', $comments);
    }

    /**
     * Delete a comment.
     *
     * @param $id of post to delete.
     *
     * @return void
     */
    public function delete($id)
    {
        $comments = $this->session->get('comments', []);
        unset($comments[$id]);
        $this->session->set('comments', $comments);
    }
}

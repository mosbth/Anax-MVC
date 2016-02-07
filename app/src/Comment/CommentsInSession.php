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
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            // TODO: Fix plural of swedish units, skip s below.
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' ':'');
        }
    }

    /**
     * Find and return all comments within the page comment flow.
     *
     * @return array with all comments.
     */
    public function findAll()
    {
        $result = array();
        $flow = $this->request->getRoute();
        $comments = $this->session->get('comments', []);
        foreach ($comments as $comment) {
            if ($comment['comment-flow']==$flow) {
                $comment['since-time'] = $this->humanTiming($comment['timestamp']);
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

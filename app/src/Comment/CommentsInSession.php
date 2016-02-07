<?php
/**
 * class for commenting
 */
namespace Loom\Comment;

class CommentsInSession extends \Phpmvc\Comment\CommentsInSession
{

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

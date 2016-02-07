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
     *
     * @return void
     */
    public function update($comment, $id)
    {
        $comments = $this->session->get('comments', []);
        $comments[$id] = $comment;
        $this->session->set('comments', $comments);
    }
}

<?php
/**
 * class for commenting
 */
namespace Loom\Comment;

class CommentsInSession extends \Phpmvc\Comment\CommentsInSession
{

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

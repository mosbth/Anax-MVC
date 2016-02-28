<?php
/**
 * class for commenting
 */
namespace Loom\Comment;

class CommentController extends \Phpmvc\Comment\CommentController
{

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {
        $comments = new \Loom\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->findAll();
        $this->views->add('comment/comments', [
            'comments' => $all,
        ]);
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'comment-flow'        => $this->request->getPost('comment-flow'),
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->add($comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Edit a comment.
     *
     * @return void
     */
    public function editAction()
    {
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        $id = $this->request->getGet('id');
        $theComments = $comments->findAll();
        $this->validate->check($id, ['int', 'range' => [0, count($theComments)]])
            or die("Wrong index. Comment does not exist!");
        $comment = $theComments[$id];
        $this->views->add('comment/edit', [
            'mail'      => $comment['mail'],
            'web'       => $comment['web'],
            'name'      => $comment['name'],
            'content'   => $comment['content'],
            'output'    => null,
            'id'        => $id,
            'commentFlow' => $comment['comment-flow'],
        ]);
    }

    /**
     * Update a comment.
     *
     * @return void
     */
    public function updateAction()
    {
        $isPosted = $this->request->getPost('doUpdate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'comment-flow'        => $this->request->getPost('comment-flow'),
        ];
        $id = $this->request->getPost('id');

        $comments = new \Loom\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->update($comment, $id);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Delete a comment.
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->request->getGet('id');
        $comments = new \Loom\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->delete($id);
        // TODO: Lägg till metod i CRequestBasic med referer url. Check if HTTP_REFERER exists also and escape also.
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}

<?php

namespace Anax\Comment;

class CommentsController extends \Anax\MVC\CDatabaseModel
{
    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->comments = new \Anax\Comment\Comments();
        $this->comments->setDI($this->di);
    }

    public function indexAction()
    {
        $this->theme->setTitle('View Comments');
        // If you somehow land here I'll
        // send you to see all the comments
        $this->dispatcher->forward([
            'controller' => 'comments',
            'action' => 'view',
        ]);
    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {
        $comments = $this->comments->findAll();

        $this->views->add('comment/comments',[
            'comments' => $comments,
        ]);
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction() {
        $this->theme->setTitle('');

        if ($this->request->getPost('doCreate')) {
                        
            $name = $this->request->getPost('content');
            $content = $this->request->getPost('content');
            $web = $this->request->getPost('web');
            $email = $this->request->getPost('mail');

            $this->db->insert(
                'comments',
                ['content', 'email', 'web', 'name']
            );

            $this->db->execute([
                $content,
                $email,
                $web,
                $name,
            ]);

            $url = $this->url->create('redovisning');
            $this->response->redirect($url);
        }
    }

    /**
     * Remove comment.
     *
     * @param $id
     *
     * @return void
     */
    public function removeAction($id)
    {
        if (!isset($id)) {
            throw new \Anax\Exception\NotFoundException();
        }
        $this->comments->delete($id);
        $url = $this->url->create($this->request->getPost('redirect'));
        $this->response->redirect($url);
    }

    /**
     * Edits a comment
     *
     * @param  $id
     *
     * @return void
     */
    public function editAction($id = null)
    {
        if (!isset($id)) {
           throw new \Anax\Exception\NotFoundException();
        } else {
            $this->theme->setTitle('Edit comment');

            $comment = $this->comments->find($id);
            $data = $comment->getProperties();

            //$this->session->set('data', $comment);

            $form = $this->form->create([], [
                'id' => [
                    'type'        => 'hidden',
                    'value'       => isset($data['id']) ? $data['id'] : null,
                    'required'    => false,
                ],
                'redirect' => [
                    'type'        => 'hidden',
                    'value'       => $this->url->create('redovisning'),
                    'required'    => true,
                ],
                'name' => [
                    'type'        => 'text',
                    'label'       => 'Name:',
                    'required'    => true,
                    'value'       => $data['name'],
                    'validation'  => ['not_empty'],
                ],
                'content' => [
                    'type'        => 'textarea',
                    'label'       => 'Comment:',
                    'required'    => true,
                    'value'       => $data['content'],
                    'validation'  => ['not_empty'],
                ],
                'email' => [
                    'type'        => 'email',
                    'label'       => 'Email:',
                    'required'    => true,
                    'value'       => $data['email'],
                    'validation'  => ['email_adress'],
                ],
                'web' => [
                    'type'        => 'url',
                    'label'       => 'Website:',
                    'required'    => false,
                    'value'       => $data['web'],
                ],
                'submit' => [
                    'type'      => 'submit',
                    'callback'  => function($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],
                'reset' => [
                    'type'      => 'reset',
                    'callback'  => function($form) {
                        $form->saveInSession = false;
                        return true;
                    }
                ],
            ]);
            
            $status = $form->check();

            if ($status === true) {
                // What to do if the form was submitted?
                $name = $_SESSION['form-save']['name']['value'];
                $content = $_SESSION['form-save']['content']['value'];
                $email = $_SESSION['form-save']['email']['value'];
                $web = $_SESSION['form-save']['web']['value'];
                $url = $_SESSION['form-save']['redirect']['value'];
                $id = $_SESSION['form-save']['id']['value'];

                $this->session->remove('form-save');
          
                $now = date("Y-m-d h:i:s");

                $comment->name = $name;
                $comment->content = $content;
                $comment->email = $email;
                $comment->web = $web;

                $comment->updated = $now;
                $comment->save();

                $this->response->redirect($url);
            }

            $this->views->add('grid/page', [
                'content' => $form->getHTML(),
            ]);
        }
    }

    /**
     * Resets the dummy data
     *
     * @return void
     */
    public function setupAction()
    {
        $this->theme->setTitle("Setup");

        $this->db->dropTableIfExists('comments')->execute();

        $this->db->createTable(
            'comments',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'content' => ['varchar(255)'],
                'email' => ['varchar(80)'],
                'web' => ['varchar(80)'],
                'name' => ['varchar(20)', 'not null'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
            'comments',
            ['content', 'email', 'web', 'name', 'created', 'active']
        );

        $now = date("Y-m-d h:i:s");

        for($i = 0; $i < 2; $i++) {
            $this->db->execute([
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'test@test.com',
                'http://www.test.com',
                'TestUser',
                $now,
                $now,
            ]);
        }

        $this->views->add('grid/page',[
            'content' => '<h3>Setup n\' stuff</h3><p>The database has be reseted!</p>'
        ]);
    }
}

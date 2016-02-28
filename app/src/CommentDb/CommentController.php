<?php
/**
 * class for commenting
 */
namespace Anax\CommentDb;

class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
    \Anax\MVC\TRedirectHelpers;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->comments = new \Anax\CommentDb\CommentsInDb();
        $this->comments->setDI($this->di);
    }

    /**
     * Setup initial table for users.
     *
     * @return void
     */
    public function setupAction()
    {
        $this->comments->init();
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }
    /**
     * List all comments for all flows.
     *
     * @return void
     */
    public function listAction()
    {
        $all = $this->comments->findAll();
        $flow = $this->request->getRoute();
        $link = $this->url->create('comment/add/' . $flow);
        $this->theme->setTitle("List all users");
        $this->views->add('comment/commentsdb', [
            'comments' => $all,
            'comment_link' => $link,
        ]);
    }
    /**
     * View all comments in page flow.
     *
     * @return void
     */
    public function viewAction()
    {
        $flow = $this->request->getRoute();
        $all = $this->comments->findFlow($flow);
        $link = $this->url->create('comment/add/' . $flow);
        $this->views->add('comment/commentsdb', [
            'comments' => $all,
            'comment_link' => $link,
        ]);
    }

    /**
     * Add new comment.
     *
     * @param string $route to page for comment flow.
     *
     * @return void
     */
    public function addAction($route = null)
    {
        // Route parts are are in argument array. Glue them together again.
        $route = implode("/", func_get_args());
        // TODO: Need to sweep session? How?
        // Set saveInSession = false instead.
        $this->di->session(); // Will load the session service which also starts the session
        $form = $this->createAddCommentForm($route);
        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
        $this->di->theme->setTitle("Add user");
        $this->di->views->add('default/page', [
            'title' => "Add Comment",
            'content' => $form->getHTML()
        ]);
    }
    private function createAddCommentForm($route)
    {
        return $this->di->form->create([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Comment:',
                'required'    => false,
                // 'validation'  => ['not_empty'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Name:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'web' => [
                'type'        => 'text',
                'label'       => 'Homepage:',
                'required'    => false,
                // 'validation'  => ['not_empty'],
            ],
            'mail' => [
                'type'        => 'text',
                'required'    => true,
                'label'       => 'Email:',
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'flow' => [
                'type'        => 'hidden',
                'value'       => $route,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitAddComment'],
            ],
            'submit-fail' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitFailAddComment'],
            ],
        ]);
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitAddComment($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");
        // Save comment to database
        $now = time();
        $this->comments->save([
            'flow' => $form->Value('flow'),
            'content' => $form->Value('content'),
            'name' => $form->Value('name'),
            'web' => $form->Value('web'),
            'mail' => $form->Value('mail'),
            'created' => $now,
        ]);

        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('mail') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailAddComment($form)
    {
        // TODO: Remove this?
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }
    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess($form)
    {
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        // Redirect to page posted from.
        $this->redirectTo($form->Value('flow'));
    }
    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail($form)
    {
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        // Redirect to comment form.
        $this->redirectTo();
    }

    /**
     * Edit comment.
     *
     * @param string $acronym of user to update.
     *
     * @return void
     */
    public function editAction($id = null)
    {
        $this->di->session(); // Will load the session service which also starts the session
        $all = $this->comments->query()
            ->where("id = '$id'")
            ->execute();
        if (count($all)!=1) {
            die("Comment with id $id not found.");
        }
        $comment = $this->comments->find($id);
        $form = $this->createEditCommentForm($comment);
        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
        $this->di->theme->setTitle("Edit comment");
        $this->di->views->add('default/page', [
            'title' => "Edit comment",
            'content' => $form->getHTML()
        ]);
    }
    private function createEditCommentForm($comment = null)
    {
        return $this->di->form->create([], [
            'content' => [
                'type'        => 'textarea',
                'value'       => $comment->content,
                'label'       => 'Comment:',
                'required'    => false,
                // 'validation'  => ['not_empty'],
            ],
            'name' => [
                'type'        => 'text',
                'value'       => $comment->name,
                'label'       => 'Name of person:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'web' => [
                'type'        => 'text',
                'value'       => $comment->web,
                'label'       => 'Homepage:',
                'required'    => false,
                // 'validation'  => ['not_empty'],
            ],
            'mail' => [
                'type'        => 'text',
                'value'       => $comment->mail,
                'required'    => true,
                'label'       => 'Email:',
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'flow' => [
                'type'        => 'hidden',
                'value'       => $comment->flow,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitUpdateComment'],
            ],
            'submit-fail' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitFailUpdateComment'],
            ],
        ]);
    }
    public function callbackSubmitUpdateComment($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");
        // Save user data to database
        $this->comments->save([
            'content' => $form->Value('content'),
            'name' => $form->Value('name'),
            'web' => $form->Value('web'),
            'mail' => $form->Value('mail'),
        ]);

        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('mail') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailUpdateComment($form)
    {
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Delete a comment.
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->comments->delete($id);
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }
}

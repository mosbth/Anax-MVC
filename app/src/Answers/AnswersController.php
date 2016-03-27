<?php

namespace Anax\Answers;

/**
 * A controller for "Answers".
 *
 */
class AnswersController implements \Anax\DI\IInjectionAware
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
        $this->answers = new \Anax\Answers\CAnswers();
        $this->answers->setDI($this->di);
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        $this->questions = new \Anax\Questions\CQuestions();
        $this->questions->setDI($this->di);
    }

    /**
     * Setup initial table for users.
     *
     * @return void
     */
    public function setupAction()
    {
        // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump("Setup Answers!");
        $this->answers->init();
        // $this->redirectTo('answers/');
    }

    /**
     * Accept answer to question
     *
     * @param integer $id to answer.
     *
     * @return void
     */
    public function acceptAction($id)
    {
        $answer = $this->answers->find($id);
        $user = $this->users->loggedInUser();
        $question = $this->questions->find($answer->q_id);
        if ($user->id == $question->user_id &&
            !$question->accepted_answer) {
            // Update answer entry in db.
            $this->answers->update([
                'id'        => $answer->id,
                'accepted'  => true,
            ]);
            $this->questions->update([
                'id'        => $question->id,
                'accepted_answer'  => true,
            ]);
        }
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }

    /**
     * Add new question
     *
     * @param integer $question_id for question being answered.
     *
     * @return void
     */
    public function addAction($question_id = null)
    {
        if ($this->users->loggedIn()) {
            $this->di->session(); // Will load the session service which also starts the session
            $form = $this->createAddCommentForm($question_id);
            $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
            // $this->di->theme->setTitle("Add user");
            $this->di->views->add('default/page', [
                'title' => "Svara på fråga $question_id",
                'content' => $form->getHTML()
            ]);
        } else {
            $this->redirectTo($this->url->create('users/login'));
        }
    }
    private function createAddCommentForm($question_id)
    {
        return $this->di->form->create([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Svar:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'question_id' => [
                'type'        => 'hidden',
                'value'       => $question_id,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitAddAnswer'],
            ],
            // 'submit-fail' => [
            //     'type'      => 'submit',
            //     'callback'  => [$this, 'callbackSubmitFailAddComment'],
            // ],
        ]);
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitAddAnswer($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");

        // Save comment to database
        $now = time();
        $this->answers->save([
            'content'   => $form->Value('content'),
            'user_id'   => $this->users->loggedInUser()->id,
            'q_id'      => $form->Value('question_id'),
            'vote'      => 0,
            'created'   => $now,
            'accepted'  => false,
        ]);
        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('mail') . "</b></p>");
        $form->saveInSession = false;
        $this->session->set('ShowFormCorA', '');
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
        // Redirect to page displaying the new question.
        // $this->redirectTo($this->url->create('questions/single/' . $this->questions->id));
        // $this->redirectTo($this->url->create('questions/single/' . $this->questions->id));
        $this->redirectTo();
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
}

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
     * List all answers.
     *
     * @return void
     */
    public function listAction($question_id = null)
    {
        // $question_id = 2;
        if ($question_id) {
            // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump('not null');
            // make a query instead.
            // $all = $this->answers->find($question_id);
            // $query = "q_id IS $question_id";
            $all = $this->answers->query()
                ->where("q_id = $question_id")
                ->execute();
        } else {
            // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump('Is null');
            $all = $this->answers->findAll();
            // returns array
        }
        // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump($question_id);
        // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump($all[0]->content);
        // echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump(sizeof($all));
        $nrOfAnswers = sizeof($all);
        foreach ($all as $answer) {
            $this->views->add('answers/single', [
                'answer' => $answer,
            ]);
            // Add dispatcher or view for user card.
            // add dispatcher for comments listing all comments to answer.
        }
    }

    /**
     * Add new question
     *
     * @param string $route to page for comment flow.
     *
     * @return void
     */
    public function addAction($question_id = null)
    {
        // TODO: Need to sweep session? How?
        // Set saveInSession = false instead.
        $this->di->session(); // Will load the session service which also starts the session
        $form = $this->createAddCommentForm($question_id);
        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
        // $this->di->theme->setTitle("Add user");
        $this->di->views->add('default/page', [
            'title' => "Svara på fråga $question_id",
            'content' => $form->getHTML()
        ]);
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
            // TODO: Remove all submit-fail later.
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
    public function callbackSubmitAddAnswer($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");

        // Save comment to database
        $now = time();
        $this->answers->save([
            'content'   => $form->Value('content'),
            // TODO: Fix real user
            'user_id'   => 3,
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

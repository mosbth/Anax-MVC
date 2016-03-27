<?php

namespace Anax\Questions;

/**
 * A controller for "Questions".
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
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
        $this->questions = new \Anax\Questions\CQuestions();
        $this->questions->setDI($this->di);
        $this->tags = new \Anax\Tags\CTags();
        $this->tags->setDI($this->di);
        $this->tags2Questions = new \Anax\Tags\CTags2Question();
        $this->tags2Questions->setDI($this->di);
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        $this->answers = new \Anax\Answers\CAnswers();
        $this->answers->setDI($this->di);
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
        $this->questions->init();
        // $this->redirectTo('questions/');
    }

    /**
    * List recent questions.
     *
     * @return void
     */
    public function recentquestionsAction($count)
    {
        $this->views->add('default/page', [
            'title'     => 'Senaste frågorna',
            'content'     => 'Här hittar du de senast ställda frågorna',
        ]);
        $all = $this->questions->findRecent($count);
        foreach ($all as $question) {
            // TODO: Add more stuff into view? User, tags, ?
            // or shorten down and place in grid-box?
            // Add headline in view, "Senaste frågorna", or in index.php
            $this->views->add('questions/short', [
                'title'     => 'Senaste frågorna',
                'question'  => $question->getProperties(),
            ]);
        }
    }

    /**
     * List all questions.
     *
     * @return void
     */
    public function listAction($what = null, $id = null)
    {
        // Collect all questions in $questions array.
        $questions = array();
        switch ($what) {
            case 'tags':
                $tag = $this->tags->find($id)->getProperties();
                $title = "Kategori {$tag['name']}";
                $content = "Frågor i kategori {$tag['name']}";
                $qids = $this->tags2Questions->query()
                            ->where("tag_id = $id")
                            ->execute();
                foreach ($qids as $qid) {
                    $question = $this->questions->find($qid->question_id);
                    $questions[] = $question->getProperties();
                }
                break;
            case 'answers':
                $user = $this->users->query()
                ->where('acronym = ' . "'$id'")
                ->execute()[0];
                $answers = $this->answers->query()
                ->where('user_id = ' . "'$user->id'")
                ->execute();
                foreach ($answers as $answer) {
                    $questions[] =  $this->questions->query()
                    ->where('id = ' . "'$answer->q_id'")
                    ->execute()[0]->getProperties();
                }
                // Remove duplicate questions. E.g. same user answered multiple times on same question.
                $questions = array_unique($questions, SORT_REGULAR);
                $title = "Frågor svarade av {$user->name}";
                $content = "Frågor besvarade av {$user->name}";
                break;
            case 'questions':
                $user = $this->users->query()
                ->where('acronym = ' . "'$id'")
                ->execute()[0];
                $all = $this->questions->query()
                ->where('user_id = ' . "'$user->id'")
                ->execute();
                foreach ($all as $question) {
                    $questions[] = $question->getProperties();
                }
                $title = "Frågor från {$user->name}";
                $content = "Frågor ställda av {$user->name}";
                break;

            default:
                $title = "Alla frågor";
                $content = "Visa alla frågor";
                $all = $this->questions->findAll();
                foreach ($all as $question) {
                    $questions[] = $question->getProperties();
                }
                break;
        }
        // Display questions with tags and user.
        $this->theme->setTitle("Frågor");
        $this->views->add('default/page', [
            'title' => $title,
            'content' => $content,
        ]);
        foreach ($questions as $question) {
            $allTagsId = $this->tags2Questions->query()
            ->where('question_id = ' . "'{$question['id']}'")
            ->execute();

            // TODO: is below with $allTags needed?
            $allTags = array();
            foreach ($allTagsId as $tid) {
                $allTags[] = $this->tags->find($tid->tag_id)->getProperties();
            }
            $this->views->add('questions/short', [
                'question' => $question,
            ]);
            // Add view with the questions tags
            $this->dispatcher->forward([
                'controller' => 'tags',
                'action'     => 'question',
                'params'    => [$question['id'],  ],
            ]);
            // Add view with users card
            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'card',
                'params'    => [
                    $question['user_id'],
                ],
            ]);
        }
    }

    public function acceptAnswer($answer, $question)
    {
        if ($this->users->loggedIn() &&
            ($this->users->loggedInUser()->id == $question->user_id) &&
            !$answer->accepted &&
            !$question->accepted_answer) {
            $acceptUrl['href'] = $this->url->create('answers/accept/' . $answer->id);
            $acceptUrl['text'] = '| Acceptera svar';
            $this->views->add('default/link', [
                'link' => $acceptUrl,
            ]);
        }
    }

    /**
     * Route to enable showing of comment or answer form
     * This is used when displaying single question
     *
     * @param int $form answer, comment_question, comment_answer
     *
     * @return void
     */
    public function showformAction($form)
    {
        $this->session->set('ShowFormCorA', $form);
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }

    /**
     * Route to show link to or comment or answer form
     *
     * @param   string $form {answer, comment_question, comment_answer}
     *          string $controller to handle form
     *          int $id of question or answer
     *          string $linkText to display on linkText
     *          string 'q' or 'a' on comment on question or comment on answer
     *
     * @return void
     */
    private function showFormCommentOrAnswer($form, $controller, $id, $linkText, $qora = null)
    {
        // Add view to comment question
        if ($this->session->get('ShowFormCorA')==$form) {
                $this->dispatcher->forward([
                    'controller' => $controller,
                    'action'     => 'add',
                    'params'    => [$id, $qora, ],
                ]);
        } else {
            if ($this->users->loggedIn()) {
                $route = "questions/showform/$form";
            } else {
                $route = 'users/login';
            }
            $commentFormUrl['href'] = $this->url->create($route);
            $commentFormUrl['text'] = $linkText;
            $this->views->add('default/link', [
                'link' => $commentFormUrl,
            ]);
        }
    }
    /**
     * List single question
     *
     * @param int $id of question to display
     *
     * @return void
     */
    public function singleAction($id = null)
    {
        $question = $this->questions->query()
        ->where('id = ' . "'$id'")
        ->execute()[0];

        // Add view with the question.
        $this->theme->setTitle("$question->headline");
        $this->views->add('questions/single', [
            'question' => $question,
        ]);

        // Add view with the questions tags
        $this->dispatcher->forward([
            'controller' => 'tags',
            'action'     => 'question',
            'params'    => [$question->id,  ],
        ]);

        // Add view with user card.
        $humanTime = \Anax\CommentDb\CommentsInDb::humanTiming($question->created);
        $text = "Frågade för $humanTime sedan";
        $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'card',
            'params'    => [$question->user_id, 'q', $text, ],
        ]);

        // Add view to comment question, form visible when logged in and clicking link.
        $this->showFormCommentOrAnswer('comment_question', 'comment', $question->id, 'Kommentera ', 'q');

        // Add view to answer question, form visible when logged in and clicking link.
        $this->showFormCommentOrAnswer('answer', 'answers', $question->id, '| Besvara ');

        // Add view with Comments to question
        $allComments = $this->comments->query()
            ->where("q_or_a = 'q'")
            ->andwhere("q_or_a_id = $id")
            ->execute();
        $nrOfComments = sizeof($allComments);
        $commentsListData = array();
        for ($j=0; $j < $nrOfComments; $j++) {
            $commentsListData[$j]['comment'] = $allComments[$j]->getProperties();
            // Get user of comment
            $user = $this->users->find($allComments[$j]->user_id);
            $commentsListData[$j]['user'] = $user->getProperties();
        }
        $this->views->add('questions/comments', [
            'comments' => $commentsListData,
        ]);

        // Display all answers and comments to each answer.
        // Display all answers to question.
        $allAnswers = $this->answers->query()
            ->where("q_id = $question->id")
            ->execute();
        $this->views->add('questions/answersheading', [
            'title' => sizeof($allAnswers) . " svar",
        ]);
        foreach ($allAnswers as $answer) {
            $user = $this->users->find($answer->user_id);
            // Add view to display all answer.
            $this->views->add('questions/answer', [
                'answer' => $answer->getProperties(),
                'user'  => $user->getProperties(),
            ]);
            // Display link or comment form for commenting the answer
            $this->showFormCommentOrAnswer(
                'comment_answer_' . $answer->id,
                'comment',
                $answer->id,
                'Kommentera ',
                'a'
            );
            $this->acceptAnswer($answer, $question);

            // Get all comments to answer
            $allComments = $this->comments->query()
                ->where("q_or_a = 'a'")
                ->andwhere("q_or_a_id = $answer->id")
                ->execute();
            $commentsListData = array();
            foreach ($allComments as $comment) {
                $user = $this->users->find($comment->user_id);
                $commentsListData[] = [
                    'comment' => $comment->getProperties(),
                    'user' => $user->getProperties(),
                ];
            }
            $this->views->add('questions/comments', [
                'comments' => $commentsListData,
            ]);
        }

        $this->views->add('default/page', [
            'content'   => ' ',
            'links' => [
                [
                    'href' => $this->url->create('questions/ask'),
                    'text' => "Fråga en fråga",
                ],
            ],
        ]);
    }

    /**
     * Ask new question
     *
     * @param string $route to page for comment flow.
     *
     * @return void
     */
    public function askAction()
    {
        if ($this->users->loggedIn()) {
            $this->di->session(); // Will load the session service which also starts the session
            $form = $this->createAddQuestionForm();
            $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
            $this->di->theme->setTitle("Fråga");
            $this->di->views->add('default/page', [
                'title' => "Ställ en fråga",
                'content' => $form->getHTML()
            ]);
        } else {
            $this->redirectTo($this->url->create('users/login'));
        }
    }
    private function createAddQuestionForm()
    {
        $tags = $this->tags->findAll();
        foreach ($tags as $tag) {
            $tagArray[] = $tag->name;
        }
        return $this->di->form->create([], [
            'headline' => [
                'type'        => 'text',
                'label'       => 'Rubrik:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Fråga:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            "tags" => [
                "type"        => "checkbox-multiple",
                'label'       => 'Kategorier:',
                "values"      => $tagArray,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitAddQuestion'],
            ],
            // 'submit-fail' => [
            //     'type'      => 'submit',
            //     'callback'  => [$this, 'callbackSubmitFailAddQuestion'],
            // ],
        ]);
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitAddQuestion($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");

        // Save comment to database
        $now = time();
        $this->questions->save([
            'headline' => $form->Value('headline'),
            'content' => $form->Value('content'),
            'user_id' => $this->users->loggedInUser()->id,
            'vote' => 0,
            'created' => $now,
        ]);
        // Pull out tags and store them in tags2question model
        $qid = $this->questions->id;
        $tags = $form->Value('tags');
        foreach ($tags as $tag) {
            $tag_id = $this->tags->findTag($tag)->getProperties()['id'];
            unset($this->tags2Questions->id);
            $this->tags2Questions->save([
                'tag_id' => $tag_id,
                'question_id' => $qid,
            ]);
        }

        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('mail') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailAddQuestion($form)
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
        $this->redirectTo($this->url->create('questions/single/' . $this->questions->id));
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

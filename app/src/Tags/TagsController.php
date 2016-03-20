<?php

namespace Anax\Tags;

/**
 * A controller for "Questions".
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
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
        $this->tags = new CTags();
        $this->tags->setDI($this->di);
        $this->tags2Questions = new CTags2Question();
        $this->tags2Questions->setDI($this->di);
    }

    /**
     * Setup initial table for users.
     *
     * @return void
     */
    public function setupAction()
    {
        echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump("Setup Questions!");
        $this->tags->init();
        $this->tags2Questions->init();
        // $this->redirectTo('questions/');
    }
    /**
     * List all questions.
     *
     * @return void
     */
    public function listAction()
    {
        $all = $this->tags->findAll();

        $this->theme->setTitle("Kategorier");
        $this->views->add('tags/list-all', [
            'tags' => $all,
            'title' => "Visa alla Kategorier",
        ]);
    }


    /**
     * List  questions related to one tag
     *
     * @param int $id of tag for questions to display
     *
     * @return void
     */
     // Use route question/tag/id instead
    // public function singleAction($id = null)
    // {
    //     // TODO: Add support for tag-name as parameter.
    //     // or call this only with name, not id.
    //     $this->questions = new \Anax\Questions\CQuestions();
    //     $this->questions->setDI($this->di);
    //
    //     $tag = $this->tags->find($id);
    //     $tagName = $tag->name;
    //
    //     $allQuestionsId = $this->tags2Questions->query()
    //     ->where('id = ' . "'$id'")
    //     ->execute();
    //
    //     foreach ($allQuestionsId as $qid) {
    //         $allQuestions[] = $this->questions->find($qid->id)->getProperties();
    //     }
    //
    //     $this->theme->setTitle("Kategori $tagName");
    //     $this->views->add('questions/list-all', [
    //         'questions' => $allQuestions,
    //         'title' => "Kategori $tagName",
    //     ]);
    // }

    /**
     * List tags related to one question
     *
     * @param int $id of question for tags to display
     *
     * @return void
     */
    public function questionAction($id = null)
    {
        $allTagsId = $this->tags2Questions->query()
        ->where('question_id = ' . "'$id'")
        ->execute();
        $allTags = array();
        foreach ($allTagsId as $tid) {
            $allTags[] = $this->tags->find($tid->tag_id)->getProperties();
        }

        $this->views->add('tags/list', [
            'tags' => $allTags,
        ]);
    }
}

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

    /**
     * List most popular tags
     *
     * @param int $count number of tags to list
     *
     * @return void
     */
    public function mostpopularAction($count = 3)
    {
        $tags = $this->tags2Questions->mostPopularTags($count);
        $allTags = array();
        foreach ($tags as $tag) {
            $allTags[] = $this->tags->find($tag->tag_id)->getProperties();
        }
        $this->views->add('default/page', [
            'title'     => 'Mest använda kategorier',
            'content'     => '',
        ]);
        $this->views->add('tags/list', [
            'tags' => $allTags,
        ]);
    }
}

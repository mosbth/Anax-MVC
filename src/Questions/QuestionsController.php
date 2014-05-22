<?php

namespace Anax\Questions;

/**
*
*/
class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);
    }

    public function indexAction()
    {
        $this->theme->setTitle('Alla frågor');

        $quests = $this->questions->getFront();
        $this->views->add('stack/sidebar', [
            'content' => $quests,
        ]);
    }
    public function titleAction($id, $slug)
    {
        $this->theme->setTitle('Frågor');
        $this->views->add('grid/page', [
            'content' => 'Samtliga frågor här sen. Sorterade efter senast skrivna',
        ]);
    }

    public function askAction()
    {
        $this->theme->setTitle('Ställ din fråga');
        $this->views->add('grid/page', [
            'content' => 'Frågeformulär här sen',
        ]);
    }

    public function tagsAction($tag = null)
    {
        if ($tag === null) {
            $this->theme->setTitle('Tagggar');
            $this->views->add('grid/page', [
                'content' => 'Visa alla tags sorterade efter mest',
            ]);
        } else {
            $this->theme->setTitle("Senaste '{$tag}' frågorna");
            $this->views->add('grid/page', [
                'content' => 'Visa alla inlägg med $tag sorterade efter senaste',
            ]);
        }
    }

    private function createSlug($str)
    {
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        return $clean;
    }

    public function setupAction()
    {
        $this->theme->setTitle('Setup');

        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable(
            'question',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'user_id' => ['integer', 'not null'],
                'title' => ['varchar(100)'],
                'question' => ['varchar(255)', 'not null'],
                'slug'    => ['varchar(100)', 'not null'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
            'question',
            ['user_id', 'title', 'slug', 'question', 'created']
        );

        $now = date("Y-m-d h:i:s");
        for ($i=0; $i < 10; $i++) {
            $title = "Nice title to question " . ($i + 1);
            $slug = $this->createSlug($title);
            $this->db->execute([
                1,
                $title,
                $slug,
                'Nice question',
                $now
            ]);
        }


        $this->views->add('grid/page', [
            'content' => '<h3>Setup n\' stuff</h3><p>The database has be reseted!</p>'
        ]);
    }
}

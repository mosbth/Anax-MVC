<?php
namespace Anax\Tags;
 
/* === A Controller för tags === 
1. Initialize
2. List all  Tags
3. List one tag
===============================*/

class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
		\Anax\MVC\TRedirectHelpers;
	
	public $tags;
	
/* === 1. INITIALIZE ==== */
	public function initialize()
	{
		$this->tags = new \Anax\Tags\Tag();
		$this->tags->setDI($this->di);
        
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDI($this->di);
	}

/* === 2. LIST ALL TAGS === */
	public function listAction()
	{
        $sql = "SELECT * FROM kmom07_tag ORDER BY tag ASC";
        $this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		$alltags = $this->db->fetchAll();
		
		$this->theme->setTitle("Taggar");
		$this->views->add('tags/list-all', [
			'tags' => $alltags,
			'title' => "Taggar",
		]);
	}
	
/* === 3. LIST ONE TAG ==== */
	public function idAction($id = null)
	{
        if(!isset($id)){
            die("Missing id");
        }
		$tag = $this->tags->find($id);
		$tagName = $tag->tag;
		
		$questions = $this->questions->getQuestionsWithTag($tagName);
        
        foreach($questions as $question){
            $question->countAnswer = $this->questions->countAnswers($question->id);
            $question->timecount = $this->questions->getTimestampFromQuestion($question->id);
        }
		
		$this->theme->setTitle("Visa tag");
		$this->views->add('tags/view', [
			'tag' => $tag,
			'questions' => $questions
		]);
	}//END OF LIST ONE TAG
    
}
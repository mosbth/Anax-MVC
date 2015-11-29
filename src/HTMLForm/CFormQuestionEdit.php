<?php
namespace Anax\HTMLForm;
use \Anax\Request;

/* === QUESTION FORM ====*/

class CFormQuestionEdit extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;
    
    public $questions = null;
    public $tags;
    public $userId;

	
/* === CONSTRUCTOR ==== */
	public function __construct($questions, $tags, $userId, $tags1, $questionTitle, $questionText, $acronym, $id)
	{
		
		$this->questions = $questions;
		$this->userId = $userId;
        $this->acronym = $acronym;
        $this->questionId = $id;
        $this->questionTitle = $questionTitle;
        $this->questionText = $questionText;
        $this->tags = $tags;
        $this->tags1 = $tags1;
        
    
		
		parent::__construct([], [
			'title' => [
				'type'        => 'text',
                'class'        => 'form-control',
                'autofocus'     => true,
				'label'       => 'Rubrik:',
				'required'    => true,
				'validation'  => ['not_empty'],
                'value'         => $questionTitle,
			],
			'text' => [
				'type'        => 'textarea',
                'class'        => 'form-control',
				'label'       => 'Text:',
				'required'    => true,
                'value'         => $questionText,
			],
			'tags' => [
				'type'        => 'text',
                'placeholder'   => 'Tags',
                'data-role'     => 'tagsinput',
                'class'        => 'form-control tagsinput',
				'label'       => 'Taggar: (komma-tecken mellan varje tagg) ',
                'value'         => $tags1,
			],
            
			'submit' => [
				'type'      => 'submit',
                'class'     => 'btn',
                'value'     => 'Skicka',
				'callback'  => [$this, 'callbackSubmit'],
			],
		]);
	}
	
/* === Customise the check() method.=== */
	public function check($callIfSuccess = null, $callIfFail = null)
	{
		return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
	}
	
	
/* ==== Callback for submit-button. ==== */
	public function callbackSubmit()
	{
		$now = gmdate('Y-m-d H:i:s');
		$this->questions->save([
			'userId' => $this->userId,
			'questiontext' => $this->Value('text'),
			'questionTitle' => $this->Value('title'),
            'userAcronym' => $this->acronym,
			'updated' => $now
		]);
		

        $this->tags->saveEditTag($this->questionId, $this->Value('tags'));
		
		return true;
	}
	
	
/* === Callback What to do if the form was submitted? ====*/
	public function callbackSuccess()
	{	
		$this->redirect('questions/list/timestamp', 'Frågan är uppdaterad', 'success');
	}
	
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->redirect('questions/id/' . $this->questionId, 'Det gick inte att uppdatera frågan', 'error');
	}
}
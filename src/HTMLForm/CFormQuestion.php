<?php
namespace Anax\HTMLForm;

/* === QUESTION FORM ====*/

class CFormQuestion extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;
	
/* === CONSTRUCTOR ==== */
	public function __construct($questions, $activities, $userId, $tags, $acronym, $question=null)
	{
		
		$this->questions = $questions;
        $this->activities = $activities;
		$this->userId = $userId;
        $this->acronym = $acronym;
		$this->tags = $tags;
		
		parent::__construct([], [
			'title' => [
				'type'        => 'text',
                'class'        => 'form-control',
                'autofocus'     => true,
				'label'       => 'Rubrik:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'text' => [
				'type'        => 'textarea',
                'class'        => 'form-control',
				'label'       => 'Text:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'tags' => [
				'type'        => 'text',
                'class'        => 'form-control tagsinput',
                'data-role'     => 'tagsinput',
				'label'       => 'Taggar:(komma-tecken mellan varje tagg)',
				'required'    => true,
				'validation'  => ['not_empty'],

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
			'timestamp' => $now
		]);
        
        $questionId = $this->questions->getlastInsertId();
        $this->tags->saveTag($questionId, $this->Value('tags'));
        $this->activities->questionPoints($this->userId);
		

		return true;
	}
	
	
/* === Callback What to do if the form was submitted? ====*/
	public function callbackSuccess()
	{	
		$this->redirectTo('questions/list/timestamp');
	}
	
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
		$this->redirectTo();
	}
}
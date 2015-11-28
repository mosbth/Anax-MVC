<?php
namespace Anax\HTMLForm;

/* === FORM TO ANSWER QUESTION ==== */

class CFormAnswer extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;

	
	
/* === CONSTRUCTOR === */
	public function __construct($answers, $activities, $userId, $question, $acronym, $answer=null)
	{
		$this->answers = $answers;
        $this->activities = $activities;
		$this->userId = $userId;
		$this->question = $question;
		$this->acronym = $acronym;
		
		parent::__construct([], [
			'text' => [
				'type'        => 'textarea',
                'class'        => 'form-control',
				'label'       => 'Svar:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($answer) ? $answer->text : '',
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
	
	
/* ===== Callback for submit-button. ==== */
	public function callbackSubmit()
	{
		$now = gmdate('Y-m-d H:i:s');
		
		$this->answers->save([
			'questionId' => $this->question->id,
			'userId' => $this->userId,
			'answer' => $this->Value('text'),
			'timestamp' => $now,
			'userAcronym' => $this->acronym
		]);
        
        $givepoints = $this->activities->answerPoints($this->userId);
	
		return true;
	}
	
	
/* ==== Callback What to do if the form was submitted? ==== */
	public function callbackSuccess()
	{	
		$this->redirectTo('questions/id/' . $this->question->id);

	}
	
	
	
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
		$this->redirectTo();
	}
}
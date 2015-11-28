<?php
namespace Anax\HTMLForm;

/* ==== FORM TO COMMENT ==== */
class CFormComment extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;
    

    
/* === CONSTRUCTOR ==== */
	public function __construct($comments, $activities, $userId, $id, $acronym, $type, $question, $comment=null)
	{
		$this->comments = $comments;
        $this->activities = $activities;
		$this->userId = $userId;
		$this->id = $id;
		$this->acronym = $acronym;
		$this->type = $type;
		$this->question = $question;
        
		parent::__construct([], [
			'text' => [
				'type'        => 'textarea',
                'class'        => 'form-control',
				'label'       => 'Kommentar:',
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
		$this->comments->save([
			'commentType' => $this->type,
			'questionId' => $this->id,
			'userId' => $this->userId,
			'commentText' =>$this->Value('text'),
			'timestamp' => $now, 
			'userAcronym' => $this->acronym
		]);
        
        $givepoints = $this->activities->commentPoints($this->userId);
        
		return true;
	}
    
/* === Callback What to do if the form was submitted? ====*/
	public function callbackSuccess()
	{	
		$this->redirect('/gnar2/kmom06/Anax-MVC/webroot/questions/list/timestamp' , 'Kommentar inlagd', 'success');
	}
    
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->redirect('', 'Det gick inte att lägga till kommentaren, försök igen', 'error');
	}
}
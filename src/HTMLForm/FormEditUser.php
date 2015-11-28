<?php
namespace Anax\HTMLForm;

/* ==== CLASS TO CREATE OR EDIT A USER =====*/

class FormEditUser extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;
	
	public $users=null;
    
	
/* ==== CONSTRUCTOR ==== */
	public function __construct($users, $user=null, $userId)
	{
		
		$this->users = $users;
        $this->user = $user;
        $this->userId = $userId;

		
		parent::__construct([], [
			'name' => [
				'type'        => 'text',
                'class'       => 'form-control',
				'label'       => 'Namn:',
                'autofocus'   => true,
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => isset($user) ? $user->name : '',
			],
			'email' => [
				'type'        => 'text',
                'class'        => 'form-control',
				'label'       => 'E-post:',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
				'value'		  => isset($user) ? $user->email : '',
			],
			'password' => [
				'type'        => 'password',
                'class'        => 'form-control',
				'label'       => 'Lösenord:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => '',
			],
            'about' => [
                'type'          =>'textarea',
                'class'         =>'form-control',
                'label'         =>'Om mig:',
                'validation'    =>['not_empty'],
                'value'         => isset($user) ? $user->about : '',
            ],
            'city' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Stad:',
                'value'         => isset($user) ? $user->city : '',
            ],
            'country' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Land:',
                'value'         => isset($user) ? $user->country : '',
            ],
            'website' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Webbsida:',
                'value'         => isset($user) ? $user->website : '',
            ],
			'uppdatera' => [
				'type'      => 'submit',
                'class'     => 'btn',
                'value'     => 'Uppdatera',
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
		
		$this->users->save([
			'email' => $this->Value('email'),
			'name' => $this->Value('name'),
			'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'about' => $this->Value('about'),
            'city' => $this->Value('city'),
            'country' => $this->Value('country'),
            'website' => $this->Value('website'),
			'updated' => $now,
			'active' => $now
		]);
		
//		$this->saveInSession = true;
		return true;
	}
	
/* === Callback What to do if the form was submitted? ====*/
	public function callbackSuccess()
	{
		$this->redirect('/gnar2/kmom06/Anax-MVC/webroot/users/id/'. $this->userId, 'Din användare är uppdaterad', 'success');
	}
	
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->redirect('/gnar2/kmom06/Anax-MVC/webroot/users/update/'. $this->userId, 'Något gick fel, försök igen.', 'error');
	}
}
<?php
namespace Anax\HTMLForm;

/* ==== CLASS TO CREATE OR EDIT A USER =====*/

class FormAddUser extends \Mos\HTMLForm\CForm
{
	use \Anax\DI\TInjectionaware,
	\Anax\MVC\TRedirectHelpers;
	
	public $users=null;

	
/* ==== CONSTRUCTOR ==== */
	public function __construct($users, $user=null)
	{

		$this->users=$users;
			
		
		parent::__construct([], [

			'name' => [
				'type'        => 'text',
                'class'       => 'form-control',
				'label'       => 'Namn:',
                'autofocus'   => true,
				'required'    => true,
				'validation'  => ['not_empty'],

			],
			'email' => [
				'type'        => 'text',
                'class'        => 'form-control',
				'label'       => 'E-post:',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],

			],
			'acronym' => [
				'type'        => 'text',
                'class'        => 'form-control',
				'label'       => 'Användarnamn:',
				'required'    => true,
				'validation'  => ['not_empty'],

			],
			'password' => [
				'type'        => 'password',
                'class'        => 'form-control',
				'label'       => 'Lösenord:',
				'required'    => true,
				'validation'  => ['not_empty'],

			],
            'about' => [
                'type'          =>'textarea',
                'class'         =>'form-control',
                'label'         =>'Om mig:',
                'required'    => true,
                'validation'    =>['not_empty'],

            ],
            'city' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Stad:',
            ],
            'country' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Land:',
            ],
            'website' => [
                'type'          =>'text',
                'class'         =>'form-control',
                'label'         =>'Webbsida:',
            ],
            'villkor' => [
                'type'          => 'checkbox',
                'label'         => ' Ja, jag har läst och godkänner reglerna för Shreddin the gnar'
            ],
			'register' => [
				'type'      => 'submit',
                'class'     => 'btn',
                'value'     => 'Registrera dig!',
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
			'acronym' => $this->Value('acronym'),
			'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'about' => $this->Value('about'),
            'city' => $this->Value('city'),
            'country' => $this->Value('country'),
            'website' => $this->Value('website'),
			'timestamp' => $now,
			'active' => $now,
            'points' => 'points' + 1
		]);
		
		$this->saveInSession = true;
		return true;
	}
	
/* === Callback What to do if the form was submitted? ====*/
	public function callbackSuccess()
	{
		$this->redirect('login/', 'Du är nu registrerad och kan logga in', 'success');
	}
	
/* ==== Callback What to do when form could not be processed? === */
	public function callbackFail()
	{
		$this->redirect('add/','Du har inte fyllt i alla fält', 'error');
	}
}
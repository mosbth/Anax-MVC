<?php
namespace Anax\Users;
 
/* === USERS CONTROLLER === 
1. Initialize
2. List all users
3. Id action
4. Add new user
5. Update User
6. Login
7. Login User
8. Logout
===========================*/

class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
/* ===== 1. INITIALIZE ==== */
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);

        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDI($this->di);
        
        $this->answers = new \Anax\Answers\Answer();
        $this->answers->setDI($this->di);

    }//END OF INITIALIZE
    
    
/* ==== 2. LIST ALL USERS ==== */
    public function allAction()
    {
        //$this->db->setVerbose(true)
        
        $all = $this->users->findAll();
 
        $this->theme->setTitle("Alla användare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Alla användare",
        ]);
    }//END OF LIST ALL USERS
    
/* === 3. LIST USER ==== */
    public function idAction($id = null)
    {
        $user = $this->users->find($id);
        
        if(!empty($user)){
            $name = $user->name;

            $questions = $this->users->getUsersQuestions($id);

            foreach($questions as $userQuestion){
                $userQuestion->countAnswer = $this->questions->countAnswers($userQuestion->id);
            }

            $answers = $this->users->getUserAnswers($id);
            
            foreach ($answers as $answer){
                $res = $this->questions->getQuestionTitle($answer->id);
                $answer->questionTitle = $res[0]->questionTitle;
            }

            $questioncomments = $this->users->getUserQuestionComments($id);
            
            foreach ($questioncomments as $comment){
                $res = $this->questions->getQuestionTitletoComment($comment->id);
                $comment->questionTitle = $res[0]->questionTitle;
            }
            
            $answercomments = $this->users->getUserAnswerComments($id);
            
            foreach ($answercomments as $comment){
                $res = $this->questions->getQuestionTitletoAnswerComment($comment->questionId);
                $comment->questionTitle = $res[0]->questionTitle;
                
//                $res2 = $this->questions->getQuestionId($comment->questionId);
//                $comment->question = $res[0]->id;
//                var_dump($res2);
            }

            $this->theme->setTitle("Användare med id");
            $this->views->add('users/user', [
                'user' => $user,
                'userQuestions' => $questions,
                'userAnswers' => $answers,
                'userComments' => $questioncomments,
                'userAnswerComments' => $answercomments,
                ]);
        
            $this->views->add('users/view',[
                'user' => $user,
                'userQuestions' => $questions,
                'userAnswers' => $answers,
                'userComments' => $questioncomments,
                'userAnswerComments' => $answercomments,
            ]);

            
        }else{
            $this->response->redirect($this->url->create('users/all/'), 'Användaren du söker finns inte', 'error');
        }
    }//END OF LIST USER

    
/* ==== 4.ADD NEW USER ==== */
	public function addAction($acronym = null)
	{ 	 		
		$form = new \Anax\HTMLForm\FormAddUser($this->users);
		$form->setDI($this->di);
		$form->check();
        
		$this->di->theme->setTitle("Lägg till användare");
		$this->di->views->add('default/page', [
			'title' => "Lägg till användare",
			'content' => $form->getHTML(array('id' => 'adduser'))
		]);	
	}//END OF NEW USER
    
/* ====== 5. UPDATE USER ===== */
	public function updateAction($id = null)
	{	
        $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        
        if($userId){
            if($userId==$id){
                    $user = $this->users->find($id);

                    $form = new \Anax\HTMLForm\FormEditUser($this->users, $user, $userId);
                    $form->setDI($this->di);
                    $form->check();

                    $this->di->theme->setTitle("Uppdatera användare");
                    $this->di->views->add('default/page', [
                        'title' => "Uppdatera användare " . $id,
                        'content' => $form->getHTML(array('id' => 'adduser'))
                    ]); 
            }elseif ($userId!==$id){ $this->response->redirect($this->url->create('users/id/' . $userId), 'Du kan inte uppdatera någon annans användare', 'error');}
        }else {$this->response->redirect($this->url->create('users/login/'), 'Du måste vara inloggad för att uppdatera din användare', 'error');}
	}//END OF UPDATE USER
    
/* ==== 6. LOGIN USER ==== */
		
	public function loginAction() { 	 

		$isPosted = $this->request->getPost('do_login');
		if (isset($isPosted))
		{
			$acronym = $this->request->getPost('acronym');
			$password = $this->request->getPost('password');
			
			$this->loginUser($acronym, $password);
		}
        
        
		$this->di->theme->setTitle("Logga in");
		$this->di->views->add('users/login', [
			'title' => "Logga in",
		]);
	}//END OF LOGIN 
/* ==== 7. LOGIN USER ==== */
    public function loginUser($acronym, $password) 
	{
			$user = $this->users->findUserAcronym($acronym);
			if($user){//FINNS ANVÄNDAREN?
                
                if(password_verify($password, $user->password)){//KOLLAR OM LÖSENORD ÄR RÄTT
                    $now = gmdate('Y-m-d H:i:s');
                    $sql = "UPDATE kmom07_user SET loggedIn = '$now' WHERE acronym = '{$acronym}';"; 
				    $this->db->execute($sql);
                    
                    $sql = "UPDATE kmom07_user SET points = points + 1 WHERE acronym = '{$acronym}';";
                    $this->db->execute($sql);
                    
                    $this->session->set('userId', $user->id);
                    $url = $this->url->create('users/id/' . ($user->id));
                    $this->response->redirect($url, 'Du är inloggad', 'success');
                }else{ //FEL LÖSENORD
                    $url = $this->url->create('users/login');
                    $this->response->redirect($url, 'Fel lösenord', 'error');
                }
            }else{//INGEN ANVÄNDARE FINNS
                $url = $this->url->create('users/login');
                $this->response->redirect($url, 'Användaren finns inte', 'error');
            }
	}//END OF LOGIN USER
	
/* ==== 8.. LOG OUT FUNCTION === */    
    public function logoutAction()
    {
        $this->session->destroy();	
        $url = $this->url->create('index');
        $this->response->redirect($url, 'Du är nu utloggad', 'success');
    }//END OF LOGOUT
    
/* ======= 9. PROFILE =======*/
    public function profileAction(){
        $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        $url = $this->url->create('users/id/' . $userId);
        $this->response->redirect($url);
    }//END OF PROFILE

    
//ANVÄNDS EJ I PROJEKTET 
/* ==== DELETE USER ==== */
    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }
    
/* ==== SOFT DELETE USER ======*/
    public function softDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }
    
/* ===== UNDO DELETE ===== */
    public function undoDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
                 
        $now = gmdate('Y-m-d H:i:s');
                 
        $user = $this->users->find($id);
                 
        $user->active = $now;
        $user->deleted = NULL;
        $user->save();
                 
        $url = $this->url->create('users');
        $this->response->redirect($url);
    }
    
/* ==== TRASHCAN =====*/
public function trashcanAction()
{
    $all = $this->users->query()
        ->where('deleted is NOT NULL')
        ->execute();
 
    $this->theme->setTitle("Papperskorgen");
    $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Papperskorgen",
    ]);
}
    
/* ===== List all active and not deleted users. ===== */

    public function activeAction()
    {
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Aktiva användare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Aktiva användare",
        ]);
    }
    
/* ===== List all inactive and not deleted users. ===== */

    public function inactiveAction() 
    { 
        $all = $this->users->query() 
            ->where('active IS NULL') 
            ->andWhere('deleted is NULL') 
            ->execute(); 

        $this->theme->setTitle("Inaktiva användare"); 
        $this->views->add('users/list-all', [ 
            'users' => $all, 
            'title' => "Inaktiva användare", 
        ]); 
    }
    
/* ==== Deactivate a user ===== */
    public function deactivateAction($id=null) {      
            $this->users->save([
                'id'          => $id,
                'active'    => null,
            ]);
            $url = $this->di->url->create($_SERVER['HTTP_REFERER']);
            $this->response->redirect($url);
    }

/* ==== ACTIVATE A USER ==== */
    public function activateAction($id=null) {   
            $now = date('Y-m-d H:i:s'); 
            $this->users->save([
                'id'          => $id,
                'active'    => $now,
            ]);
            $url = $this->di->url->create($_SERVER['HTTP_REFERER']);
            $this->response->redirect($url);
    }// END OF ACTIVATE USER

    
} 

    
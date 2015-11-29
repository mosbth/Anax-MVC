<?php
namespace Anax\Questions;
 
/* === CONTROLLER FÖR QUESTIONS === 
1. Initialize
2. Index
3. List all questions
4. List a question
5. Add question
6. Edit question
7. Answer a question
8. Add comments to Question
9. Get latest questions
10. Vote Question
11. Vote Answer
12. Vote Comments
13. Accept Answer
14. Search Question
15. Search
================================== */

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
		\Anax\MVC\TRedirectHelpers;
	
	
/* ==== 1. INITIALIZE ==== */
	public function initialize()
	{
		$this->users = new \Anax\Users\User();
		$this->questions = new \Anax\Questions\Question();
		$this->answers = new \Anax\Answers\Answer();
		$this->comments = new \Anax\Comments\Comment();
		$this->tags = new \Anax\Tags\Tag();
        $this->activities = new \Anax\Activities\Activity();
		
        $this->users->setDI($this->di);
        $this->questions->setDI($this->di);
        $this->answers->setDI($this->di);
        $this->comments->setDI($this->di);
        $this->tags->setDI($this->di);
        $this->activities->setDI($this->di);
	}
	
	
/* === 2. INDEX PAGE ==== */
	public function indexAction() 
	{
		$questions = $this->latestQuestions();
		$tags = $this->tags->countQuestionTags(); 
		$activeUsers = $this->users->activeUsers();
		
		$this->views->add('gnar/index', [
			'questions' => $questions,
			'tags' => $tags,
			'activeUsers' => $activeUsers
		]);
	}
	
	
/* === 3. LIST ALL QUESTIONS ==== */
    public function listAction($order)
    {
        if ($order === 'timestamp'){

            $sql = "SELECT * FROM kmom07_question ORDER BY timestamp DESC";
            $this->db->execute($sql);
            $this->db->setFetchModeClass(__CLASS__);
            $questions = $this->db->fetchAll();

            foreach($questions as $question){
                $question->countAnswer = $this->questions->countAnswers($question->id);
            }
            $this->views->add('questions/list-all', [
            'questions' => $questions,
            'order' => 'timestamp',
            'title' => "Frågor",
        ]);
        }// END OF ORDER TIMESTAMP
        elseif($order === 'votes'){
            $sql = "SELECT * FROM kmom07_question ORDER BY points DESC";
            $this->db->execute($sql);
            $this->db->setFetchModeClass(__CLASS__);
            $questions = $this->db->fetchAll();

            foreach($questions as $question){
                $question->countAnswer = $this->questions->countAnswers($question->id);
            }
            $this->views->add('questions/list-all', [
            'questions' => $questions,
            'order' => 'votes',
            'title' => "Frågor",
        ]);
        }//END OF ORDER VOTES

    }//END OF LIST ALL
	
	
/* ==== 4. LIST A QUESTION ==== */
	public function idAction($id = null)
	{

		$question = $this->questions->find($id);
        
        if(!empty($question)){
            $email = $this->users->getUserEmail($question->userId);
            $question->userEmail = $email[0]->email;
            
            //Ta reda på vem som skapat frågan
            $res = $this->questions->getUserFromQuestion($id);
            $questioncreator = $res[0]->userId;
            //Skicka med inloggade användaren
            $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;

            $answers = $this->answers->getAnswers($id);
            
            foreach($answers as $answer){
                $res2= $this->users->getUserEmail($answer->userId);
                $answer->userEmail = $res2[0]->email;
                $answer->comments = $this->comments->getCommentstoAnswer($answer->id);
            }
            
            $acceptedanswers = $this->questions->hasAcceptedAnswer($id);

            $question->comments = $this->comments->getCommentstoQuestion($id);
            $tags = $this->questions->getQuestionTags($id);

            $this->theme->setTitle("Visa fråga");
            $this->views->add('questions/view', [
                'question' => $question,
                'answers' => $answers,
                'acceptedanswers' => $acceptedanswers,
                'tags' => $tags,
                'questioncreator' => $questioncreator,
                'userId' => $userId,
            ]);
	   }else{
            $this->response->redirect($this->url->create('questions/list/timestamp'), 'Frågan du söker finns inte', 'error');
        }
    }//END OF LIST ONE QUESTION
	
	
/* === 5. ADD QUESTION === */
	public function addAction() 
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        
		if($userId){
            $user = $this->users->find($userId);
            $acronym = $user->acronym;
            
			$form = new \Anax\HTMLForm\CFormQuestion($this->questions,$this->activities, $userId, $this->tags, $acronym);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Ställ en fråga");
			$this->di->views->add('default/page', [
				'title' => "Ställ en fråga",
				'content' => $form->getHTML()
			]);
		} else {$this->response->redirect($this->url->create('users/login/'), 'Du måste vara inloggad för att ställa en fråga', 'error');

		}
	}//END OF ADD QUESTION 
    
/* ====== 6. EDIT QUESTION ===== */
	public function updateAction($id)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        
        //ADD SO JUST THE USER WHO CREATED CAN EDIT
		if($userId){
            $res = $this->questions->getUserFromQuestion($id);
            $questioncreator = $res[0]->userId;
//            var_dump($questioncreator);
            if($userId==$questioncreator){//Ser om den som försöker redigera är den som skapat frågan
                $user = $this->users->find($userId);

                $acronym = $user->acronym;

                $question = $this->questions->find($id);
                
                $questionTitle = $question->questionTitle;
                $questionText = $question->questiontext;
                
                $tagsres = $this->questions->getQuestionTags($id);
                foreach($tagsres as $tag){
                    $tagsarray[] = $tag->tagName;
                }
                $tags1 = implode(",", $tagsarray);
                
                $form = new \Anax\HTMLForm\CFormQuestionEdit($this->questions, $this->tags, $userId, $tags1, $questionTitle, $questionText, $acronym, $id);
                $form->setDI($this->di);
                $form->check();

                $this->di->theme->setTitle("Ställ en fråga");
                $this->di->views->add('default/page', [
                    'title' => "Ställ en fråga",
                    'content' => $form->getHTML()
                ]);
            } else {$this->response->redirect($this->url->create('questions/id/' . $id), 'Du kan inte redigera en fråga som du inte har skapat', 'error');
            }
		} else {$this->response->redirect($this->url->create('users/login/'), 'Du måste vara inloggad för att redigera en fråga', 'error');}
	}//END OF EDIT QUESTION 
	
	
/* === 7. ANSWER A QUESTION ==== */
	public function answerAction($id)
	{
        if(!isset($id)){
            die("Missing Id");
        }
        
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        	
		if($userId){
            $question = $this->questions->find($id);
		
            $user = $this->users->find($userId);
            $acronym = $user->acronym;
            
			$form = new \Anax\HTMLForm\CFormAnswer($this->answers, $this->activities, $userId, $question, $acronym);
			$form->setDI($this->di);
			$form->check();
			
			$this->di->theme->setTitle("Besvara fråga");
			$this->di->views->add('default/page', [
				'title' => "Svara på frågan: " . $question->questionTitle,
				'content' => $form->getHTML()
			]);
		} else {$this->response->redirect($this->url->create('users/login/'), 'Du måste vara inloggad för att svara på frågor.', 'error');}
	}
	
	
/* ==== 8. ADD COMMENTS ==== */
	public function addCommentAction($id, $type, $answerId=null)
	{
		$userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        
		if($userId){
            
            if ($type == 'question'){
                $question = $this->questions->find($id);
		
                $user = $this->users->find($userId);
                $acronym = $user->acronym;
                $form = new \Anax\HTMLForm\CFormComment($this->comments, $this->activities, $userId, $id, $acronym, $type, $question);
                $form->setDI($this->di);
                $form->check();
			
                $this->di->theme->setTitle("Lägg till kommentar");
                $this->di->views->add('default/page', [
                    'title' => "Lägg till kommentar",
                    'content' => $form->getHTML()
                ]);
            }
            elseif ($type == 'answer'){
                $question = $this->questions->find($id);
		
                $user = $this->users->find($userId);
                $acronym = $user->acronym;
                $form = new \Anax\HTMLForm\CFormComment($this->comments, $this->activities, $userId, $answerId, $acronym, $type, $question);
                $form->setDI($this->di);
                $form->check();
			
                $this->di->theme->setTitle("Lägg till kommentar");
                $this->di->views->add('default/page', [
                    'title' => "Lägg till kommentar",
                    'content' => $form->getHTML()
                ]);
            }
        }else {$this->response->redirect($this->url->create('users/login/'), 'Du måste vara inloggad för att kunna kommentera.', 'error');}
	}//END OF ADD COMMENT
    
    
/* === 9. GET LATEST QUESTIONS=== */
	public function latestQuestions() {
		$sql = "SELECT * FROM kmom07_question ORDER BY timestamp DESC LIMIT 10;"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF LATEST QUESTIONS
    
/* === 10. VOTE QUESTIONS ==== */
    public function voteQuestionAction($id, $vote){
        $lastUrl = $this->request->getLastUrl();
        
        $res = $this->questions->getUserFromQuestion($id);
        $questioncreator = $res[0]->userId;
        
        $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        if($userId){
            if($questioncreator != $userId){
            if($vote === 'up'){
                $sql = "UPDATE kmom07_question SET points = points + 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_question as Q
                SET U.points = U.points + 2
                WHERE Q.id = {$id} 
                AND Q.userId = U.id";
                $this->db->execute($sql2);
            }else{
                $sql = "UPDATE kmom07_question SET points = points - 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_question as Q
                SET U.points = U.points - 2
                WHERE Q.id = {$id} 
                AND Q.userId = U.id";
                $this->db->execute($sql2);
            }$this->response->redirect($lastUrl);
            }else{$this->response->redirect($lastUrl, 'Du kan inte rösta på dina egna frågor.', 'error');
            }      
        }else{
            $this->response->redirect($lastUrl, 'Du måste vara inloggad för att rösta.', 'error');
        }
    }//END OF VOTE QUESTION

/* === 11. VOTE ANSWERS ==== */
    public function voteAnswerAction($id, $vote){
        $lastUrl = $this->request->getLastUrl();
        
        $res = $this->questions->getUserFromAnswer($id);
        $answercreator = $res[0]->userId;
        
        $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        if($userId){
            if($answercreator != $userId){
            if($vote === 'up'){
                $sql = "UPDATE kmom07_answer SET points = points + 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_answer as A
                SET U.points = U.points + 2
                WHERE A.id = {$id} 
                AND A.userId = U.id";
                $this->db->execute($sql2);
            }else{
                $sql = "UPDATE kmom07_answer SET points = points - 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_answer as A
                SET U.points = U.points - 2
                WHERE A.id = {$id} 
                AND A.userId = U.id";
                $this->db->execute($sql2);
            }$this->response->redirect($lastUrl);
            }else{$this->response->redirect($lastUrl, 'Du kan inte rösta på dina egna svar.', 'error');
            }
        }else{
            $this->response->redirect($lastUrl, 'Du måste vara inloggad för att rösta.', 'error');
        }
    }//END OF VOTE ANSWER
    
/* === 12. VOTE COMMENTS ==== */
    public function voteCommentAction($id, $vote){
        $lastUrl = $this->request->getLastUrl();
        
        $res = $this->questions->getUserFromComment($id);
        $commentcreator = $res[0]->userId;
        
        $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        if($userId){
            if($commentcreator != $userId){
            if($vote === 'up'){
                $sql = "UPDATE kmom07_comment SET points = points + 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_comment as C
                SET U.points = U.points + 2
                WHERE C.id = {$id} 
                AND C.userId = U.id";
                $this->db->execute($sql2);
            }else{
                $sql = "UPDATE kmom07_comment SET points = points - 1 WHERE id = '{$id}';";
                $this->db->execute($sql);
                
                $sql2 = "
                UPDATE kmom07_user as U, kmom07_comment as C
                SET U.points = U.points - 2
                WHERE C.id = {$id} 
                AND C.userId = U.id";
                $this->db->execute($sql2);
            }$this->response->redirect($lastUrl);
            }else{$this->response->redirect($lastUrl, 'Du kan inte rösta på dina egna kommentarer.', 'error');
            }
        }else{
            $this->response->redirect($lastUrl, 'Du måste vara inloggad för att rösta', 'error');
        }
    }//END OF VOTE COMMENT
    
/* === 13. ACCEPT ANSWER ===== */
    public function acceptAnswerAction($id){
        $lastUrl = $this->request->getLastUrl();
        $sql = "UPDATE kmom07_answer SET accepted = 1 WHERE id = '{$id}';";
        $this->db->execute($sql);
        
        $sql2 = "
        UPDATE kmom07_user as U, kmom07_answer as A
        SET U.points = U.points + 10 
        WHERE A.id = {$id} 
        AND A.userId = U.id";
        $this->db->execute($sql2);
        
        $this->response->redirect($lastUrl);
    }
    
/* === 14. SEARCH QUESTIONS ==== */
    public function searchAction($type = null){
        $isPosted = $this->request->getPost('do_search');
        
        if (isset($isPosted))
		{
			$value = $this->request->getPost('searchvalue');
			
                $sql = "SELECT DISTINCT Q.* FROM kmom07_question as Q, kmom07_comment as C, kmom07_answer as A
                WHERE A.answer LIKE '%" . $value . "%' OR C.commentText LIKE '%" . $value . "%' OR Q.questiontext LIKE '%" . $value . "%' OR Q.questionTitle LIKE '%" . $value . "%'";
                $this->db->execute($sql);
                $questions = $this->db->fetchAll();

                foreach($questions as $question){
                    $question->countAnswer = $this->questions->countAnswers($question->id);
                }

                $this->di->theme->setTitle("Sök");
                $this->di->views->add('questions/search', [
                    'title' => "Sökresultat för " . $value,
                    'questions' => $questions,
                ]);;   
		}
        
    }//END OF SEARCH
    



	
}
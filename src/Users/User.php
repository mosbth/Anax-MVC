<?php
namespace Anax\Users;
 
/* === MODEL FOR USERS ==== 
1. GET QUESTIONS FROM USER
2. GET ANSWERS FROM USER
3. GET QUESTION COMMENTS FROM USER
4. GET ANSWER COMMENTS FROM USER
4. ACTIVE USERS
5. FIND USERS ACRONYM (FOR LOGIN)
===========================*/

class User extends \Anax\MVC\CDatabaseModel
{
    
/* === 1. GET QUESTIONS FROM USER ==== */
	public function getUsersQuestions($id) {
		$sql = "SELECT * FROM kmom07_question as Q
        WHERE Q.userId= {$id} ORDER BY timestamp DESC;"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF QUESTIONS FROM USER
    
/* === 2. GET ANSWERS FROM USER ==== */   
public function getUserAnswers($id) {
		$sql = "SELECT * FROM kmom07_answer as A
        WHERE A.userId= {$id} ORDER BY timestamp DESC;"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF ANSWERS FROM USER
    
/* === 3. GET QUESTION COMMENTS FROM USER ==== */   
public function getUserQuestionComments($id) {
		$sql = "SELECT * FROM kmom07_comment as C
        WHERE C.userId= {$id} AND commentType = 'question' ORDER BY timestamp DESC;"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF ANSWERS FROM USER

/* === 4. GET ANSWERS COMMENTS FROM USER ==== */   
public function getUserAnswerComments($id) {
		$sql = "SELECT * FROM kmom07_comment as C
        WHERE C.userId= {$id} AND commentType = 'answer' ORDER BY timestamp DESC;"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF ANSWERS FROM USER
    
/* ==== 5. FIND THE MOST ACTIVE USERS ==== */
	public function activeUsers()
	{
		$sql = "SELECT * FROM kmom07_user ORDER BY points DESC LIMIT 5"; 
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}//END OF MOST ACTIVE USERS

    
/* === 6. FIND USER ACRONYM ==== */
	public function findUserAcronym($acronym)
	{
		$this->db->select()
				->from($this->getSource())
				->where('acronym = ?');
		
		$this->db->execute([$acronym]);
		
		return $this->db->fetchInto($this);
	}// END OF USER ACRONYM

/* ==== 7. GET USER EMAIL (FOR GRAVATARS)===== */
    public function getUserEmail($id){
        $sql = "SELECT email FROM kmom07_user WHERE id = '{$id}'";
        $this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
    }
	
    

}
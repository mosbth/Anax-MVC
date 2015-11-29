<?php
namespace Anax\Questions;
 
/* ==== MODEL FOR QUESTIONS ==== 
1. Get tags to a specific question
2. Get questions with tagname
3. Get last id to declare a new value to a new question
4. Get user (for edit question)
5. Get user from answer
6. Get user from comment
7. Count answers for each question
8. Get timestamp from question
9. Get questiontitle from answer
10. Get questiontitle for comments
11. Get questiontitle for answercomments
=================================*/

class Question extends \Anax\MVC\CDatabaseModel
{
    
/* === 1. GET THE TAGS TO A SPECIFIC QUESTION ==== */
	public function getQuestionTags($id) {
		$sql = "SELECT * FROM kmom07_questionTag as QT, kmom07_tag as T    
        WHERE QT.questionID = {$id} and QT.tagName = T.tag";
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF GET TAGS
    
/* === 2. GET QUESTIONS WITH TAGNAME === */
	public function getQuestionsWithTag($tag) {
		
		$sql = "SELECT * FROM kmom07_questionTag as QT, kmom07_question as Q
            WHERE QT.tagName = '{$tag}' and QT.questionId = Q.id ORDER BY timestamp DESC"; 
		$this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}//END OF QUESTIONS WITH TAGNAME
    
/* === 3. GET LAST ID === */
	public function getLastInsertId() {
		return $this->db->lastInsertId();
	}//END OF LAST ID 
    
/* ==== 4. GET USER FROM QUESTION ==== */
    public function getUserfromQuestion($id){
        $sql = "SELECT userId FROM kmom07_question 
        WHERE kmom07_question.id = {$id}";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
    
/* ==== 5. GET USER FROM ANSWER ==== */
    public function getUserfromAnswer($id){
        $sql = "SELECT userId FROM kmom07_answer 
        WHERE kmom07_answer.id = {$id}";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
    
/* ==== 6. GET USER FROM ANSWER ==== */
    public function getUserfromComment($id){
        $sql = "SELECT userId FROM kmom07_comment 
        WHERE kmom07_comment.id = {$id}";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
    
/* ==== 7. COUNT ANSWERS ($id) ===== */
    public function countAnswers($id){
        $sql = "SELECT * FROM kmom07_answer as A
        WHERE A.questionId = {$id}";
        $this->db->execute($sql);
        return $this->db->rowCount();
    }//END OF COUNT ANSWERS
    
/* === 8. GET TIMESTAMP FROM QUESTION ==== */
    public function getTimestampFromQuestion($id){
        $sql = "SELECT timestamp FROM kmom07_question 
        WHERE kmom07_question.id = {$id}";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
/* === 9. GET QUESTION TITLE FOR ANSWER === */
    public function getQuestionTitle($id){
        $sql = "SELECT questionTitle FROM kmom07_answer as A, kmom07_question as Q
        WHERE A.id= {$id} and A.questionId = Q.id";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
    
/* === 10. GET QUESTION TITLE FOR COMMENTS=== */
    public function getQuestionTitleToComment($id){
        $sql = "SELECT questionTitle FROM kmom07_answer as A, kmom07_question as Q, kmom07_comment as C
        WHERE C.id= {$id}
        AND C.questionId = Q.id
        ";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
/* === 11. GET QUESTION TITLE FOR ANSWERCOMMENTS=== */
    public function getQuestionTitleToAnswerComment($id){
        $sql = "SELECT questionTitle FROM kmom07_answer as A, kmom07_question as Q, kmom07_comment as C
        WHERE A.id= {$id}
        AND A.questionId = Q.id
        ";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }
    
/* ==== 15. Does the question have an accepted anser ==== */
    public function hasAcceptedAnswer($id){
        $sql = "SELECT accepted FROM kmom07_answer as A
        WHERE A.questionId = '{$id}' AND accepted = true";
        $this->db->execute($sql);
		return $this->db->fetchAll();
    }//END OF ACCEPTED ANSWERS
    
///* === 10. GET QUESTION ID FOR ANSWERCOMMENTS=== */
//    public function getQuestionId($id){
//        $sql = "SELECT * FROM kmom07_answer as A, kmom07_question as Q
//        WHERE A.id= {$id}
//        AND A.questionId = Q.id
//        ";
//        $this->db->execute($sql);
//		return $this->db->fetchAll();
//    }
    
    
}
<?php
namespace Anax\Comments;
 
/* ===== CLASS FOR COMMENTS ========*/

class Comment extends \Anax\MVC\CDatabaseModel
{
/* ==== GET QUESTION COMMENTS TO A SPECIFIC QUESTION ==== */
    
    public function getCommentstoQuestion($id){
        $sql = "SELECT * FROM kmom07_comment WHERE questionId = '{$id}' AND commentType = 'question'";
        $this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
    }
/* ==== GET COMMENTS TO ANSWERS ==== */
    public function getCommentstoAnswer($answerId){
        $sql = "SELECT * FROM kmom07_comment as C
        WHERE C.questionId = {$answerId}
        AND  C.commentType = 'answer'";
        $this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
    }

	
}
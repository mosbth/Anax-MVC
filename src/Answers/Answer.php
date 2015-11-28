<?php
namespace Anax\Answers;
 
/* === MODEL FOR ANSWER ==== 
1. Get answers to a specific question

===========================*/

class Answer extends \Anax\MVC\CDatabaseModel
{
    public function getAnswers($id){
        $sql = "SELECT * FROM kmom07_answer WHERE questionId = '{$id}'";
        $this->db->execute($sql);
        $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
    }
    
}
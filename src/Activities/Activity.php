<?php
namespace Anax\Activities;
 
/* === MODEL FOR ACTIVITY ==== 
1. Give user questions points
2. Answer Points
3. Commentpoints
============================*/

class Activity extends \Anax\MVC\CDatabaseModel
{
/* ===== 1. Give UserPoints when adding a question ==== */
    public function questionPoints($id){
        $sql = "UPDATE kmom07_user SET points = points + 5 WHERE id = '{$id}'";
        $this->db->execute($sql);
    }
/* ===== 2. Give User Points when answering a question ==== */    
    public function answerPoints($id){
        $sql = "UPDATE kmom07_user SET points = points + 5 WHERE id = '{$id}'";
        $this->db->execute($sql);
    }
/* ===== 3. Give User Points when adding a comment ==== */
    public function commentPoints($id){
        $sql = "UPDATE kmom07_user SET points = points + 2 WHERE id = '{$id}'";
        $this->db->execute($sql);
    }

}
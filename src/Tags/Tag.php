<?php
namespace Anax\Tags;
 
/* ==== TAGS ============= 
1. POPULAR TAGS
2. SAVE TAGS
3. SAVE TAGS WHEN EDITING A QUESTION
=========================*/

class Tag extends \Anax\MVC\CDatabaseModel
{
    
/* === 1. POPULAR TAGS === */
    public function countQuestionTags()
    {
        $sql = "SELECT *, count(tagName) FROM kmom07_tag, kmom07_questionTag 
                WHERE kmom07_questionTag.tagName = kmom07_tag.tag
                GROUP BY kmom07_questionTag.tagName
                ORDER BY COUNT(tagName) DESC LIMIT 6";
        $this->db->execute($sql);
        return $this->db->fetchAll();
    }//END OF POPULAR TAGS
	

/* ==== 2. SAVE TAG TO DB ==== */
	public function saveTag($questionId, $tagsString) {
		
        $tags = explode(',', $tagsString);
        
        foreach ($tags as $tag){
            $sql = "INSERT INTO kmom07_tag (tag) VALUES ('{$tag}') ON DUPLICATE KEY UPDATE tag = '{$tag}'";
            $this->db->execute($sql);
            
            $sql2 = "INSERT INTO kmom07_questionTag (tagName, questionId) VALUES ('{$tag}', '{$questionId}')";
            $this->db->execute($sql2);
        }
    }//END OF SAVETAG
    
/* ==== 3. SAVE TAGS WHEN EDITING A QUESTION ==== */
    public function saveEditTag($questionId, $tagsString) {
		
        $sql = "DELETE FROM kmom07_questionTag WHERE questionId = '{$questionId}'";
        $this->db->execute($sql);
        
        $tags = explode(',', $tagsString);
        
        foreach ($tags as $tag){
            $sql = "INSERT INTO kmom07_tag (tag) VALUES ('{$tag}') ON DUPLICATE KEY UPDATE tag = '{$tag}'";
            $this->db->execute($sql);
            
            $sql2 = "INSERT INTO kmom07_questionTag (tagName, questionId) VALUES ('{$tag}', '{$questionId}')";
            $this->db->execute($sql2);
        }
    }//END OF SAVETAG

}
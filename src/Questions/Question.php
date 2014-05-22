<?php

namespace Anax\Questions;

/**
* 
*/
class Question extends \Anax\MVC\CDatabaseModel
{   

    public function findLates() 
    {  
        $this->db->select('
            stackoverflow_user.acronym,
            stackoverflow_question.id AS id,
            stackoverflow_question.title,
            stackoverflow_question.slug AS slug,
            CONCAT(left(stackoverflow_question.question, 100), \'...\') AS question,
            stackoverflow_question.created,
            stackoverflow_question.updated'
        )->from($this->getSource())
        ->join('user', 'stackoverflow_user.id = stackoverflow_question.user_id')
        ->orderBy('stackoverflow_question.created, stackoverflow_question.updated, stackoverflow_question.id DESC')
        ->limit('5');

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function getFront()
    {
        $this->db->select('
            stackoverflow_user.acronym,
            stackoverflow_question.id AS id,
            stackoverflow_question.title,
            stackoverflow_question.slug AS slug,
            stackoverflow_question.created,
            stackoverflow_question.updated'
        )->from($this->getSource())
        ->join('user', 'stackoverflow_user.id = stackoverflow_question.user_id')
        ->orderBy('stackoverflow_question.created, stackoverflow_question.updated, stackoverflow_question.id DESC');

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}

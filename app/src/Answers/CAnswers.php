<?php
namespace Anax\Answers;

/**
 * Model for Answers.
 *
 */
class CAnswers extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('canswers')->execute();

        $this->db->createTable(
            'canswers',
            [
               'id'         => ['integer', 'primary key', 'not null', 'auto_increment'],
               'content'    => ['varchar(1024)'],
               'q_id'       => ['int'],
               'user_id'    => ['int'],
               'vote'       => ['int'],
               'created'    => ['datetime'],
               'accepted'   => ['bool'],
            ]
        )->execute();
        $this->db->insert(
            'canswers',
            ['content', 'q_id', 'user_id', 'vote', 'created', 'accepted']
        );

        $now = time();

        $this->db->execute([
            'That is a difficult *question*. Its a little bit more then 3.',
            1,
            2,
            0,
            $now,
            false,
        ]);

        $this->db->execute([
            'I think it is 6,28.',
            2,
            1,
            0,
            $now,
            false,
        ]);

    }
    /**
     * Count number of answer each user has answered.
     *
     * @return array
     */
    public function countByUser()
    {
        // SELECT user_id, COUNT(*) AS Cnt FROM canswers GROUP BY user_id ORDER BY user_id ASC LIMIT 3;
        $this->db->select("user_id, COUNT(*) AS Cnt")
            ->from($this->getSource())
            ->groupby("user_id")
            ->orderby('user_id ASC')
            ->execute();
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}

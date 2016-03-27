<?php
namespace Anax\Tags;

/**
 * Model for Users.
 *
 */
class CTags2Question extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('ctags2question')->execute();

        $this->db->createTable(
            'ctags2question',
            [
                'id'         => ['integer', 'primary key', 'not null', 'auto_increment'],
                'tag_id'        => ['int'],
                'question_id'   => ['integer'],     // Question id.
            ]
        )->execute();
        $this->db->insert(
            'ctags2question',
            ['tag_id', 'question_id',]
        );
        $this->db->execute([1, 1, ]);
        $this->db->execute([2, 1, ]);
        $this->db->execute([6, 1, ]);
        $this->db->execute([4, 2, ]);
        $this->db->execute([5, 2, ]);
        $this->db->execute([8, 3, ]);
        $this->db->execute([3, 3, ]);
        $this->db->execute([2, 3, ]);
        $this->db->execute([6, 4, ]);
        $this->db->execute([7, 4, ]);
        $this->db->execute([2, 5, ]);
        $this->db->execute([3, 5, ]);
        $this->db->execute([6, 5, ]);
        $this->db->execute([8, 6, ]);
    }
    // public function findQuestionIds($tag = '')
    // {
    //     // TODO: dont work. qo query in controller instead.
    //     $this->db->select()
    //          ->from($this->getSource())
    //          ->where("tag_id = ?");
    //
    //     $this->db->execute([$tag]);
    //     return $this->db->fetchInto($this);
    // }
    // public function findTagIds($qid = '')
    // {
    //     // TODO: dont work. qo query in controller instead.
    //     $this->db->select()
    //          ->from($this->getSource())
    //          ->where("question_id = ?");
    //
    //     $this->db->execute([$qid]);
    //     return $this->db->fetchInto($this);
    // }

    /**
     * Find and return most popular tags.
     * Overrides function in CDatabaseModel
     *
     * @return array
     */
    public function mostPopularTags($count = 3)
    {
        // SELECT tag_id, COUNT(*) AS tagCnt FROM ctags2question GROUP BY tag_id ORDER BY tagCnt  DESC LIMIT 3;
        $this->db->select("tag_id, COUNT(*) AS tagCnt")
            ->from($this->getSource())
            ->groupby("tag_id")
            ->orderby('tagCnt DESC')
            ->limit($count)
            ->execute();
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}

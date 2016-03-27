<?php
/**
 * class for commenting. Model for comments.
 */
namespace Anax\CommentDb;

class CommentsInDb extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('commentsindb')->execute();

        $this->db->createTable(
            'commentsindb',
            [
               'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
               'content' => ['varchar(1024)'],
               'q_or_a' => ['char(1)'],
               'q_or_a_id' => ['int'],
               'user_id' => ['int'],
               'created' => ['datetime'],
            ]
        )->execute();
        $this->db->insert(
            'commentsindb',
            ['content', 'q_or_a', 'q_or_a_id', 'user_id', 'created']
        );

        $now = time();

        $this->db->execute([
            'Lorem ipsum dolor sit amet, ad nam graeci **dissentias**, te verear utroque per. Doming intellegat mea id, mel ei dicta iudico. Dicunt fabulas usu ad. Per nemore possim commune ut, eu probo dicta has. ',
            'q',
            1,
            1,
            $now
        ]);

        $this->db->execute([
            'Accusam eleifend qui ex. Has duis iuvaret salutatus id, dico illud porro ea mei, id oblique tibique eos. Ne eam meis equidem admodum, eos nisl maluisset id. Ancillae lucilius persecuti no sed.',
            'a',
            1,
            1,
            $now
        ]);

        $this->db->execute([
            'Sea te vocibus dolores pertinax, quodsi insolens appellantur sit an, dicam definitionem sed ne.',
            'a',
            1,
            1,
            $now
        ]);

    }
    /**
     * Count number of questions each user has asked.
     *
     * @return array
     */
    // TODO: Move function CDatabaseModel and set count column as parameter.
    // move from all others as well.
    public function countByUser()
    {
        // SELECT user_id, COUNT(*) AS Cnt FROM cquestions GROUP BY user_id ORDER BY user_id ASC;
        $this->db->select("user_id, COUNT(*) AS Cnt")
            ->from($this->getSource())
            ->groupby("user_id")
            ->orderby('user_id ASC')
            ->execute();
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public static function humanTiming($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'år',
            2592000 => 'månader',
            604800 => 'veckor',
            86400 => 'dagar',
            3600 => 'timmar',
            60 => 'minuter',
            1 => 'sekunder'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' ':'');
        }
    }
}

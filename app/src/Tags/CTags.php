<?php
namespace Anax\Tags;

/**
 * Model for Users.
 *
 */
class CTags extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('ctags')->execute();

        $this->db->createTable(
            'ctags',
            [
                'id'         => ['integer', 'primary key', 'not null', 'auto_increment'],
                'name'    => ['varchar(80)'],
            ]
        )->execute();
        $this->db->insert(
            'ctags',
            ['name', ]
        );
        $this->db->execute(['Tak',]);       // 1
        $this->db->execute(['Grund',]);     // 2
        $this->db->execute(['Färg',]);      // 3
        $this->db->execute(['Fasad',]);     // 4
        $this->db->execute(['Dörrar',]);    // 5
        $this->db->execute(['Fönster',]);   // 6
        $this->db->execute(['Golv',]);      // 7
        $this->db->execute(['Uppvärmning',]);

    }
    /**
     * Find and return specific.
     *
     * @return this
     */
    public function findTag($tag)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where("name = ?");

        $this->db->execute([$tag]);
        return $this->db->fetchInto($this);
    }
}

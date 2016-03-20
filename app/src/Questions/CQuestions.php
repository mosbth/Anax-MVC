<?php
namespace Anax\Questions;

/**
 * Model for Users.
 *
 */
class CQuestions extends \Anax\MVC\CDatabaseModel
{

    /**
     * Initialize model.
     *
     * @return array
     */
    public function init()
    {
        $this->db->setVerbose();
        $this->db->dropTableIfExists('cquestions')->execute();

        $this->db->createTable(
            'cquestions',
            [
               'id'         => ['integer', 'primary key', 'not null', 'auto_increment'],
               'headline'    => ['varchar(80)'],
               'content'    => ['varchar(1024)'],
               'user_id'    => ['int'],
               'vote'       => ['int'],
               'created'    => ['datetime'],
            ]
        )->execute();
        $this->db->insert(
            'cquestions',
            ['headline', 'content', 'user_id', 'vote', 'created']
        );

        $now = time();

        $this->db->execute([
            'Fråga 1?',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non urna at lectus venenatis facilisis. Nullam rutrum tortor at aliquet tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut ullamcorper purus. Sed elementum purus quis tortor finibus, eget vestibulum lorem finibus. Vestibulum porta ligula in risus aliquam luctus. Ut eget sapien libero.',
            1,
            0,
            $now
        ]);

        $this->db->execute([
            'Fråga 2?',
            'Suspendisse eget rutrum mauris. Morbi dictum vulputate pulvinar. Sed feugiat lobortis arcu, ut feugiat mauris sagittis a. Nulla leo ante, interdum id accumsan sit amet, tempor nec urna. ',
            1,
            0,
            $now
        ]);
        $this->db->execute([
            'Fråga 3?',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut ullamcorper purus. Sed elementum purus quis tortor finibus, eget vestibulum lorem finibus. Vestibulum porta ligula in risus aliquam luctus. Ut eget sapien libero.',
            2,
            0,
            $now
        ]);
        $this->db->execute([
            'Fråga 4?',
            'Suspendisse eget rutrum mauris. Morbi dictum vulputate pulvinar. Sed feugiat lobortis arcu, ut feugiat mauris sagittis a. Nulla leo ante, interdum id accumsan sit amet, tempor nec urna. ',
            3,
            0,
            $now
        ]);
        $this->db->execute([
            'Fråga 5?',
            'Suspendisse eget rutrum mauris. Morbi dictum vulputate pulvinar. Sed feugiat lobortis arcu, ut feugiat mauris sagittis a. Nulla leo ante, interdum id accumsan sit amet, tempor nec urna. ',
            3,
            0,
            $now
        ]);
        $this->db->execute([
            'Fråga 6?',
            'Suspendisse eget rutrum mauris. Morbi dictum vulputate pulvinar. Sed feugiat lobortis arcu, ut feugiat mauris sagittis a. Nulla leo ante, interdum id accumsan sit amet, tempor nec urna. ',
            1,
            0,
            $now
        ]);

    }
}

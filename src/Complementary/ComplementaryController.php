<?php

namespace Anax\Complementary;

/**
*  A class to manage all complementary view fields
* 
*/
class ComplementaryController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);
    }

    /**
     * Class that calls all other functions
     * 
     */
    public function allAction() 
    {
        $this->sidebarAction();
        $this->footerOneAction();
        $this->footerTwoAction();
        $this->footerThreeAction();
        $this->flashAction();
        $this->topbarAction();
    }

    /**
     * The sidebar action. It controll the sidebar content
     * @return void
     */
    public function sidebarAction()
    {
        $lates = $this->questions->findLates();
        $this->views->add('stack/sidebar', [
            'content' => $lates,
        ],  'sidebar');   
    }
    
    /**
     * The footer 1 action. It controll the footer 1 content.
     * @return void
     */
    public function footerOneAction()
    {
        $this->views->add('stack/footer-col', [
            'title' => 'Footer one',
            'content' => 'Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.',
        ],  'footer-col-1');   
    }

    /**
     * The footer 2 action. It controll the footer 2 content.
     * @return void
     */
    public function footerTwoAction()
    {
        $this->views->add('stack/footer-col', [
            'title' => 'Footer two',
            'content' => 'Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.',
        ],  'footer-col-2');   
    }

    /**
     * The footer 3 action. It controll the footer 3 content.
     * @return void
     */
    public function footerThreeAction()
    {
        $this->views->add('stack/footer-col', [
            'title' => 'Footer three',
            'content' => 'Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.Bacon ipsum dolor sit amet turkey t-bone rump meatball spare ribs porchetta tongue frankfurter swine short loin ham hock prosciutto bresaola. Swine meatloaf sausage, ribeye tail fatback short ribs ham hock porchetta beef tenderloin. Filet mignon ground round turducken strip steak.',
        ],  'footer-col-3');   
    }

    /**
     * The flash action. It controll the flash content.
     * @return void
     */
    public function flashAction()
    {
        $this->views->add('grid/page', [
            'content' => $this->sflash->get(),
        ],  'flash');   
    }

    /**
     * The topbar action. It controlls the topbar content.
     * @return void
     */
    public function topbarAction() 
    {
        // Gets the main structure of the topbar
        $structure = require ANAX_APP_PATH . 'config/topbar.php';
        // is the user logg in ?
        if ($this->auth->isAuthenticated()) {
            // yes
            $user = $this->session->get('user')->username;
            $structure['items'] = [ 
                'user' => [
                    'text' => "{$user}",
                    'url'  => "users/profile/{$user}",
                    'title' => '',
                    'submenu' => [
                        'items' => [
                            'ask' => [
                                'text' => 'Fråga',
                                'url' => 'questions/ask',
                                'title' => 'Ställ en fråga',
                            ],
                            'logout' => [
                                'text' => 'Logga ut',
                                'url' => 'users/logout',
                                'title' => '',
                            ],
                        ],
                    ],
                ],
            ];
        } else {
            // no
            $structure['items'] =  [
                'login' => [
                    'text' => 'Logga in',
                    'url' => 'users/login',
                    'title' => '',
                ],
            ];
        }
        
        $topbar = new \Anax\Navigation\CNavbar();
        $topbar->configure($structure);
        // creates a navbar from the structure
        $this->views->addString($topbar->create(), 'top-bar');
    }

}

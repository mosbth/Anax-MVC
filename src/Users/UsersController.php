<?php
namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $text;
    
    /**
     * Checks the values and calls other functions
     *
     * @return  fetchObj or false Returns false if
     * the validating stuff fails otherwise it returns a obj
     */
    private function checkTypeAndFind($id)
    {
        $user = null;
        if (is_numeric($id)) {
            $user = $this->users->find($id);
        } else if (is_string($id)) {
            $user = $this->users->findByName($id);
        }
        return !empty($user) ? $user : false;
    }

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->auth->initialize();
        $this->text = $this->lang->get('profile_text', true);
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);

        if ($this->auth->isAdmin()) {
            $this->navbar->configure(ANAX_APP_PATH .'config/navbar_users.php');
        }
    }
    /**
     * The index page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->theme->setTitle('Användare');
        $this->views->add('grid/page', [
            'content' => 'Users',
        ]);
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {   
        $this->auth->isAdmin();
        $all = $this->users->findAll();
        $flash = $this->sflash->get();
        $this->theme->setTitle("List all users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "View all users",
        ]);
    }


    public function profileAction($acronym) 
    {
        $this->theme->setTitle("$acronym's profil");
        
        $isOwner = false;

        $user = $this->checkTypeAndFind($acronym);

        if ($user === false) {
            throw new \Anax\Exception\NotFoundException();
        }
        if ($this->session->get('user')->id == $user->id) {
            // de är jag som är ägaren av filen.
            $isOwner = true;
        }
        $anwsers = null;
        $questions = null;
        $this->views->add('stack/profile', [
            'user'      => $user,
            'questions' => $questions,
            'anwsers'   => $anwsers,
            'owner'     => $isOwner,
            'text'      => $this->text,
        ]);
    }

    /**
     * List user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
        $this->isAdmin();
        if(!isset($id)) {
             $this->theme->setTitle('Search user');
            $form = $this->form;
            $form = $form->create(
                [
                    'class' => 'form',
                ],
                [
                'name' => [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Användarnamn eller id',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],
                'submit' => [
                    'type' => 'submit',
                    'callback' => function($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],

            ]);

            $status = $form->check();

            if ($status === true) {

                $acronym = $_SESSION['form-save']['name']['value'];
                $this->session->remove('form-save');

                $url = $this->url->create('users/id/' . $acronym);
                $this->response->redirect($url);

            } else if ($status === false) {
            }

            $this->views->add('grid/page', [
                'content' => $form->getHTML(),
            ]);
        } else {
            $user = $this->checkTypeAndFind($id);

            if ($user === false) {
                throw new \Anax\Exception\NotFoundException();
            }

            $title = "Visa " . ucfirst($user->getProperties()['name']);
            $this->theme->setTitle($title);

            $this->views->add('users/view', [
                'user' => $user,
            ]);
        }
    }

    /**
     * Add new user.
     *
     * @param string $acronym of user to add.
     *
     * @return void
     */
    public function addAction($acronym = null)
    {
        $this->isAdmin();
        $this->theme->setTitle('Lägg till');
        $form = $this->form;
        if (!isset($acronym)) {
            $form = $form->create(
                [
                    'id' => 'add_user',
                    'class' => 'form',
                ],
                [
                'name' => [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Användarnamn',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],
                'submit' => [
                    'type' => 'submit',
                    'callback' => function($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],

            ]);

            $status = $form->check();

            if ($status === true) {
                $acronym = $_SESSION['form-save']['name']['value'];
                $this->session->remove('form-save');
                $url = $this->url->create('users/add/' . $acronym);
                $this->response->redirect($url);

            } else if ($status === false) {
                $form->AddOutput("<p>Failed!</p>");
                $url = $this->url->create();
                $this->response->redirect($url);
            }

            $this->views->add('grid/page',[
                'content' => $form->getHTML(),
            ]);

        } else {
            $now = date("Y-m-d h:i:s");

            $this->users->save([
                'acronym' => $acronym,
                'email' => $acronym . '@mail.se',
                'name' => 'Mr/Mrs ' . $acronym,
                'password' => password_hash($acronym, PASSWORD_DEFAULT),
                'created' => $now,
                'active' => $now,
            ]);

            $url = $this->url->create('users/id/' . $this->users->id);
            $this->response->redirect($url);
        }
    }

    /**
     * Delete user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function deleteAction($id = null)
    {
        $this->isAdmin();
        if (!isset($id)) {
            $this->theme->setTitle('Tabort en användare');

            $form = $this->form;
            $form = $form->create(
                [
                    'class' => 'form',
                ],
                [
                'name' => [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Användarnamn eller id',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],
                'submit' => [
                    'type' => 'submit',
                    'callback' => function($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],

            ]);

            $status = $form->check();

            if ($status === true) {

                $acronym = $_SESSION['form-save']['name']['value'];
                $this->session->remove('form-save');

                $url = $this->url->create('users/delete/' . $acronym);
                $this->response->redirect($url);

            } else if ($status === false) {
                throw new \Anax\Exception\NotFoundException();
            }

            $this->views->add('grid/page',[
                'content' => $form->getHTML(),
            ]);
        } else {
            //checkTypeAndFind
            if(!is_numeric($id)) {
                $user = $this->users->findIdByName($id);
                // Gets the id form the obj
                $id = $user->id;
            }

            // double check if id is numeric
            if(!is_numeric($id)) {
                return false;
            } else {
                $res = $this->users->delete($id);

                $url = $this->url->create('users/list');
                $this->response->redirect($url);
            }
        }
    }

    /**
     * @param  $id id or name of whom to update
     *
     * @return void
     */
    public function updateAction($id = null)
    {
        $this->isAdmin();
        $form = $this->form;
        $user = $this->checkTypeAndFind($id);

        if (!isset($id) || $user === false) {
            $this->theme->setTitle('Uppdatera användare');

            $form = $form->create(
                [
                    'class' => 'form',
                ],
                [
                'name' => [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Användarnamn eller id',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],
                'submit' => [
                    'type' => 'submit',
                    'callback' => function($form) {
                        $form->saveInSession = true;
                        return true;
                    }
                ],

            ]);

            $status = $form->check();

            if ($status === true) {

                $acronym = $_SESSION['form-save']['name']['value'];
                $this->session->remove('form-save');

                $url = $this->url->create('users/update/' . $acronym);
                $this->response->redirect($url);
            }
        } else {
            $user = $user->getProperties();

            $form = $form->create([], [
                'acronym' => [
                    'type' => 'text',
                    'label' => 'Acronym',
                    'required' => true,
                    'validation' => ['not_empty'],
                    'value' => $user['acronym'],
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                    'required' => true,
                    'validation' => ['not_empty'],
                    'value' => $user['email'],
                ],
                'name' => [
                    'type' => 'text',
                    'label' => 'Name',
                    'required' => true,
                    'validation' => ['not_empty'],
                    'value' => $user['name'],
                ],
                'submit' => [
                    'type' => 'submit',
                    'callback' => function ($form) {
                        // spara här
                        $this->users->save([
                            'acronym' => $form->value('acronym'),
                            'email' => $form->value('email'),
                            'name' => $form->value('name'),
                        ]);
                        return true;
                    }
                ],
            ]);
            $status = $form->check();
            if($status === true) {
                $url = $this->url->create('users/list');
                $this->response->redirect($url);
            }
        }

        $this->views->add('grid/page', [
            'content' => $form->getHTML(),
        ]);
    }

    /**
     * Delete (soft) user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function softDeleteAction($id = null)
    {
        $this->isAdmin();
        if (!isset($id)) {
            throw new \Anax\Exception\NotFoundException();
        }

        $now = date("Y-m-d h:i:s");

        $user = $this->checkTypeAndFind($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    /**
     * Undo the soft delete
     *
     * @param $id the id on whom to undoSoftDelete on
     *
     * @return void
     */
    public function softUndoAction($id)
    {
        $this->isAdmin();

        if (!isset($id)) {
            die('Missing id');
        }

        $now = date("Y-m-d h:i:s");

        $user = $this->users->find($id);

        $user->deleted = null;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }

    /**
     * List all active and not deleted users.
     *
     * @return void
     */
    public function activeAction()
    {
        $this->isAdmin();
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Users that are active");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are active",
        ]);
    }

    /**
     * List all inactive and deleted users.
     *
     * @return void
     */
    public function inactiveAction()
    {
        $this->isAdmin();

        $all = $this->users->query()
            ->where('deleted IS NOT NULL')
            ->execute();

        $this->theme->setTitle("Users that are inactive");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are inactive",
        ]);
    }

    /**
     * Changes the status of the user
     *
     * @return void
     */
    public function statusAction($id)
    {
        $this->isAdmin();
        $user = $this->checkTypeAndFind($id);

        if ($user === false) {
            throw new \Anax\Exception\NotFoundException();
        }

        $now = date('Y-m-d h:i:s');

        if (isset($user->active)) {
            $user->active = null;
        } else {
            $user->active = $now;
        }

        $user->save();

        $url = $this->url->create('users/id/' . $user->id);
        $this->response->redirect($url);
    }

    public function logoutAction()
    {
        $user = $this->session->get('user');
        $this->auth->logout();
        $this->sflash->notice("Välkommen åter {$user->username}!");
        $this->response->redirect($this->url->create(''));
    }

    public function loginAction() 
    {
        if ($this->auth->isAuthenticated()) {
            $this->response->redirect($this->url->create(''));
            $this->sflash->notice('Du är redan inloggad.');
            exit();
        }

        $this->theme->setTitle('Logga in');

        $form = $this->form;
        $form = $form->create([],
            [
            'username' => [
                'type' => 'text',
                'name' => 'username',
                'label' => 'Användarnamn',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'password' => [
                'type' => 'password',
                'name' => 'password',
                'lable' => 'Lösenord',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => function($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        $status = $form->check();
        if ($status === true) {
            $acronym = $_SESSION['form-save']['username']['value'];
            $password = $_SESSION['form-save']['password']['value'];
            $this->session->remove('form-save');
            if ($this->auth->authenticate($acronym, $password)) {
                $name = $this->session->get('user')->username;
                $this->sflash->success("Välkommen {$name}");
                $url = $this->url->create('questions');
            } else {
                $this->sflash->error("Fel användarnamn eller lösenord");
                $url = $this->url->create('users/login');
            }
            
            $this->response->redirect($url);
            exit();
        }
        $flash = $this->sflash->get();
        $this->views->add('default/page', [
            'title' => 'Logga in',
            'content' => $form->getHTML(),
        ]);
    }

    /**
     * Setup / resets the database
     *
     * @return  void
     */
    public function setupAction()
    {
        $this->isAdmin();

        $this->theme->setTitle('Setup');

        $this->db->dropTableIfExists('user')->execute();

        $this->db->createTable(
            'user',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'acronym' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)'],
                'name' => ['varchar(80)'],
                'password' => ['varchar(255)'],
                'level' => ['integer', 'DEFAULT 1'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
            'user',
            ['acronym', 'email', 'name', 'password', 'created', 'active']
        );

        $now = date("Y-m-d h:i:s");

        $this->db->execute([
            'admin',
            'admin@dbwebb.se',
            'Administrator',
            password_hash('admin', PASSWORD_DEFAULT),
            $now,
            $now
        ]);

        $this->db->execute([
            'doe',
            'doe@dbwebb.se',
            'John/Jane Doe',
            password_hash('doe', PASSWORD_DEFAULT),
            $now,
            $now
        ]);


        $this->views->add('grid/page', [
            'content' => '<h3>Setup n\' stuff</h3><p>The database has be reseted!</p>'
        ]);
    }

    private function isAdmin() 
    {
        if (!$this->auth->isAdmin()) {
            $this->sflash->error('Du är inte administratör!');
            $this->response->redirect($this->url->create('users/list'));
            exit();
        }
    }
}

<?php

namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
    \Anax\MVC\TRedirectHelpers;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        $this->questions = new \Anax\Questions\CQuestions();
        $this->questions->setDI($this->di);
        $this->answers = new \Anax\Answers\CAnswers();
        $this->answers->setDI($this->di);
        $this->comments = new \Anax\CommentDb\CommentsInDb();
        $this->comments->setDI($this->di);
    }

    /**
     * Setup initial table for users.
     *
     * @return void
     */
    public function setupAction()
    {
        $this->users->init();
    }
    /**
     * Display user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function profidAction($id = null)
    {
        $user = $this->users->find($id);

        // Show users gravatar in big size somewhere here.
        $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'profile',
            'params'    => [$user->acronym ],
        ]);
    }

    /**
     * Display most active users.
     * Sum number of questions and answers contributed.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function mostactiveAction($count = 3)
    {
        $questions = $this->questions->countByUser();
        $answers = $this->answers->countByUser();
        $comments = $this->comments->countByUser();
        $useractivity = array();
        foreach ($questions as $qActivity) {
            $userActivity[$qActivity->user_id] = [
                'activity'  => $qActivity->Cnt,
                'user_id'   => $qActivity->user_id,
            ];
        }
        foreach ($answers as $Activity) {
            $userActivity[$Activity->user_id]['activity'] += $Activity->Cnt;
        }
        foreach ($comments as $Activity) {
            $userActivity[$Activity->user_id]['activity'] += $Activity->Cnt;
        }
        arsort($userActivity);
        $mostActiveUsers = array_slice($userActivity, 0, 3, true);
        $all = array();
        foreach ($mostActiveUsers as $user) {
            $all[] = $this->users->find($user['user_id'])->getProperties();
        }
        $this->views->add('default/page', [
            'title'     => 'Mest aktiva användare',
            'content'     => '',
        ]);
        $this->views->add('users/view_short', [
            'users' => $all,
        ]);
    }

    /**
     * Display user with acronym.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function profileAction($acronym = null)
    {
        $user = $this->users->query()
        ->where('acronym = ' . "'$acronym'")
        ->execute()[0];
        // Get user questions
        // TODO: move queries to model?
        // TODO: use sql count function instead.
        $questions = $this->questions->query()
        ->where('user_id = ' . "'$user->id'")
        ->execute();
        $nrOfQuestions = sizeof($questions);
        // Build route to user questions and send to view.
        $urlQuestions = $this->url->create('questions/list/questions/'.$acronym);

        // Get user answers
        $answers = $this->answers->query()
        ->where('user_id = ' . "'$user->id'")
        ->execute();
        $nrOfAnswers = sizeof($answers);
        // Build route to user answers and send to view.
        $urlAnswers = $this->url->create('questions/list/answers/'.$acronym);

        $gravatarSize = 120;
        $user->gravatar = \Anax\Users\User::getGravatar($user->email, $gravatarSize);
        $this->theme->setTitle("Byggare $acronym");
        $this->views->add('users/view', [
            'user' => $user,
            'urlQuestions' => $urlQuestions,
            'nrOfQuestions' => $nrOfQuestions,
            'urlAnswers' => $urlAnswers,
            'nrOfAnswers' => $nrOfAnswers,
        ]);

        // If user is logged in and profile is logged in users show additional links.
        if ($this->users->loggedIn()) {
            $loggedInUser = $this->users->loggedInUser();
            if ($loggedInUser->id == $user->id) {
                $this->views->add('default/page', [
                    'content' => "Hej {$user->name}. Vad vill du göra? ",
                    'links' => [
                        [
                            'href' => $this->url->create('questions/ask'),
                            'text' => "Fråga en fråga",
                        ],
                        [
                            'href' => $this->url->create('users/logout'),
                            'text' => "Logga ut mig",
                        ],
                        [
                            'href' => $this->url->create("users/update/{$user->id}"),
                            'text' => "Redigera min profil",
                        ],
                        [
                            'href' => $this->url->create('users/add'),
                            'text' => "Lägg till ny användare",
                        ],
                    ],
                ]);
            }
        }
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
        $all = $this->users->findAll();
        $gravatarSize = 80;
        // TODO: move below to User model?
        foreach ($all as $user) {
            $user->gravatar = \Anax\Users\User::getGravatar($user->email, $gravatarSize);
        }

        // Display logged in user.
        if ($this->users->loggedIn()) {
            $user = $this->users->loggedInUser();
            // Show users gravatar in big size somewhere here.
            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'profile',
                'params'    => [$user->acronym ],
                // 'params'    => [$user['acronym'] ],
            ]);
        } else {
            // Dispatch to login Form
            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'login',
                'params'    => [ ],
            ]);
        }

        $this->theme->setTitle("Byggare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Alla byggare",
        ]);
    }
    /**
     * List all users for admin purpose.
     *
     * @return void
     */
    public function listadminAction()
    {
        $all = $this->users->findAll();

        $this->theme->setTitle("List all users");
        $this->views->add('users/list-admin', [
            'users' => $all,
            'title' => "Administrate all users",
        ]);
    }
    /**
     * List user with acronym.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function acronymAction($acronym = null)
    {
        $user = $this->users->query()
        ->where('acronym = ' . "'$acronym'")
        ->execute()[0];
        $this->theme->setTitle("View user with acronym");
        $this->views->add('users/view', [
            'user' => $user,
        ]);
    }
    /**
     * List user with id for admin purpose.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
        $user = $this->users->find($id);

        $this->theme->setTitle("View user with id");
        $this->views->add('users/view', [
            'user' => $user,
        ]);
    }
    /**
     * Display user as card.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function cardAction($id = null, $q_or_a = '', $text = '')
    {
        $gravatarSize = 40;

        $user = $this->users->find($id)->getProperties();
        $gravatar = \Anax\Users\User::getGravatar($user['email'], $gravatarSize);
        $profileUrl = $this->url->create("users/profile/{$user['acronym']}");

        $this->views->add('users/card', [
            'user' => $user,
            'q_or_a' => $q_or_a,
            'gravatar' => $gravatar,
            'text' => $text,
            'profileUrl' => $profileUrl,
        ]);
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
        if ($this->users->loggedIn()) {
            $this->di->session(); // Will load the session service which also starts the session
            $form = $this->createAddUserForm();
            $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
            $this->di->theme->setTitle("Add user");
            $this->di->views->add('default/page', [
                'title' => "Add user",
                'content' => $form->getHTML()
            ]);
        } else {
            $this->redirectTo($this->url->create('users/login'));
        }
    }
    private function createAddUserForm()
    {
        return $this->di->form->create([], [
            'name' => [
                'type'        => 'text',
                'label'       => 'Name of person:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Acronym of person:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitAddUser'],
            ],
            // 'submit-fail' => [
            //     'type'      => 'submit',
            //     'callback'  => [$this, 'callbackSubmitFailAddUser'],
            // ],
        ]);
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitAddUser($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");
        $acronym = $form->Value('acronym');
        // Check for duplicate acronym. Die if exists.
        $all = $this->users->query()
            ->where("acronym = '$acronym'")
            ->execute();
        if (count($all)!=0) {
            die("User with acronym $acronym already registered.");
        }
        // Save user data to database
        $now = gmdate('Y-m-d H:i:s');
        $this->users->save([
            'acronym' => $form->Value('acronym'),
            'email' => $form->Value('email'),
            'name' => $form->Value('name'),
            'password' => md5($acronym),
            'created' => $now,
            'active' => $now,
        ]);

        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
        // $form->AddOutput("<p><b>Acronym: " . $form->Value('acronym') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailAddUser($form)
    {
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }
    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess($form)
    {
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        $this->redirectTo('users/list/');
    }
    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail($form)
    {
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }


    /**
     * Update user.
     *
     * @param string $acronym of user to update.
     *
     * @return void
     */
    public function updateAction($id = null)
    {
        if ($this->users->loggedIn()) {
            $this->di->session(); // Will load the session service which also starts the session
            // Check if valid entry exists.
            $all = $this->users->query()
                ->where("id = '$id'")
                ->execute();
            if (count($all)!=1) {
                die("User with id $id not found.");
            }
            $user = $this->users->find($id);
            unset($user->session);
            unset($user->gravatar);
            $form = $this->createUpdateUserForm($user);
            $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
            $this->di->theme->setTitle("Updatera profil");
            $this->di->views->add('default/page', [
                'title' => "Updatera profil",
                'content' => $form->getHTML()
            ]);
        } else {
            $this->redirectTo($this->url->create('users/login'));
        }
    }
    private function createUpdateUserForm($user = null)
    {
        return $this->di->form->create([], [
            'name' => [
                'type'        => 'text',
                'value'       => $user->name,
                'label'       => 'Name of person:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'acronym' => [
                'type'        => 'text',
                'value'       => $user->acronym,
                'label'       => 'Acronym of person:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'value'       => $user->email,
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'id' => [
                'type'        => 'hidden',
                'value'       => $user->id,
            ],
            'submit' => [
                'type'      => 'submit',
                'label'       => 'Uppdatera',
                'callback'  => [$this, 'callbackSubmitUpdateUser'],
            ],
            'submit-fail' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitFailUpdateUser'],
            ],
        ]);
    }
    public function callbackSubmitUpdateUser($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");
        // Handle update to duplicate acronym. Die if other user already has acronym.
        $id = $form->Value('id');
        $acronym = $form->Value('acronym');
        $all = $this->users->query()
            ->where("id != '$id'")
            ->andwhere("acronym = '$acronym'")
            ->execute();
        if (count($all)==1) {
            die("User with acronym $acronym alredy defined for other user. ");
        }
        // die();
        // Save user data to database
        $now = gmdate('Y-m-d H:i:s');
        $this->users->save([
            'acronym' => $form->Value('acronym'),
            'email' => $form->Value('email'),
            'name' => $form->Value('name'),
            // 'password' => md5($acronym, PASSWORD_DEFAULT),
            // 'created' => $now,
            // 'active' => $now,
        ]);

        // $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
        // $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
        // $form->AddOutput("<p><b>Phone: " . $form->Value('acronym') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailUpdateUser($form)
    {
        $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
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
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $this->redirectTo('users/list/');
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
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $this->redirectTo('users/list/');
    }
    public function undoDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $user = $this->users->find($id);

        $user->deleted = null;
        $user->save();

        $this->redirectTo('users/id/' . $id);
    }
    public function activateAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $user = $this->users->find($id);

        $user->active = gmdate('Y-m-d H:i:s');
        $user->save();

        $this->redirectTo('users/id/' . $id);
    }
    public function deactivateAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $user = $this->users->find($id);

        $user->active = null;
        $user->save();

        $this->redirectTo('users/id/' . $id);
    }
    /**
     * List all active and not deleted users.
     *
     * @return void
     */
    public function activeAction()
    {
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
     * List all inactive and not deleted users.
     *
     * @return void
     */
    public function inactiveAction()
    {
        $all = $this->users->query()
            ->where('active IS NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("Users that are inactive");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are inactive",
        ]);
    }
    /**
     * List all active and not deleted users.
     *
     * @return void
     */
    public function wastebasketAction()
    {
        $all = $this->users->query()
            ->where('deleted is NOT NULL')
            ->execute();

        $this->theme->setTitle("Users that are in wastebasket");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users that are in wastebasket",
        ]);
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logoutAction()
    {
        $this->session->set('user_logged_in', null);
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }
    /**
     * Login user.
     *
     * @return void
     */
    public function loginAction()
    {
        // TODO: Need to sweep session? How?
        // Set saveInSession = false instead.
        $this->di->session(); // Will load the session service which also starts the session
        $form = $this->createLoginForm();
        $form->check([$this, 'callbackLoginSuccess'], [$this, 'callbackLoginSuccess']);
        $this->di->theme->setTitle("Logga in");
        $this->di->views->add('default/page', [
            'title' => "Logga in",
            'content' => $form->getHTML()
        ]);
    }
    private function createLoginForm()
    {
        return $this->di->form->create([], [
            'user' => [
                'type'        => 'text',
                'label'       => 'Användarnamn:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'password' => [
                'type'        => 'password',
                'label'       => 'Lösenord:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitLogin'],
            ],
            'submit-fail' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitFailLogin'],
            ],
        ]);
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitLogin($form)
    {
        // $form->AddOutput("<p>DoSubmit(): Form was submitted.<p>");
        // $form->AddOutput("<p>Do stuff (save to database) and return true (success) or false (failed processing)</p>");
        // Authenticate user.
        // Check if user exists
        // Check if password matches hash
        $userName = $form->Value('user');
        $password = $form->Value('password');
        $user = $this->users->query()
            ->where("acronym = '$userName'")
            ->execute();
        if (sizeof($user)==1) {
            // Set user in session if successful authentication
            if (md5($password)==$user[0]->password) {
                $this->session->set('user_logged_in', $userName);
            }
        }

        // $form->AddOutput("<p><b>Användare: " . $form->Value('user') . "</b></p>");
        // $form->AddOutput("<p><b>Lösenord: " . $form->Value('password') . "</b></p>");
        $form->saveInSession = false;
        return true;
    }
    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFailLogin($form)
    {
        // TODO: Remove this?
        // $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }
    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackLoginSuccess($form)
    {
        // $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        // Redirect to page posted from.
        $this->redirectTo('users/list');
    }
    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackLoginFail($form)
    {
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        // Redirect to comment form.
        // $this->redirectTo();
    }
}

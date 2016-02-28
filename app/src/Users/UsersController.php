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
    }

    /**
     * Setup initial table for users.
     *
     * @return void
     */
    public function setupAction()
    {
        $this->users->init();
        $this->redirectTo('users/list/');
    }
    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
        $all = $this->users->findAll();

        $this->theme->setTitle("List all users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "View all users",
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
     * List user with id.
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
     * Add new user.
     *
     * @param string $acronym of user to add.
     *
     * @return void
     */
    public function add1Action($acronym = null)
    {
        if (!isset($acronym)) {
            die("Missing acronym");
        }

        $now = gmdate('Y-m-d H:i:s');

        $this->users->save([
            'acronym' => $acronym,
            'email' => $acronym . '@mail.se',
            'name' => 'Mr/Mrs ' . $acronym,
            'password' => password_hash($acronym, PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);

        // $url = $this->url->create('users/id/' . $this->users->id);
        // $this->response->redirect($url);
        $this->redirectTo('users/id/' . $this->users->id);
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
        $this->di->session(); // Will load the session service which also starts the session
        $form = $this->createAddUserForm();
        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
        $this->di->theme->setTitle("Add user");
        $this->di->views->add('default/page', [
            'title' => "Add user",
            'content' => $form->getHTML()
        ]);
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
            'submit-fail' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitFailAddUser'],
            ],
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
        // Save user data to database
        $now = gmdate('Y-m-d H:i:s');
        $this->users->save([
            'acronym' => $form->Value('acronym'),
            'email' => $form->Value('email'),
            'name' => 'Mr/Mrs ' . $form->Value('name'),
            'password' => password_hash($acronym, PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);
        // TODO: How to handle duplicate acronym? Exception
        // Try instead create/display form from UsersController?
        // Check if acro exists, if so update instead. or exit with false?

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
        $this->redirectTo('users/id/' . $this->users->id);
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
        $this->di->session(); // Will load the session service which also starts the session
        $user = $this->users->find($id);
        // TODO: check if we found valid entry
        $form = $this->createUpdateUserForm($user);
        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
        $this->di->theme->setTitle("Update user");
        $this->di->views->add('default/page', [
            'title' => "Update user",
            'content' => $form->getHTML()
        ]);
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
            'submit' => [
                'type'      => 'submit',
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
        // Save user data to database
        $now = gmdate('Y-m-d H:i:s');
        $this->users->save([
            'acronym' => $form->Value('acronym'),
            'email' => $form->Value('email'),
            'name' => 'Mr/Mrs ' . $form->Value('name'),
            // 'password' => password_hash($acronym, PASSWORD_DEFAULT),
            // 'created' => $now,
            // 'active' => $now,
        ]);
        // TODO: How to handel password, dates, etc?
        // TODO: How to handle duplicate acronym? Exception
        // Try instead create/display form from UsersController?
        // Check if acro exists, if so update instead. or exit with false?

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
}

<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class FormSmallController
{
    use \Anax\DI\TInjectionaware;



    /**
     * Index action using external form.
     *
     */
    public function indexAction()
    {
        $this->di->session();

        $form = new \Anax\HTMLForm\CFormExample();
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Testing CForm with Anax");
        $this->di->views->add('default/page', [
            'title' => "Try out a form using CForm",
            'content' => $form->getHTML()
        ]);
    }
}

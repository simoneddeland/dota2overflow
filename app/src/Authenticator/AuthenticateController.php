<?php

namespace Anax\Authenticator;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class AuthenticateController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {

    }

    public function loginAction()
    {


        $this->di->theme->setTitle("Logga in");


        if ($this->authenticator->isUserLoggedIn()) {
            $this->views->add('default/logoutneeded');
        } else {

            // Log in with form

            $form = new \Anax\HTMLForm\CFormLogin();
            $form->setDI($this->di);
            $form->check();
            $this->di->views->add('default/page', [
                'title' => "Logga in",
                'content' => $form->getHTML()
            ]);

            $this->di->views->add('users/loginhelp', [], 'sidebar');
        }

    }


    public function logoutAction()
    {
        // Log out with link/button/just getting to this route
        $this->theme->setTitle("Logga ut");
        $this->authenticator->logout();
        $this->di->views->addString("Du har loggat ut.");
    }
}

<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormEditUser extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct($profilecontent)
    {
        parent::__construct([], [
            'profilecontent' => [
                'type'        => 'textarea',
                'label'       => 'Beskrivning till din profilsida:',
                'value'       => $profilecontent,
                'validation'  => [],
            ],
            'newpassword' => [
                'type'        => 'password',
                'label'       => 'Nytt lösenord',
                'validation'  => [],
            ],

            'oldpassword' => [
                'type'        => 'password',
                'label'       => 'Ditt nuvarande lösenord',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Ändra',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
    }



    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {

        //$this->saveInSession = true;

        $now = gmdate('Y-m-d H:i:s');
        $users = new \Anax\Users\User();
        $users->setDI($this->di);
        $user = $users->find($this->di->authenticator->getLoggedInUserId());
        $result = false;
        // User needs to enter old password to change stuff
        if (password_verify($this->Value('oldpassword'), $user->password)) {

            $user->password = !empty($this->Value('newpassword')) ? password_hash($this->Value('newpassword'), PASSWORD_DEFAULT) : $user->password;
            $user->profilecontent = strip_tags($this->Value('profilecontent'));
            $result = $user->save([
                'updated' => $now,
            ]);
        }


        return $result;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->AddOutput("<p><i>Ändringarna genomfördes.</i></p>");
        $this->di->response->redirect($this->di->url->create("users/id/{$this->di->authenticator->getLoggedInUserId()}"));
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Ändringarna genomfördes inte.</i></p>");
        $this->redirectTo();
    }
}

<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormAddUser extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Användarnamn:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'password' => [
                'type'        => 'password',
                'label'       => 'Lösenord',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
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

        // Check if username is valid
        if (preg_match("/^[a-zA-Z0-9_]+$/", $this->Value('acronym')) != 1) {
            return false;
        }

        $result = $users->save([
            'acronym' => $this->Value('acronym'),
            'email' => strip_tags($this->Value('email')),
            'name' => strip_tags($this->Value('name')),
            'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
        ]);
        $this->newid = $this->di->db->lastInsertId();
        return $result;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $url = $this->di->url->create("users/id/{$this->newid}");
        $this->di->authenticator->tryLogin($this->Value('acronym'), $this->Value('password'));
        $this->di->response->redirect($url);
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Något gick fel, kontrollera dina inmatade värden.</i></p>");
        $this->redirectTo();
    }
}

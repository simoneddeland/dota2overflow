<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormUpdateUser extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct($user)
    {
        parent::__construct([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Användarnamn:',                
                'required'    => true,
                'value'       => $user->acronym,
                'validation'  => ['not_empty'],
            ],
            'id' => [
                'type'        => 'hidden',
                'required'    => true,
                'value'       => $user->id,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'required'    => true,
                'value'       => $user->email,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn',
                'required'    => true,
                'value'       => $user->name,
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
        $result = $users->save([
            'id'    => $this->Value('id'),
            'acronym' => $this->Value('acronym'),
            'email' => $this->Value('email'),
            'name' => $this->Value('name'),
            'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'updated' => $now,
        ]);

        return $result;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $url = $this->di->url->create('users/list');
        $this->di->response->redirect($url);
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Something went wrong when processing the form.</i></p>");
        $this->redirectTo();
    }    
}

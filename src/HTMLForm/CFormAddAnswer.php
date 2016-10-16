<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormAddAnswer extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($id)
    {
        $this->id = $id;
        parent::__construct([], [
            'title' => [
                'type'        => 'text',
                'label'       => 'Rubrik för ditt svar',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Ditt svar:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Lägg till ditt svar',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
        $this->form['legend'] = "Nytt svar";
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
        $uid = $this->di->authenticator->getLoggedInUserId();

        $rootnode = $this->id;
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        if (!$post->idExists($rootnode)) {
            return false;
        }
        
        $now = gmdate('Y-m-d H:i:s');
        $result = $post->save([
            'uid'   => $uid,
            'rootnode' => $rootnode,
            'title' =>  strip_tags($this->Value('title')),
            'content' => strip_tags($this->Value('content')),
            'created' => $now,
            'active' => $now,
        ]);

        $user = new \Anax\Users\User();
        $user->setDI($this->di);
        $user->setActiveNow($uid);

        return $result;
        
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->redirectTo($this->di->url->create("post/view/{$this->id}"));
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Svaret kunde inte sparas.</i></p>");
        $this->redirectTo();
    }
}

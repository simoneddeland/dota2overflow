<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormEditComment extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($id, $content)
    {
        $this->id = $id;
        parent::__construct([], [

            'content' => [
                'type'        => 'textarea',
                'label'       => 'Din kommentar:',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $content,
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Ändra din kommentar',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
        $this->form['legend'] = "Ändra";
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
        $now = gmdate('Y-m-d H:i:s');
        $comment = new \Anax\Comment\Comment();
        $comment->setDI($this->di);
        $comment->find($this->id);
        
        if ($comment == null || $comment->uid != $uid) {
            return false;
        }

        $this->pid = $comment->pid;
        $result = $comment->save([
            'content' => strip_tags($this->Value('content')),
            'updated' => $now,
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
        $this->redirectTo($this->di->url->create("post/view/{$this->pid}"));
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Något gick fel när kommentaren skulle sparas.</i></p>");
        $this->redirectTo();
    }
}

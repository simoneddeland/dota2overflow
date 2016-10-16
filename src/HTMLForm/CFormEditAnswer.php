<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormEditAnswer extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($pid, $content)
    {
        $this->pid = $pid;
        parent::__construct([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Ditt svar:',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $content,
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Ändra ditt svar',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
        $this->form['legend'] = "Ändra svar";
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
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $post->find($this->pid);

        // No unauthorized access
        if ($post->uid != $uid) {
            return false;
        }

        if ($post->rootnode == null) {
            return false;
        }
        
        $now = gmdate('Y-m-d H:i:s');
        $result = $post->save([
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
        $this->AddOutput("<p><i>Svaret kunde inte ändras.</i></p>");
        $this->redirectTo();
    }
}

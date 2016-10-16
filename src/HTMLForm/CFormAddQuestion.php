<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormAddQuestion extends \Mos\HTMLForm\CForm
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

            'title' => [
                'type'        => 'text',
                'label'       => 'Rubrik för din fråga',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Din fråga:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'tags' => [
                'type'        => 'text',
                'label'       => 'Taggar',
                'required'    => false,                             
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Lägg till din fråga',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
        $this->form['legend'] = "Ny fråga";
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
        $user = new \Anax\Users\User();
        $user->setDI($this->di);
        $user->setActiveNow($uid);
        $now = gmdate('Y-m-d H:i:s');
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $result = $post->save([
            'uid'   => $uid,
            'title' =>  strip_tags($this->Value('title')),
            'content' => strip_tags($this->Value('content')),
            'created' => $now,
            'active' => $now,
        ]);
        
        $pid = $this->di->db->lastInsertId();
        $this->newId = $pid;
        // Remove whitespace
        $tags = preg_replace('/\s+/', '', $this->Value('tags'));
        $tagsArray = explode(',', $tags);
        $tagResult = true;

        // Add tags if there are any
        if (!empty($tagsArray[0])) {
            foreach ($tagsArray as $tag) {
                $tagObj = new \Anax\Tag\Tag();
                $tagObj->setDI($this->di);
                $tag = strip_tags($tag);
                $tid = 0;
                if (!$tagObj->tagExists($tag) && $tag != "") {
                    $this->di->db->execute("INSERT INTO tag ('name') VALUES(?)", [$tag]);
                    $tid = $this->di->db->lastInsertId();
                } else {
                    $tid = $tagObj->getId($tag);
                }
                $this->di->db->execute("INSERT INTO post2tag ('tid', 'pid') VALUES(?, ?)", [$tid, $pid]);

            }
        }


        
        return $result && $tagResult;
        
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->redirectTo($this->di->url->create("post/view/{$this->newId}"));
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Något gick fel när frågan skulle sparas.</i></p>");
        $this->redirectTo();
    }
}

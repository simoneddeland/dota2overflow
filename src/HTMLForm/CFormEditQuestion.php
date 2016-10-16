<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormEditQuestion extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionAware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($pid, $postContent, $tagList)
    {
        $this->pid = $pid;
        parent::__construct([], [
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Din fråga:',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $postContent,
            ],
            'tags' => [
                'type'        => 'text',
                'label'       => 'Taggar',
                'required'    => false,   
                'value'       => $tagList,                          
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Ändra din fråga',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);
        $this->form['legend'] = "Ändring av fråga";
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
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $post->find($this->pid);

        // No unauthorized access
        if ($post->uid != $uid ||$post->rootnode != null) {
            return false;
        }

        $result = $post->save([
            'content' => strip_tags($this->Value('content')),
            'updated' => $now,
            'active' => $now,
        ]);
        
        $pid = $this->pid;

        // Remove all old tags
        $this->di->db->execute("DELETE FROM post2tag WHERE pid = ?", [$pid]);

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
                $tagResult = $this->di->db->execute("INSERT INTO post2tag ('tid', 'pid') VALUES(?, ?)", [$tid, $pid]);

            }
        }

        $user = new \Anax\Users\User();
        $user->setDI($this->di);
        $user->setActiveNow($uid);
        
        return $result && $tagResult;
        
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
        $this->AddOutput("<p><i>Något gick fel när frågan skulle sparas.</i></p>");
        $this->redirectTo();
    }
}

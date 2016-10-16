<?php

namespace Anax\Vote;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class VoteController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {

        $this->post = new \Anax\Post\Post();
        $this->post->setDI($this->di);
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        $this->vote = new \Anax\Vote\Vote();
        $this->vote->setDI($this->di);
        
    }

    public function upAction($id)
    {
        if (!$this->post->idExists($id)) {
            $this->redirectTo($this->url->create(''));
        } elseif (!$this->authenticator->isUserLoggedIn()) {
            $this->views->add('default/loginneeded');
        } else {
            $this->user->find($this->authenticator->getLoggedInUserId());

            // Does vote already exist?
            if ($this->vote->tryGet($this->user->id, $id)) {                
                // Change negative to positive
                if ($this->vote->value != 1) {
                    $this->vote->value = 1;
                    $this->vote->save();
                } else {
                    // Delete if positive
                    $this->vote->delete($this->vote->id);
                }              
                
            } else {
                $this->vote->save([
                    'uid' => $this->user->id,
                    'pid' => $id,
                    'value' => 1,
                ]);                
            }
            
            $this->redirectTo($this->url->create("post/view/{$id}"));
        }
    }

    public function downAction($id)
    {
        if (!$this->post->idExists($id)) {
            $this->redirectTo($this->url->create(''));
        } elseif (!$this->authenticator->isUserLoggedIn()) {
            $this->views->add('default/loginneeded');
        } else {
            $this->user->find($this->authenticator->getLoggedInUserId());

            // Does vote already exist?
            if ($this->vote->tryGet($this->user->id, $id)) {                
                // Change negative to positive
                if ($this->vote->value != -1) {
                    $this->vote->value = -1;
                    $this->vote->save();
                } else {
                    // Delete if positive
                    $this->vote->delete($this->vote->id);
                }              
                
            } else {
                $this->vote->save([
                    'uid' => $this->user->id,
                    'pid' => $id,
                    'value' => -1,
                ]);                
            }
            
            $this->redirectTo($this->url->create("post/view/{$id}"));
        }
    }    
}

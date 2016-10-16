<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {

        $this->comment = new \Anax\Comment\Comment();
        $this->comment->setDI($this->di);
        $this->post = new \Anax\Post\Post();
        $this->post->setDI($this->di);
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        $this->theme->addStylesheet('css/posts.css');
    }
    
    public function addAction($pid)
    {
        $this->theme->setTitle('Ny kommentar');
        if ($this->authenticator->isUserLoggedIn() && $this->post->idExists($pid)) {
            $form = new \Anax\HTMLForm\CFormAddComment($pid);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ny kommentar",
                    'content' => $form->getHTML()
                ]);     
        } else {
            $this->views->add('default/loginneeded');
        }
    }

    public function editAction($id)
    {

        $this->theme->setTitle('Ändra kommentar');
        $comment = new \Anax\Comment\Comment();
        $comment->setDI($this->di);
        $comment->find($id);

        if ($this->authenticator->getLoggedInUserId() == $comment->uid) {
            $form = new \Anax\HTMLForm\CFormEditComment($id, $comment->content);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ändring av kommentar",
                    'content' => $form->getHTML()
                ]);     
        } else {
            $this->views->add('default/accessdenied');
        } 
    }
}

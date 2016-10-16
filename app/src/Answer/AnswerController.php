<?php
namespace Anax\Answer;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class AnswerController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->posts = new \Anax\Post\Post();
        $this->posts->setDI($this->di);
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        $this->theme->addStylesheet('css/posts.css');
    }

    public function addanswerAction($id)
    {
        $this->theme->setTitle('Nytt svar');
        if ($this->authenticator->isUserLoggedIn()) {
            $form = new \Anax\HTMLForm\CFormAddAnswer($id);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ny fråga",
                    'content' => $form->getHTML()
                ]);     
        } else {
            $this->views->add('default/loginneeded');
        }
          
    }

    public function editAction($id)
    {

        $this->theme->setTitle('Ändra svar');
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $post->find($id);

        if ($this->authenticator->getLoggedInUserId() == $post->uid) {
            $form = new \Anax\HTMLForm\CFormEditAnswer($id, $post->content);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ändring av svar",
                    'content' => $form->getHTML()
                ]);     
        } else {
            $this->views->add('default/accessdenied');
        } 
    }
}

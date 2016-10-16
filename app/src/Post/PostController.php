<?php

namespace Anax\Post;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class PostController implements \Anax\DI\IInjectionAware
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
        $this->posts = new \Anax\Post\Post();
        $this->posts->setDI($this->di);
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
    }

    /**
     * View latest Posts
     *
     * @return void
     */
    public function viewLatestAction()
    {
        $this->theme->setTitle("Frågor");

        $all = $this->posts->getLatestQuestions();
        $allQuestionInfo = array();
        foreach ($all as $questionInfo) {
            // "Casting" CDatabaseBasic to Post
            $question = new \Anax\Post\Post();
            $question->setDI($this->di);
            $question->setProperties(get_object_vars($questionInfo));
            $allQuestionInfo[] = $question->getQuestionInfo(true);
        }        

        $this->views->add('post/posts-simple', [
            'posts' => $allQuestionInfo,
            'title' => "Senaste 5 frågorna"
        ]);

        $tagInfo = $this->tags->getMostPopular();
        $tagInfoArray = array();
        foreach ($tagInfo as $tag) {
            $tagInfoArray[] = get_object_vars($tag);
        }

        $this->views->add('post/sidebar', [
            'tags' => $tagInfoArray,
        ], 'sidebar');

        $this->views->add('default/welcome', [], 'flash');

        $activeUsersArray = array();
        $activeUsers = $this->user->mostRecentlyActive();
        foreach ($activeUsers as $activeUser) {
            $activeUsersArray[] = get_object_vars($activeUser);
        }

        $this->views->add('users/active', [
            'users' => $activeUsersArray,
        ]);
    }

    /**
     * View all Posts
     *
     * @return void
     */
    public function viewAllAction()
    {
        $this->theme->setTitle("Frågor");

        $all = $this->posts->getAllQuestions();
        $allQuestionInfo = array();
        foreach ($all as $questionInfo) {
            // "Casting" CDatabaseBasic to Post
            $question = new \Anax\Post\Post();
            $question->setDI($this->di);
            $question->setProperties(get_object_vars($questionInfo));
            $allQuestionInfo[] = $question->getQuestionInfo(true);
        }        

        $this->views->add('post/posts-simple', [
            'posts' => $allQuestionInfo,
            'title' => "Alla frågor"
        ]);

        $this->views->add('post/listallhelp', [], 'sidebar');     

    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($id)
    {
        $this->theme->setTitle("Fråga");
        $question = $this->posts->find($id);

        if ($question->rootnode != null) {
            $this->redirectTo($this->url->create("post/view/{$question->rootnode}"));
        }
        $questionInfo = $question->getQuestionInfo();

        $this->views->add('post/posts', [
            'question' => $questionInfo,
            'loggeduser' => $this->authenticator->getLoggedInUserId(),
        ]);

        $this->views->add('post/listallhelp', [], 'sidebar');           
    }

    public function editAction($id)
    {

        $this->theme->setTitle('Ändra fråga');
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $post->find($id);

        if ($this->authenticator->getLoggedInUserId() == $post->uid && $post->rootnode == null) {
            //$tags = $this->db->executeFetchAll("SELECT tag.*, post2tag.* FROM post2tag JOIN tag ON post2tag.tid = tag.id WHERE post2tag.pid = ?", [$id]);
            $ress = $this->db->select("tag.*, post2tag.*")
                             ->from("post2tag")
                             ->join("tag", "post2tag.tid = tag.id")
                             ->where("post2tag.pid = ?")
                             ->execute([$id]);
            $tags = $this->db->fetchAll();
            $tagsArray = [];
            foreach ($tags as $tag) {
                $tagsArray[] = $tag->name;
            }
            $tagList = implode(',', $tagsArray);
            $form = new \Anax\HTMLForm\CFormEditQuestion($id, $post->content, $tagList);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ändring av fråga",
                    'content' => $form->getHTML()
                ]);     
            $this->views->add('post/newquestionhelp', [], 'sidebar');                     
        } else {
            $this->views->add('default/accessdenied');
        } 
    }

    public function addquestionAction()
    {
        $this->theme->setTitle('Ny fråga');
        if ($this->authenticator->isUserLoggedIn()) {
            $form = new \Anax\HTMLForm\CFormAddQuestion();
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ny fråga",
                    'content' => $form->getHTML()
                ]);
            $this->views->add('post/newquestionhelp', [], 'sidebar');     
        } else {
            $this->views->add('default/loginneeded');
        }
          
    }
}

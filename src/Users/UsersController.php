<?php
namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        $this->theme->addStylesheet('css/users.css');
    }

    /**
    * List all users.
    *
    * @return void
    */
    public function listAction()
    {
        
        $all = $this->users->findAll();   
        $users = array();
        foreach ($all as $user) {
            $users[] = $user->getProperties();
        }     

        // Sort by acronym
        usort($users, function ($a, $b) {
            $result = strcasecmp($a['acronym'], $b['acronym']);
            return $result;
        });
        
        $this->theme->setTitle("Alla användare");
        $this->views->add('users/list-all', [
            'users' => $users,
            'title' => "Alla användare",
        ]);
    }

    /**
    * Default action (list all users)
    *
    * @return void
    */
    public function indexAction()
    {
        $this->dispatcher->forward([
            'controller' => 'users',
            'action'     => 'list',
        ]);
    }

    /**
    * List user with id.
    *
    * @param int $id of user to display
    *
    * @return void
    */
    public function idAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
        
        $user = $this->users->find($id);

        if (!$user) {
            die("Could not find user");
        }
        $userInfo = $user->getProperties();
        // Add default text 
        $userInfo['profilecontent'] = $userInfo['profilecontent'] ? $userInfo['profilecontent'] : "Användaren har inte skrivit någon beskrivning.";
        // Markdown
        $userInfo['profilecontent'] = $this->textFilter->doFilter($userInfo['profilecontent'], 'markdown');

        // Get info about posts asked by the user
        $post = new \Anax\Post\Post();
        $post->setDI($this->di);
        $userPosts = $post->query()
            ->where("uid = ?")
            ->execute([$id]);
        $postsInfo = array();
        $answersInfo = array();
        foreach ($userPosts as $questionInfo) {
            // "Casting" CDatabaseBasic to Post
            $question = new \Anax\Post\Post();
            $question->setDI($this->di);
            $question->setProperties($questionInfo->getProperties());
            if ($question->rootnode != null) {
                $answersInfo[] = $question->getQuestionInfo(true);
            } else {
                $postsInfo[] = $question->getQuestionInfo(true);
            }            
        } 

        $this->theme->setTitle("View user with id");
        $this->views->add('users/view', [
            'user' => $userInfo,
            'posts' => $postsInfo,
            'answers' => $answersInfo,
        ]);
    }

    /**
    * Add new user.
    *
    * @param string $acronym of user to add.
    *
    * @return void
    */
    public function addAction()
    {

        if ($this->authenticator->isUserLoggedIn()) {
            $this->di->views->add('default/logoutneeded');
            return;
        }
        $form = new \Anax\HTMLForm\CFormAddUser();
        $form->setDI($this->di);
        $form->check();

        $this->di->theme->setTitle("Lägg till en ny användare");
        $this->di->views->add('default/page', [
            'title' => "Lägg till en ny användare",
            'content' => $form->getHTML()
        ]);
    }

    public function updateAction()
    {
        if ($this->authenticator->isUserLoggedIn()) {
            $user = $this->users->find($this->authenticator->getLoggedInUserId());
            $form = new \Anax\HTMLForm\CFormEditUser($user->profilecontent);
            $form->setDI($this->di);
            $form->check();
            $this->views->add('default/page', [
                    'title' => "Ändra användare",
                    'content' => $form->getHTML()
                ]);     
            $this->views->add('users/edit-help', [], 'sidebar');                     
        } else {
            $this->views->add('default/loginneeded');
        }       

    }
}

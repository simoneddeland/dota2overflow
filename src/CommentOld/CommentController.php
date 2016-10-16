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
        //$this->comments = new \Anax\Comment\CommentsInSession();
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
        $this->theme->addStylesheet('css/comments.css');
    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($pageName = '', $redirect = '')
    {
        $pageName = empty($pageName) ? $this->request->getRoute() : $pageName;
        $redirect = empty($redirect) ? $pageName : $redirect;
        //$all = $this->comments->findAll($pageName);
        $all = $this->comments->query()
            ->where("pagename = '$pageName'")
            ->execute();

        $this->views->add('comment/comments', [
            'comments' => $all,
            'pageName' => $pageName,
            'redirect' => $redirect,
        ]);


        $this->session();

        $form = new \Anax\HTMLForm\CFormAddComment($pageName, $redirect);
        $form->setDI($this->di);
        $form->check();
        $this->views->add('default/page', [
                'title' => "",
                'content' => $form->getHTML()
            ]);
    }



    public function editAction($id, $redirect = '')
    {

        $comment = $this->comments->find($id);

        if (!$comment) {
            die("Could not find comment");
        }

        $redirect = empty($redirect) ? $comment->pagename : $redirect;
        $form = new \Anax\HTMLForm\CFormEditComment($comment, $redirect);
        $form->setDI($this->di);
        $form->check();
        $this->views->add('default/page', [
                'title' => "",
                'content' => $form->getHTML()
            ]);       
    }

    public function deleteAction($id, $redirect = '')
    {

        if (!isset($id)) {
            die("Missing id");
        }
        $comment = $this->comments->find($id);

        if (!$comment) {
            die("Could not find comment");
        }
                
        $redirect = empty($redirect) ? $comment->pagename : $redirect;
        $res = $this->comments->delete($id);

        $this->response->redirect($redirect);
    }
}

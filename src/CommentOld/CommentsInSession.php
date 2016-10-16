<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment, $pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        $comments = $this->session->get($commentPageName, []);
        $comments[] = $comment;
        $this->session->set($commentPageName, $comments);
    }



    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        return $this->session->get($commentPageName, []);
    }


    public function findById($id, $pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        $comments = $this->session->get($commentPageName, []);
        return $comments[$id];
    }

    public function edit($id, $comment, $pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        $comments = $this->session->get($commentPageName, []);
        $comments[$id] = $comment;
        $this->session->set($commentPageName, $comments);
    }

    public function delete($id, $pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        $comments = $this->session->get($commentPageName, []);
        array_splice($comments, $id, 1);
        $this->session->set($commentPageName, $comments);        
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll($pageName = '')
    {
        $commentPageName = $pageName . 'comments';
        $this->session->set($commentPageName, []);
    }
}

<?php

namespace Anax\Post;

/**
 * Model for Users.
 *
 */
class Post extends \Anax\MVC\CDatabaseModel
{


    public function getLatestQuestions()
    {

        //$query = "SELECT * FROM post WHERE rootnode IS NULL ORDER BY created DESC LIMIT 5";
        $this->db->select()
                 ->from("post")
                 ->where("rootnode IS NULL")
                 ->orderBy("created DESC")
                 ->limit("5")
                 ->execute();
        $res = $this->db->fetchAll();
        return $res;
    }

    public function getAllQuestions()
    {

        //$query = "SELECT * FROM post WHERE rootnode IS NULL ORDER BY created DESC";
        $this->db->select()
                 ->from("post")
                 ->where("rootnode IS NULL")
                 ->orderBy("created DESC")
                 ->execute();
                 
        $res = $this->db->fetchAll();
        return $res;
    }

    public function getQuestionInfo($onlyRootNode = false)
    {
        $questionInfo = $this->getProperties();

        $questionInfo['user'] = $this->getUserInfo();
        $questionInfo['tags'] = $this->getTagInfo();
        
        // Markdown
        $questionInfo['content'] = $this->textFilter->doFilter($questionInfo['content'], 'markdown');

        // Vote score
        $questionInfo['score'] = $this->getPostScore();

        $answers = $this->query()
            ->where("rootnode = ?")
            ->execute([$this->id]);

        $questionInfo['numAnswers'] = sizeof($answers);

        if ($onlyRootNode == false) {            
            foreach ($answers as $answerProps) {
                $answer = new \Anax\Post\Post();
                $answer->setDI($this->di);
                $answer->setProperties($answerProps->getProperties());
                $answerInfo = $answer->getProperties();
                $answerInfo['comments'] = $answer->getCommentsInfo();
                $answerInfo['user'] = $answer->getUserInfo();
                $answerInfo['tags'] = $answer->getTagInfo();
                $answerInfo['score'] = $answer->getPostScore();             

                // Markdown
                $answerInfo['content'] = $this->textFilter->doFilter($answerInfo['content'], 'markdown');
                
                $questionInfo['answers'][] = $answerInfo;
            }
            $questionInfo['comments'] = $this->getCommentsInfo();
        }

        return $questionInfo;
    }

    public function getCommentsInfo()
    {
        $commentObj = new \Anax\Comment\Comment();
        $commentObj->setDI($this->di);
        $commentsInfo = array();
        $comments = $commentObj->query()
            ->where("pid = ?")
            ->execute([$this->id]);

        foreach ($comments as $comment) {
            $currentCommentInfo = $comment->getProperties();
            $currentCommentInfo['user'] = $this->getUserInfo($comment->uid);
            // Markdown
            $currentCommentInfo['content'] = $this->textFilter->doFilter($currentCommentInfo['content'], 'markdown');
            $commentsInfo[] = $currentCommentInfo;
        }
        return $commentsInfo;
    }

    public function getUserInfo($optionalId = null)
    {

        // Use optionalId if specified
        $postUser = new \Anax\Users\User();
        $postUser->setDI($this->di);
        if (is_null($optionalId)) {        
            $postUser->find($this->uid);
        } else {
            $postUser->find($optionalId);
        }
        return $postUser->getProperties();
    }


    public function getTagInfo()
    {
        /*$query = "SELECT t.*, p.* FROM tag as t INNER JOIN post2tag as p ON t.id = p.tid WHERE p.pid = ?";        
        $this->db->execute($query, [$this->id]);*/
        $this->db->select("t.*, p.*")
                 ->from("tag as t")
                 ->join("post2tag as p", "t.id = p.tid")
                 ->where("p.pid = ?")
                 ->execute([$this->id]);

        // Get as array to match other data    
        $this->db->setFetchMode(\PDO::FETCH_ASSOC);
        $tagInfo = $this->db->fetchAll();
        $this->db->setFetchMode(\PDO::FETCH_OBJ);

        return $tagInfo;
    }

    public function getPostScore()
    {
        $this->db->select("SUM(value) as score")
                 ->from("vote")
                 ->where("pid = ?")
                 ->execute([$this->id]);
        $res = $this->db->fetchAll();
        
        // Dont return null, return 0 instead
        return $res[0]->score ? $res[0]->score : 0;
    }
}

<?php

namespace Anax\Tag;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class TagController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->post = new \Anax\Post\Post();
        $this->post->setDI($this->di);
        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);

    }

    public function listAction()
    {

        $tagInfo = $this->tags->findAll();
        $tagInfoArray = array();
        foreach ($tagInfo as $tag) {
            $tagInfoArray[] = $tag->getProperties();
        }
        
        // Sort by tag name
        usort($tagInfoArray, function ($a, $b) {
            $result = strcasecmp($a['name'], $b['name']);
            return $result;
        });

        $this->views->add('tag/list', [
            'tags' => $tagInfoArray
        ]);
    }

    /**
     * View all posts with a certain tag
     *
     * @return void
     */
    public function viewAction($tag)
    {
        $this->theme->setTitle("Frågor med en viss tag");

        $query = "SELECT p.* FROM post2tag as t JOIN post as p ON t.pid = p.id JOIN tag as tag ON tag.id = t.tid WHERE name = ? ORDER BY p.created DESC";        
        $this->db->execute($query, [$tag]);

        $postsWithTag = $this->db->fetchAll();

        $allQuestionInfo = array();
        foreach ($postsWithTag as $questionInfo) {

            $question = new \Anax\Post\Post();
            $question->setDI($this->di);
            $question->setProperties(get_object_vars($questionInfo));
            $allQuestionInfo[] = $question->getQuestionInfo(true);
        }        

        $this->views->add('post/posts-simple', [
            'posts' => $allQuestionInfo,
            'title' => "Frågor med taggen " . $tag,
        ]);
    }
}

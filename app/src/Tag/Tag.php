<?php

namespace Anax\Tag;

/**
 * Model for Users.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{

    public function tagExists($tag)
    {
        $this->db->select()
                 ->from("tag")
                 ->where("name = ?")
                 ->execute([$tag]);
        $res = $this->db->fetchAll();
        return count($res) > 0;
    }

    public function getId($tagname)
    {
        $query = "SELECT * FROM tag WHERE name = ?";
        $this->db->select()
                 ->from("tag")
                 ->where("name = ?")
                 ->execute([$tagname]);
        $res = $this->db->fetchAll();
        return $res[0]->id;
    }

    public function getMostPopular()
    {
        /*$query = "SELECT
            p.tid,
            COUNT(*) AS `num`,
            t.name
            FROM
            post2tag as p
            JOIN tag as t ON p.tid = t.id
            GROUP BY
            tid
            ORDER BY num DESC
            LIMIT 5";
        $res = $this->db->executeFetchAll($query);*/

        $this->db->select("p.tid, COUNT(*) AS `num`, t.name")
                 ->from("post2tag as p")
                 ->join("tag as t", "p.tid = t.id")
                 ->groupBy("tid")
                 ->orderBy("num DESC")
                 ->limit("5")
                 ->execute();
        $res = $this->db->fetchAll();
        return $res;
    }
}

<?php

namespace Anax\Vote;

/**
 * Model for votes
 *
 */
class Vote extends \Anax\MVC\CDatabaseModel
{
    public function tryGet($uid, $pid)
    {
        $this->db->select()
                 ->from('vote')
                 ->where('uid = ? AND pid = ?')
                 ->execute([$uid, $pid]);
        $res = $this->db->fetchAll();
        if (sizeof($res) > 0) {
            $this->find($res[0]->id);
            return true;
        } else {
            return false;
        }
    }
}

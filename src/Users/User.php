<?php

namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

    public function mostRecentlyActive()
    {
        $this->db->select()
                 ->from("user")
                 ->orderBy("active DESC")
                 ->limit("3")
                 ->execute();
        $query = "SELECT * FROM user ORDER BY active DESC LIMIT 3";
        $res = $this->db->executeFetchAll($query);
        return $res;
    }

    public function setActiveNow($id)
    {
        $user = new \Anax\Users\User();
        $user->setDI($this->di);
        $user->find($id);
        $user->active = gmdate('Y-m-d H:i:s');
        $user->save();
    }
}

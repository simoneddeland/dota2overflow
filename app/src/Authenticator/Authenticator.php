<?php

namespace Anax\Authenticator;

/**
 * Authenticator used to log in and check if a user is logged in
 *
 */
class Authenticator implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $loggedInUserId;

    public function __construct()
    {        
        if (isset($_SESSION['logged_uid'])) {
            $this->loggedInUserId = $_SESSION['logged_uid'];
        }    
    }

    public function isUserLoggedIn()
    {
        return $this->loggedInUserId != null;
    }

    public function getLoggedInUserId()
    {
        return $this->loggedInUserId;
    }

    public function tryLogin($username, $password)
    {

        // Get user info from DB
        $user = new \Anax\Users\User();
        $user->setDI($this->di);
        $loggedUsers = $user->query()
            ->where("LOWER(acronym) = ?")
            ->execute([strtolower($username)]);
        
        // Was a correct username used?
        if (sizeof($loggedUsers) == 0) {
            return false;
        }

        // Info of the user
        $loggedUser = $loggedUsers[0];

        $result = false;

        // Check if entered password is correct
        if (password_verify($password, $loggedUser->password)) {
            $_SESSION['logged_uid'] = $loggedUser->id;
            $result = true;
        }

        return $result;
    }

    public function logout()
    {
        unset($_SESSION['logged_uid']);
        $this->loggedInUserId = null;
    }
}

<?php

require_once 'DB.php';

class UserManager
{

    private $DB = '';
    private $userID = null;

    public function __construct() {
        $this->DB = new DB();
    }

    public function createUser($login, $pass, $name, $email, $key_public) {

        if($this->checkUser($login)) {
            return -1;
        }

        return $this->DB->write(
            'users',
            [
                'login'    => $login,
                'password' => $pass,
                'name'     => $name,
                'email'    => $email,
                'key_public'      => $key_public
            ]
        );
    }

    public function checkUser($login) {
        $rezult = $this->DB->select(
            'users',
            [
                'login'     => $login,
            ]
        );

        if(is_array($rezult)) {
            return true;
        }
        return false;
    }

    public function getUserByID($id) {
        $rezult = $this->DB->select(
            'users',
            [
                'id'     => $id,
            ]
        );

        if(is_array($rezult)) {
            return $rezult[0];
        }
        return false;
    }

    public function login($login,$password) {

        $rezult = $this->DB->select(
            'users',
            [
                'login'     => $login,
                'password' => $password
            ]
        );

        if(is_array($rezult)) {
            $this->userID = $rezult[0]['id'];
            return true;
        }
        return false;
    }

    /**
     * @return null
     */
    public function getUserID()
    {
        return $this->userID;
    }
}
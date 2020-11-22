<?php

require_once 'DB.php';

class UserManager
{

    private $DB = '';
    private $userID = null;

    public function __construct() {
        $this->DB = new DB();
    }

    public function create_user($login, $pass, $name, $email) {

        if($this->check_user($login)) {
            return false;
        }

        return $this->DB->write(
            'users',
            [
                'login'     => $login,
                'password' => $pass,
                'name'     => $name,
                'email'    => $email
            ]
        );
    }

    public function check_user($login) {
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

    public function get_user_by_id($id) {
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
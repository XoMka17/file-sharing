<?php

require_once 'DB.php';

class UserManager
{

    private $DB = '';

    public function __construct() {
        $this->DB = new DB();
    }

    public function create_user($name, $pass, $email) {

        if($this->check_user($name)) {
            return false;
        }

        return $this->DB->write(
            'users',
            [
                'name'     => $name,
                'password' => $pass,
                'email'    => $email
            ]
        );
    }

    public function check_user($name) {
        $rezult = $this->DB->select(
            'users',
            [
                'name'     => $name,
            ]
        );

        if(is_array($rezult)) {
            return true;
        }
        return false;
    }

    public function login($name,$pass) {

        $rezult = $this->DB->select(
            'users',
            [
                'name'     => $name,
                'password' => $pass,
            ]
        );

        if(is_array($rezult)) {
            return true;
        }
        return false;
    }
}
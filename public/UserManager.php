<?php

require_once 'DB.php';

class UserManager
{

    private $DB = '';
    private $userID = null;

    public function __construct()
    {
        $this->DB = new DB();
    }

    public function createUser($login, $pass, $name, $email, $key_public, $allowed)
    {

        if ($this->checkUser($login)) {
            return -1;
        }

        return $this->DB->write(
            'users',
            [
                'login'      => $login,
                'password'   => $pass,
                'name'       => $name,
                'email'      => $email,
                'key_public' => $key_public,
                'allowed'    => $allowed
            ]
        );
    }

    public function checkUser($login)
    {
        $rezult = $this->DB->select(
            'users',
            [
                'login' => $login,
            ]
        );

        if (is_array($rezult)) {
            return true;
        }
        return false;
    }

    public function getUsersEmailForNotification($senderID) {
        $emails = false;

        $users = $this->getUsers();

        if($users !== false) {
            $emails = array();
            foreach ($users as $user) {
                if($user['allowed'] == 1 && !in_array($user['email'], $emails) && $senderID != $user['id']) {
                    array_push($emails,$user['email']);
                }
            }
        }

        return $emails;
    }

    public function getUsersEmail() {
        $emails = false;

        $users = $this->getUsers();

        if($users !== false) {
            $emails = array();
            foreach ($users as $user) {
                array_push($emails,$user['email']);
            }
        }

        return $emails;
    }

    public function getUsers() {
        $rezult = $this->DB->select('users');

        if (is_array($rezult)) {
            return $rezult;
        }
        return false;
    }

    public function getUserByID($id)
    {
        $rezult = $this->DB->select(
            'users',
            [
                'id' => $id,
            ]
        );

        if (is_array($rezult)) {
            return $rezult[0];
        }
        return false;
    }

    public function login($login, $password)
    {

        $rezult = $this->DB->select(
            'users',
            [
                'login'    => $login,
                'password' => $password
            ]
        );

        if (is_array($rezult)) {
            $this->userID = $rezult[0]['id'];

            return $rezult[0]['allowed'];

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
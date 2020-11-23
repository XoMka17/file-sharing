<?php

require_once '../UserManager.php';

class API
{
    private $UserManager = null;

    public function __construct() {
        $this->UserManager = new UserManager();
    }

    public function getUserPublicKey($id) {
        return $this->UserManager->getUserByID($id)['key_public'];
    }

}
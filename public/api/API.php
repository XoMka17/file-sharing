<?php

require_once '../UserManager.php';
require_once '../BlockChain.php';

class API
{
    private $UserManager = null;
    private $BlockChain = null;

    public function __construct() {
        $this->UserManager = new UserManager();
        $this->BlockChain = new BlockChain();
    }

    public function getUserPublicKey($id) {
        return $this->UserManager->getUserByID($id)['key_public'];
    }

    public function getBlockFileData($id) {
        return $this->BlockChain->getFile($id)['fileData'];
    }
    public function getBlockFile($id) {
        return $this->BlockChain->getFile($id);
    }
}
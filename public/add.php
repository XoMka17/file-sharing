<?php

include_once 'session.php';
require_once 'BlockChain.php';

$BlockChain = new BlockChain();

if(!isset($_FILES['userfile']['name']) && !isset($_FILES['userfile']['tmp_name'])) {
    exit();
}

$BlockChain->addFile($_FILES['userfile']['name'], file_get_contents($_FILES['userfile']['tmp_name']), $_SESSION['user_name']);

header("Location: /");
<?php

require_once 'BlockChain.php';

$BlockChain = new BlockChain();

if(!isset($_FILES['userfile']['name']) && !isset($_FILES['userfile']['tmp_name'])) {
    exit();
}

$BlockChain->addFile($_FILES['userfile']['name'], $_FILES['userfile']['tmp_name'], 'Ira');

header("Location: /");
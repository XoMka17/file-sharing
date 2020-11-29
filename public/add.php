<?php

include_once 'session.php';
require_once 'BlockChain.php';

$BlockChain = new BlockChain();
$BlockChain->addFile($_POST['file_name'], $_POST['file_data'], $_POST['signature'], $_SESSION['user_id']);

echo 1;
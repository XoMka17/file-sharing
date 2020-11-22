<?php

include_once 'session.php';
require_once 'BlockChain.php';

$BlockChain = new BlockChain();


$BlockChain->addFile($_POST['file_name'], $_POST['file_data'], $_POST['signature'], $_SESSION['user_id']);


//var_dump($_FILES['user_file']['name']);
//var_dump($_FILES['user_file']['tmp_name']);
//
//if(!isset($_FILES['user_file']['name']) || !isset($_FILES['user_file']['tmp_name'])) {
//    header("Location: /");
//}
//
//$BlockChain->addFile($_FILES['user_file']['name'], file_get_contents($_FILES['user_file']['tmp_name']), $_SESSION['user_id']);

//header("Location: /");
<?php

require_once 'API.php';

if(isset($_GET['get'])) {
    $get = $_GET['get'];
    $API = new API();

    if($get == 'publicKey') {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            echo '{' . '"publicKey": ' . $API->getUserPublicKey($id) . '}';
        }
        else {
            echo 'Please, set `id` for signature';
        }
    }
    else if($get == 'fileData') {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            echo '{' . '"fileData": "' .  $API->getBlockFileData($id) . '"}';
        }
        else {
            echo 'Please, set `id` for file';
        }
    }
    else if($get == 'file') {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $file = $API->getBlockFile($id);

            echo '{' . '"fileData": "' .  $file . '"}';
        }
        else {
            echo 'Please, set `id` for file';
        }
    }
}
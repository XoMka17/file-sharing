<?php

require_once 'API.php';

if(isset($_GET['get'])) {
    $get = $_GET['get'];
    $API = new API();

    if($get == 'publicKey') {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            echo $API->getUserPublicKey($id);
        }
        else {
            echo 'Please, set `id` for signature';
        }
    }
}
<?php

include_once 'session.php';
require_once 'BlockChain.php';

if(!isset($_GET['block'])) {
    exit();
}

$BlockChain = new BlockChain();

$file = $BlockChain->getFile($_GET['block']);
preg_match('|;base64,(.*)|',$file['fileData'],$fileData);
$file['fileData'] = mb_convert_encoding( $fileData[1], "UTF-8", "BASE64" );


header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="'.$file['fileName'].'"');
header("Content-Length: " . strlen($file['fileData']));
echo $file['fileData'];
exit;
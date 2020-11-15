<?php

include_once 'session.php';
require_once 'BlockChain.php';

if(!isset($_GET['block'])) {
    exit();
}

$BlockChain = new BlockChain();

$file = $BlockChain->getFile($_GET['block']);

header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="'.$file['fileName'].'"');
header("Content-Length: " . strlen($file['fileData']));
echo $file['fileData'];
exit;
?>
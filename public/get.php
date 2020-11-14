<?php

require_once 'BlockChain.php';

if(!isset($_GET['block'])) {
    exit();
}

$BlockChain = new BlockChain();

$file = $BlockChain->getFile($_GET['block']);

$filename = 'result_file_' . $_GET['block'] . '.docx';

header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Content-Length: " . strlen($file));
echo $file;
exit;
?>
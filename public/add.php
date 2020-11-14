<?php

require_once 'BlockChain.php';

$BlockChain = new BlockChain();

$file_content = file_get_contents('./files/test.docx');

$BlockChain->addFile($file_content, 'Ira');
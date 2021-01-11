<?php

$ch = curl_init();

$headers = array();
$headers[] = 'Authorization: Bearer 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';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);



curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"personalizations\": [{\"to\": [{\"email\": \"nazar.10.17k@gmail.com\"}]}],\"from\": {\"email\": \"harbovskairyna05@gmail.com\"},\"subject\": \"Hello, World!\",\"content\": [{\"type\": \"text/plain\", \"value\": \"Heya!\"}]}");

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);
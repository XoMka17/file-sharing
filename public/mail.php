<?php
$to      = 'nazar.10.17k@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = array(
    'From' => 'nazar.10.17k@gmail.com',
);
mail($to, $subject, $message, $headers);
var_dump(mail($to, $subject, $message, $headers));
?>
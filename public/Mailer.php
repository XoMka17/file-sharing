<?php

require_once 'UserManager.php';


class Mailer
{
    private $UserManager = '';

    public function __construct()
    {
        $this->UserManager = new UserManager();
    }

    public function sendNotificationToUsers($senderID) {

        $ch = curl_init();

        $headers = array();
        $headers[] = 'Authorization: Bearer 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';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $emails = $this->UserManager->getUsersEmailForNotification($senderID);

        foreach ($emails as $email) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"personalizations\": [{\"to\": [{\"email\": \"$email\"}]}],\"from\": {\"email\": \"harbovskairyna05@gmail.com\"},\"subject\": \"File Sharing Notification!\",\"content\": [{\"type\": \"text/html\", \"value\": \"File have been sent. Please check it... <a href='http://localhost:8080/'>Click for visit</a>\"}]}");

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
        }

        curl_close($ch);
    }


    public function __destruct()
    {

    }
}
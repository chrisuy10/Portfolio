<?php
include 'email_sender.php';

class EmailBody {
    public function getBody($name) {
        return "
        <html>
        <body>
            <h2>Hello!</h2>
            <p>This is an example HTML email body.</p><br>
            <p><b>Testing HTML email body.</b></p>
            <p>Hello $name</p>
        </body>    
        </html>";
    }
}

$send_to = 'chrisbenedictuy19@gmail.com';
$send_to_name = 'benedict uy';
$subject = 'Test subject';

$name_contact = "Benedict Christian";

$emailBody = new EmailBody();
$body = $emailBody->getBody($name_contact);


$mailer = new Mailer();
    $result = $mailer->sendMail($send_to, $send_to_name, $subject, $body);
echo $result;

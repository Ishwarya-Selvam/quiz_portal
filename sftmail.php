<?php

require_once 'vendor/vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
  ->setUsername('certadder@gmail.com')
  ->setPassword('certadder@123')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['certadder@gmail.com' => 'Certify'])
  ->setTo(['abithavalli.offl@gmail.com' => 'Abitha'])
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);
if($result){

}
else
{
echo "failure";
}
?>

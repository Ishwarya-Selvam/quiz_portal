<?php

require 'vendor/autoload.php';
$apikey ="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";

$email = new \SendGrid\Mail\Mail();
$email->setFrom("saadana.26@gmail.com", "saadanato");
$email->setSubject("Sending testing");
$email->addTo("saadana.264@gmail.com", "saadan");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
/*$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);*/
$sendgrid = new \SendGrid($apikey);
if($sendgrid->send($email));
{
 echo "email has been sent";
}
   
?>

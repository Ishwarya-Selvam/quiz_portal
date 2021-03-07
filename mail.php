<?php
 echo "hello";
    try{
      require 'PHPMailer\src\Exception.php';
      require 'PHPMailer\src\PHPMailer.php';
      require 'PHPMailer\src\SMTP.php';
  
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->SMTPDebug  = 2;  
      $mail->IsSMTP();
      $mail->Host       = "smtp.gmail.com";
      $mail->SMTPAuth   = TRUE;
      $mail->Username   = "saadana.264@gmail.com" ;
      $mail->Password   = "Classic@4321!";
      $mail->SMTPSecure = "ssl";
      $mail->Port       = "465";
      
      echo "hello world";
      $mail->SetFrom("saadana.264@gmail.com", "Mailer");
      $mail->AddAddress("saadana.26@gmail.com", "saadana");
      // // $mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
      // $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
      
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Here is the subject';
      $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      echo 'Message has been sent';
    }
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>


 <?php
 //require_once('/inc/user_controller.php');
require_once('class/class.phpmailer.php');
require_once('class/class.smtp.php');

 include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
  if(!(isset($_SESSION['email']))){
header("location:index.php");


}
else
{
$name = $_SESSION['name'];
$email=$_SESSION['email'];

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="account.php?q=1" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}

if(@$_GET['q']== 'result' && @$_GET['eid']) 
{

$eid=@$_GET['eid'];
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' " )or die('Error157');
//echo  '';

while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$w=$row['wrong'];
$r=$row['sahi'];
$qa=$row['level'];
//echo '';
}
/*$q=mysqli_query($con,"SELECT * FROM rank WHERE  email='$email' " )or die('Error157');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
echo '<tr style="color:#990000"><td>Overall Score<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$s.'</td></tr>';
}*/
//echo '</table></div>';
$html = '<div class="panel">
<center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">
<tr style="color:#66CCFF"><td>Total Questions</td><td>'.$qa.'</td></tr>
      <tr style="color:#99cc32"><td>Correct Answer<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$r.'</td></tr> 
	  <tr style="color:red"><td>Wrong Answer<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>'.$w.'</td></tr>
	  <tr style="color:#66CCFF"><td>Score<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>'.$s.'</td></tr></table></div>';
   


      $filename = date("d-m-Y H:i:s");
      require_once("vendor/autoload.php");
      $mpdf = new \Mpdf\Mpdf([
        'mode' => 'c',
        'margin_top' => 35,
        'margin_bottom' => 17,
        'margin_header' => 10,
        'margin_footer' => 10,
      ]);
      $mpdf->showImageErrors = true;
      $mpdf->mirrorMargins = 1;
      $mpdf->SetTitle('Generate PDF file using PHP and MPDF | Mitrajit\'s Tech Blog');
      $mpdf->WriteHTML($html);
      $pdf = $mpdf->Output('', 'S');
    
$data = [

	
	'Email'      => $email,
	
];


//Run the function



function sendEmail($pdf,$data)
    {
       // Instantiation and passing `true` enables exceptions


try {
	$mail = new PHPMailer;
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'saadana.264@gmail.com';                     // SMTP username
    $mail->Password   = 'Classic@4321!';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('test@email.com', 'Mailer');
    $mail->addAddress($_SESSION['email']);


    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	// add pdf attachment in the email

     $mail->addStringAttachment($pdf,"myreport.pdf");

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    }
    

sendEmail($pdf,$data);






}


?>
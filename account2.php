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
$q=mysqli_query($con,"SELECT * FROM rank WHERE  email='$email' " )or die('Error157');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];

}
$q23=mysqli_query($con,"SELECT * FROM quiz WHERE  eid='$eid' " )or die('Error208');
while($row=mysqli_fetch_array($q23) )
{
$title=$row['title'];
$tag=$row['tag'];
}
//echo '</table></div>';

   
/*
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
	
];*/


//Run the function

require 'vendor/vendor/autoload.php';
//require 'sendgrid-php/sendgrid-php.php';
$apikey ="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";

$email1 = new \SendGrid\Mail\Mail();
$email1->setFrom("saadana.26@gmail.com", "Test To Certify");
$email1->setSubject("Here is your quiz report");
$email1->addTo($email,$name);



$email1->addContent("text/plain", "Congratulations ");
/*$email->addContent(
    "text/html", "<strong>and easy to do anywhere</strong>"
);*/




$email1->addContent(
    "text/html", '<div class="panel">
<center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;"><tr style="color:#990000"><td>Quiz Title<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$title.'</td></tr><tr style="color:#990000"><td>Quiz Category <span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$tag.'</td></tr>
<tr style="color:#66CCFF"><td>Total Questions</td><td>'.$qa.'</td></tr>
      <tr style="color:#99cc32"><td>Correct Answer<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$r.'</td></tr> 
	  <tr style="color:red"><td>Wrong Answer<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></td><td>'.$w.'</td></tr>
	  <tr style="color:#66CCFF"><td>Score<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>'.$s.'</td></tr><tr style="color:#990000"><td>Overall Score<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$s.'</td></tr></table></div>');
//$email1->addContent(
    //"text/html",'<tr style="color:#990000"><td>Overall Score<span class="glyphicon glyphicon-stats" aria-hidden="true"></span></td><td>'.$s.'</td></tr>');

/*$content    = file_get_contents($pdf);
$content    = chunk_split(base64_encode($content));

$pdf = new Attachment();
$pdf->setContent($content);
$pdf->setType("application/pdf");
$pdf->setFilename("RenamedFile.pdf");
$pdf->setDisposition("pdf");*/
//$file_encoded = base64_encode(file_get_contents('output.pdf', $pdf));

$sendgrid = new \SendGrid($apikey);
if($sendgrid->send($email1));
{
 echo "Report has been sent you email,click username to take another quiz or click signout!";
}

 
    







}


?>

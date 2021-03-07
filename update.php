<?php
include_once 'dbConnection.php';
require_once('PHPExcel/Classes/PHPExcel.php');
session_start();
$email=$_SESSION['email'];
//delete feedback
if(isset($_SESSION['key'])){
if(@$_GET['fdid'] && $_SESSION['key']=='sunny7785068889') {
$id=@$_GET['fdid'];
$result = mysqli_query($con,"DELETE FROM feedback WHERE id='$id' ") or die('Error');
header("location:dash.php?q=3");
}
}

//delete user
if(isset($_SESSION['key'])){
if(@$_GET['demail'] && $_SESSION['key']=='sunny7785068889') {
$demail=@$_GET['demail'];
$r1 = mysqli_query($con,"DELETE FROM rank WHERE email='$demail' ") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM history WHERE email='$demail' ") or die('Error');
$result = mysqli_query($con,"DELETE FROM user WHERE email='$demail' ") or die('Error');
header("location:dash.php?q=1");
}
}
//remove quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'rmquiz' && $_SESSION['key']=='sunny7785068889') {
$eid=@$_GET['eid'];
$result = mysqli_query($con,"SELECT * FROM questions WHERE eid='$eid' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$qid = $row['qid'];
$r1 = mysqli_query($con,"DELETE FROM options WHERE qid='$qid'") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM answer WHERE qid='$qid' ") or die('Error');
}
$r3 = mysqli_query($con,"DELETE FROM questions WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM quiz WHERE eid='$eid' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM history WHERE eid='$eid' ") or die('Error');

header("location:dash.php?q=5");
}
}

//add quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addquiz' && $_SESSION['key']=='sunny7785068889') {
$name = $_POST['name'];
$name= ucwords(strtolower($name));
$total = $_POST['total'];
$sahi = $_POST['right'];
$wrong = $_POST['wrong'];
$time = $_POST['time'];
$tag = $_POST['tag'];
$desc = $_POST['desc'];
$id=uniqid();
$q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name' , '$sahi' , '$wrong','$total','$time' ,'$desc','$tag', NOW())");

header("location:dash.php?q=4&step=2&eid=$id&n=$total");
}
}

//add question
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addqns' && $_SESSION['key']=='sunny7785068889') {
$n=@$_GET['n'];
$eid=@$_GET['eid'];
$ch=@$_GET['ch'];

for($i=1;$i<=$n;$i++)
 {
 $qid=uniqid();
 $qns=$_POST['qns'.$i];
$details=$_POST['details'.$i];
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' , '$ch' , '$i','$details')");
  $oaid=uniqid();
  $obid=uniqid();
$ocid=uniqid();
$odid=uniqid();
$a=$_POST[$i.'1'];
$b=$_POST[$i.'2'];
$c=$_POST[$i.'3'];
$d=$_POST[$i.'4'];
$qa=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
$qb=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
$qc=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
$qd=mysqli_query($con,"INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
$e=$_POST['ans'.$i];
switch($e)
{
case 'a':
$ansid=$oaid;
break;
case 'b':
$ansid=$obid;
break;
case 'c':
$ansid=$ocid;
break;
case 'd':
$ansid=$odid;
break;
default:
$ansid=$oaid;
}


$qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$qid','$ansid')");

 }
header("location:dash.php?q=0");
}
}

//upload quiz
if(isset($_SESSION['key'])){
  if(@$_GET['q']== 'upldquiz' && $_SESSION['key']=='sunny7785068889') {
  $name = $_POST['name'];
  $name= ucwords(strtolower($name));
  $total = 10;
  $sahi = $_POST['right'];
  $wrong = $_POST['wrong'];
  $time = $_POST['time'];
  $tag = $_POST['tag'];
  $desc = $_POST['desc'];
  $id=uniqid();
  $q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name' , '$sahi' , '$wrong','$total','$time' ,'$desc','$tag', NOW())");
$output = '';
echo '<script>console.log("Welcome to GeeksforGeeks!"); </script>';
if(@$_GET['q']== 'upldquiz' && $_SESSION['key']=='sunny7785068889')
{
echo '<script>console.log("Welcome to GeeksforGeeks1111111!"); </script>';
 $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
echo '<script>console.log("Welcome to GeeksforGeeks!222222"); </script>';
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file

  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  //$output .= "<label class='text-success'>Data Added: </label><br /><table class='table table-bordered'>";
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {$iter = 1;
    $f1=uniqid();
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {
    $sno = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    $qns1 = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
    $optiona = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
    $optionb = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
    $optionc = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
    $optiond = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
    $ans =  mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
    $details1 = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
    $f8 = uniqid();
    $f9 = uniqid();
    $f10 = uniqid();
    $f11 = uniqid();
    $f12 = uniqid();

    switch(strtolower($ans))
    {
      case 'option a':
      $ansid=$f9;
      break;
      case 'option b':
      $ansid=$f10;
      break;
      case 'option c':
      $ansid=$f11;
      break;
      case 'option d':
      $ansid=$f12;
      break;
      default:
      $ansid=$f9;
      }
    if(!empty($sno) || !empty($qns)) // if none of the data are empty
    {
      //$output .= "<tr>";
      $query1 = "INSERT INTO questions VALUES ('$id', '$f8','$qns1','4','$iter')";
      mysqli_query($con, $query1);
      $query2 = "INSERT INTO options(qid,option,optionid) VALUES ('$f8', '$optiona','$f9')";
      mysqli_query($con, $query2);
      $query3 = "INSERT INTO options(qid,option,optionid) VALUES ('$f8', '$optionb','$f10')";
      mysqli_query($con, $query3);
      $query4 = "INSERT INTO options(qid,option,optionid) VALUES ('$f8', '$optionc','$f11')";
      mysqli_query($con, $query4);
      $query5 = "INSERT INTO options(qid,option,optionid) VALUES ('$f8', '$optiond','$f12')";
      mysqli_query($con, $query5);
      $query6 = "INSERT INTO answer(qid,ansid) VALUES ('$sno', '$ansid')";
      mysqli_query($con, $query6);
      //$output .= '<td>'.$sno.'</td>';
      //$output .= '<td>'.$qns1.'</td>';
      //$output .= '</tr>';
    }
    $iter++; 
   }
  } 
  //$output .= '</table>';
  $target_dir = "uploads/"; //file upload folder
  $target_file = $target_dir .time().basename($_FILES["excel"]["name"]); // target file to be uploaded

  //upload the file
  if (move_uploaded_file($_FILES["excel"]["tmp_name"], $target_file)) {
       $fileUploadMsg= "<label class='text-success'>The file has been uploaded Successfully!</label><br>";
    } else {
       $fileUploadMsg= '<label class="text-danger">Sorry, there was an error uploading your file!</label><br>';
    }

 }
 else
 {
  //$output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}  
$q7=mysqli_query($con,"UPDATE quiz SET total='$sntest' WHERE eid='$id'");
  header("location:Excel-to-MySQL-Importer-and-Exporter-in-PHP-using-PHPExcel");
  }
  }
  
  



//quiz start
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
$eid=@$_GET['eid'];
$sn=@$_GET['n'];
$total=@$_GET['t'];
$ans=$_POST['ans'];
$qid=@$_GET['qid'];
$q=mysqli_query($con,"SELECT * FROM answer WHERE qid='$qid' " );
while($row=mysqli_fetch_array($q) )
{
$ansid=$row['ansid'];
}
if($ans == $ansid)
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " );
while($row=mysqli_fetch_array($q) )
{
$sahi=$row['sahi'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW())")or die('Error');
}
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' ")or die('Error115');

while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$r=$row['sahi'];
}
$r++;
$s=$s+$sahi;
$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r, date= NOW()  WHERE  email = '$email' AND eid = '$eid'")or die('Error124');

} 
else
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE eid='$eid' " )or die('Error129');

while($row=mysqli_fetch_array($q) )
{
$wrong=$row['wrong'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO history VALUES('$email','$eid' ,'0','0','0','0',NOW() )")or die('Error137');
}
$q=mysqli_query($con,"SELECT * FROM history WHERE eid='$eid' AND email='$email' " )or die('Error139');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$w=$row['wrong'];
}
$w++;
$s=$s-$wrong;
$q=mysqli_query($con,"UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE  email = '$email' AND eid = '$eid'")or die('Error147');
}
if($sn != $total)
{
$sn++;
header("location:account.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total")or die('Error152');
}
else if( $_SESSION['key']!='sunny7785068889')
{
$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
$rowcount=mysqli_num_rows($q);
if($rowcount == 0)
{
$q2=mysqli_query($con,"INSERT INTO rank VALUES('$email','$s',NOW())")or die('Error165');
}
else
{
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$s+$sun;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
}
header("location:account.php?q=result&eid=$eid");
}
else
{
header("location:account.php?q=result&eid=$eid");
}
}

//restart quiz
if(@$_GET['q']== 'quizre' && @$_GET['step']== 25 ) {
$eid=@$_GET['eid'];
$n=@$_GET['n'];
$t=@$_GET['t'];
$q=mysqli_query($con,"SELECT score FROM history WHERE eid='$eid' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"DELETE FROM `history` WHERE eid='$eid' AND email='$email' " )or die('Error184');
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$sun-$s;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
header("location:account.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
}

?>




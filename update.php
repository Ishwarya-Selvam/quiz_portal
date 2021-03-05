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
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$eid','$qid','$qns' ,'$details', '$ch' , '$i')");
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
  
if(isset($_POST["submit"]))
{
   
$file =$_FILES['file']['tmp_name'];
$handle = fopen($file, "r");

convertXLStoCSV($file,'output.csv');

}
function convertXLStoCSV($infile,$outfile)
{
    $fileType = PHPExcel_IOFactory::identify($infile);
    $objReader = PHPExcel_IOFactory::createReader($fileType);
 
    $objReader->setReadDataOnly(true);   
    $objPHPExcel = $objReader->load($infile);    
 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    ob_end_clean();
$objWriter->save($outfile);
    $handle1 = fopen($outfile, "r");
$c = 0;
//$eeid=uniqid();
$sntest =0;
while(($filesop = fgetcsv($handle1, 1000, ",")) !== false)
          {
$f1 = uniqid();
$f2 = $filesop[1];
$f3 = $filesop[2];
$f4 = $filesop[3];
$f5 = $filesop[4];
$f6 = $filesop[5];
$f7 = strtolower($filesop[6]);
$f8 = $filesop[7];
$f9 = uniqid();
$f10 = uniqid();
$f11 = uniqid();
$f12 = uniqid();
$sntest++;
switch($f7)
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

$sql1=mysqli_query($con,"insert into questions(eid,qid,qns,details,choice,sn) values ('$id','$f1','$f2','$f8',4,'$sntest')");
$sql2=mysqli_query($con,"insert into options(qid,optionn,optionid) values ('$f1','$f3','$f9')");
$sql3=mysqli_query($con,"insert into options(qid,optionn,optionid) values ('$f1','$f4','$f10')");
$sql4=mysqli_query($con,"insert into options(qid,optionn,optionid) values ('$f1','$f5','$f11')");
$sql5=mysqli_query($con,"insert into options(qid,optionn,optionid) values ('$f1','$f6','$f12')");
$sql6=mysqli_query($con,"INSERT INTO answer (qid,ansid) VALUES  ('$f1','$ansid')");
/*
$sql1 = "insert into questions(eid,qid,qns,details,choice,sn) values ('$id','$f1','$f2','$f8',4,'$sntest')";
$sql2 = "insert into options(qid,optionn,optionid) values ('$f1','$f3','$f9')";
$sql3 = "insert into options(qid,optionn,optionid) values ('$f1','$f4','$f10')";
$sql4 = "insert into options(qid,optionn,optionid) values ('$f1','$f5','$f11')";
$sql5 = "insert into options(qid,optionn,optionid) values ('$f1','$f6','$f12')";
$sql6 = "INSERT INTO answer (qid,ansid) VALUES  ('$f1','$ansid')";
// $sql = "insert into employeeinfo(emp_id,firstname,lastname,email,reg_date) values ('$f1','$f2','$f3','$f4','$f5')";
// $stmt = mysqli_prepare($conn,$sql);
 $stmt1 = mysqli_prepare($con,$sql1);
 mysqli_stmt_execute($stmt1);
$stmt2 = mysqli_prepare($con,$sql2);
mysqli_stmt_execute($stmt2);
$stmt3 = mysqli_prepare($con,$sql3);
mysqli_stmt_execute($stmt3);
$stmt4 = mysqli_prepare($con,$sql4);
mysqli_stmt_execute($stmt4);
$stmt5 = mysqli_prepare($con,$sql5);
mysqli_stmt_execute($stmt5);
$stmt6 = mysqli_prepare($con,$sql6);
 mysqli_stmt_execute($stmt6);
*/
// mysqli_stmt_execute($stmt);
$c = $c + 1;
 }

 

  if($sql1 && $sql2 && $sql6){
     echo "sucess";
   } 
else
{
  echo "Sorry! Unable to impo.";
}
}
$q7=mysqli_query($con,"UPDATE quiz SET total='$sntest' WHERE eid='$id'");
  header("location:dash.php?q=0");
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




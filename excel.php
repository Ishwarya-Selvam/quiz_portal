<?php
/*
* Supported File Formats: .XLS | .XLS | .CSV  (Excel 1997-2007)
* 
* Table structure:
* +---------+-----------+------------+
* |   id    |   name    |    email   |
* +---------+-----------+------------+
* | int(11) | char(250) | char(300)  |
* +----+----+-----------+------------+
* #3c763d
* #0cb313b3
*/

$con = mysqli_connect("34.93.71.34", "certify", "certify", "project");
$output = '';

if(isset($_POST["import"]))
{
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
 $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file

  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<label class='text-success'>Data Added: </label><br /><table class='table table-bordered'>";
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
      $output .= "<tr>";
      $query1 = "INSERT INTO questions(eid,qid,qns,details,choice,sn) VALUES ('".$id."', '".$f8."','".$qns1."','".$details1."','4','".$iter."')";
      mysqli_query($con, $query1);
      $query2 = "INSERT INTO options VALUES ('".$f8."', '".$optiona."','".$f9."')";
      mysqli_query($con, $query2);
      $query3 = "INSERT INTO options VALUES ('".$f8."', '".$optionb."','".$f10."')";
      mysqli_query($con, $query3);
      $query4 = "INSERT INTO options VALUES ('".$f8."', '".$optionc."','".$f11."')";
      mysqli_query($con, $query4);
      $query5 = "INSERT INTO options VALUES ('".$f8."', '".$optiond."','".$f12."')";
      mysqli_query($con, $query5);
      $query6 = "INSERT INTO answer(qid,ansid) VALUES ('".$sno."', '".$ansid."')";
      mysqli_query($con, $query6);
      $output .= '<td>'.$sno.'</td>';
      $output .= '<td>'.$qns1.'</td>';
	$output .= '<td>'.$f9.'</td>';
      $output .= '</tr>';
    }
    $iter++; 
   }
  } 
$iter=$iter-1;
  $output .= '</table>';
  $target_dir = "uploads/"; //file upload folder
  $target_file = $target_dir .time().basename($_FILES["excel"]["name"]); // target file to be uploaded
$q7=mysqli_query($con,"UPDATE quiz SET total='$iter' WHERE eid='$id'");
  //upload the file

 }
 else
 {
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}
?>

<html>
 <head>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">

 <script src="js/jquery.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CLOUD PREP || DASHBOARD </title>
<link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>  
<style>
 <!-- body
  {
   margin:0;
   padding:0;
  
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  input[type="file"]{
    border:1px solid gray;
  }
  -->
  </style>
 </head>
 <body style="background:#eee;">
<div class="header">
<div class="row">
<div class="col-lg-6">
<span class="logo">Test To Certify!</span></div>
<?php
 include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
  if(!(isset($_SESSION['email']))){
header("location:index.php");

}
else
{
$name = $_SESSION['name'];;

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Hello,</span> <a href="account.php" class="log log1">'.$name.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Signout</button></a></span>';
}?>

</div></div>
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard</b></a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dash.php?q=1">User</a></li>
		<li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dash.php?q=2">Ranking</a></li>
		<li <?php if(@$_GET['q']==3) echo'class="active"'; ?>><a href="dash.php?q=3">Feedback</a></li>
        <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Quiz</a></li>
            <li><a href="dash.php?q=5">Remove Quiz</a></li>
   	    <li><a href="dash.php?q=6">Upload Quiz</a></li>		
          </ul>
        </li><li class="pull-right"> <a href="logout.php?q=account.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Signout</a></li>
		
      </ul>
          </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <div class="container box">
   <form method="post" enctype="multipart/form-data">
    <div class="container-fluid">
      <h3 align="center"  style="font-weight:600;">Upload Quiz</h3><br />
      <div class="row" style="margin-bottom:20px">
        <div class="col-md-4 col-xs-4 col-sm-4"></div>  <!-- Blank Div -->
        <div class="col-md-4 ">
         
        </div>
      </div>
	<div class="form-group">
  <label class="col-md-12 control-label" for="name"></label>  
  <div class="col-md-12">
  <input id="name" name="name" placeholder="Enter Quiz title" class="form-control input-md" type="text">
    
  </div>
</div>
 <!-- Text input-->
<!-- <div class="form-group">
   <label class="col-md-12 control-label" for="total"></label>  
   <div class="col-md-12">
   <input id="total" name="total" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
   </div>
 </div>
-->
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="right"></label>  
  <div class="col-md-12">
  <input id="right" name="right" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="wrong"></label>  
  <div class="col-md-12">
  <input id="wrong" name="wrong" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="tag"></label>  
  <div class="col-md-12">
  <input id="tag" name="tag" placeholder="Enter #tag which is used for searching" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="desc"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="desc" class="form-control" placeholder="Write description here..."></textarea>  
  </div>
</div>  


    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <label>Select Excel File*</label>
        </div>
        <div class="col-xs-6 col-md-5 col-sm-6 col-lg-5">
            <input type="file" name="excel" />
        </div>
        <div class="col-xs-7 col-md-7 col-sm-6 col-lg-7">
            <input type="submit" name="import" class="btn btn-info" value="Import" style="padding:2px 20px;"/>
        </div>
      </div>
  </div>
   </form>
   <br />
   <br />
   <?php
      echo $output;
      echo @$fileUploadMsg;
      echo "<hr/>
			<p style='float:left'>* Supported Formats: .xls | .xlsx | .csv</p>
			<!--<p style='float:right'><a href='export.php'>Exporter &#8594;</a></p>-->";
      mysqli_close($connect);
   ?>
  </div>
 </body>
</html>




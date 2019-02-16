<?php
if($_POST['method'] == 'notify'){
        include 'option/jquery.php'; 
        include 'connection/connect.php';
}else{  @session_start(); 
        include '../option/jquery.php'; 
        include '../connection/connect.php';?>

<?php
if (empty($_SESSION['ss_id'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบบริการและสนับสนุนโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
</head>
<script language="JavaScript" type="text/javascript">
            var StayAlive = 4; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>  
    <body onLoad="KillMe();self.focus();window.opener.location.reload();">            
<?php }?>
<p>&nbsp;</p><p>&nbsp;</p>
<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>
<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>
<?php
function insert_date($take_date_conv) {
            $take_date = explode("-", $take_date_conv);
            $take_date_year = @$take_date[2] - 543;
            $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
            return $take_date;
        }
    date_default_timezone_set('Asia/Bangkok');
     if ($_POST['method'] == 'notify') {
    $room_notify_id=$_POST['room_notify_id'];
    $room_notify_tokenkey = $_POST['room_notify_tokenkey'];
    $car_notify_id=$_POST['car_notify_id'];
    $car_notify_tokenkey = $_POST['car_notify_tokenkey'];
    $edit1 = mysqli_query($db,"update notify set notify_tokenkey='$room_notify_tokenkey' where notify_id='$room_notify_id'");
    $edit2 = mysqli_query($db,"update notify set notify_tokenkey='$car_notify_tokenkey' where notify_id='$car_notify_id'");

    if ($edit1 == false or $edit2 == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=admin/add_notify' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
        }
}
?>
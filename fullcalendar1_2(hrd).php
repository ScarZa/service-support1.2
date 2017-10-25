<?php @session_start(); ?>
<?php
include_once 'connection/connect.php';
//===ชื่อโรงพยาบาล
if ($db) {
    $sql = mysqli_query($db, "select * from  hospital");
    $resultHos = mysqli_fetch_assoc($sql);
}
if ($resultHos['logo'] != '') {
    $pic = $resultHos['logo'];
    $fol = "../hrd1.9/logo/";
} else {
    $pic = 'agency.ico';
    $fol = "images/";
}
$_SESSION['ss_status'] = isset($_SESSION['ss_status']) ? $_SESSION['ss_status'] : '';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="<?= $fol . $pic; ?>">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">

        <!--date picker-->
        <script src="option/js/jquery.min.js"></script>
        <script src="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js" type="text/javascript"></script>
        <link href="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.css" rel="stylesheet" type="text/css"/>
        <link href="option/jquery-ui-1.11.4.custom/SpecialDateSheet.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.css">
<script src="option/js/jquery.min.js"></script>
</head>
<body>
<section class="content">
    <div class="row">
    <div class="col-lg-12">
        <div class="col-lg-6 col-md-12 col-xs-12">
<script type="text/javascript">
            $(function() {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "fullcalendar/data_events.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
    	#calendar{
		max-width: 100%;
                height: auto;
                width: auto;
		margin: auto;
                font-size:13px;
	}        
    </style>
<center><h3>ปฏิทินการใช้ห้องประชุม</h3>
<div style="width:100%;">
 <div align="center" id='calendar'></div>
 </div>
<br>
<div>
<?php
$li_conf=  mysqli_query($db, "SELECT room_name FROM ss_room ORDER BY room_id ASC") or die(mysqli_error($db));
$code_color=array("1"=>"#1e6c06","2"=>"#930606","3"=>"#416cbb","4"=>"purple","5"=>"#d92727","6"=>"orange","7"=>"yellow");
$i=1;
while ($row = mysqli_fetch_array($li_conf)) {  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['room_name']?></a> 
<?php $i++; }echo "<br>";?>
</div></center></div>
    <div class="col-lg-6 col-md-12 col-xs-12">
        <script type="text/javascript">
            $(function() {
                $('#calendar2').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "fullcalendar/data_events2.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
	#calendar2{
		max-width: 100%;
                height: auto;
                width: auto;
		margin: auto;
                font-size:13px;
	}        
    </style>
<center><h3>ปฏิทินการใช้รถยนต์</h3>
<div style="width:100%;">
 <div id='calendar2'></div>
 </div>
<br>
<div>
<?php
$li_car=  mysqli_query($db, "SELECT license_name FROM ss_carlicense ORDER BY license_id ASC") or die(mysqli_error($db));
$code_color=array("1"=>"#416cbb","2"=>"#6a6a6a","3"=>"#68bd60","4"=>"#977dd1","5"=>"#ec8b00","6"=>"#ec73c8","7"=>"yellow");
//$code_color=array("1"=>"#1e6c06","2"=>"#930606","3"=>"#416cbb","4"=>"purple","5"=>"#d92727","6"=>"orange","7"=>"yellow");
$i=1;
while ($row = mysqli_fetch_array($li_car)) {  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['license_name']?></a> 
<?php $i++; }echo "<br>";?>
</div></center>
    </div></div></div></section>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="fullcalendar/script.js"></script>   
<script type="text/javascript" src="fullcalendar/script2.js"></script> 
</body>
</html>
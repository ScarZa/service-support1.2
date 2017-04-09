<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">
    <link href="../option/css/bootstrap.css" rel="stylesheet">
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
                    events: "data_events.php?gData=1",
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
    html,body{
        maring:0;padding:0;
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;   
        font-size:12px;
    }
	#calendar{
		max-width: 82%;
		margin: 0 auto;
        font-size:13px;
	}        
    </style>
</head>
<body>
<center><h1>ปฏิทินการใช้ห้องประชุม</h1></center>

<div style="margin:auto;width:800px;">
 <div id='calendar'></div>
 </div>
<br>

<div align="center">
<?php
include '../connection/connect.php';
$li_conf=  mysqli_query($db, "SELECT room_name FROM ss_room ORDER BY room_id ASC") or die(mysqli_error($db));
$code_color=array("1"=>"#1e6c06","2"=>"#930606","3"=>"#416cbb","4"=>"purple","5"=>"#d92727","6"=>"orange","7"=>"yellow");
$i=1;
while ($row = mysqli_fetch_array($li_conf)) {  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['room_name']?></a> 
<?php $i++; }
 echo "<br>";
if(!empty($_GET['check'])=='1'){?>
   <a href="#" class="btn btn-success btn-sm" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=conferance/request_conf'; window.close();">ขอใช้ห้องประชุม</a> 
<?php }
?></div>
    
<script src="js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="script.js"></script>            
</body>
</html>
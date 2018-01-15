<?php
if($_POST['method'] == 'request_room' or $_POST['method'] == 'edit_room' or $_POST['method'] == 'add_conf' or $_POST['method'] == 'edit_conf'){
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
    $obj = isset($_POST['obj'])?$_POST['obj']:'';
    $start_date =isset($_POST['start_date'])? insert_date($_POST['start_date']):'';
    $end_date = isset($_POST['end_date'])?insert_date($_POST['end_date']):'';
    if(empty($_POST['record_date'])){
    $record_date=date('Y-m-d H:i:s');
    }  else {
     $record_date=insert_date($_POST['record_date']).' '.date('H:i:s');   
}
    $start_time = isset($_POST['take_hour_st'])?$_POST['take_hour_st'].":".$_POST['take_minute_st']:'';
    $end_time = isset($_POST['take_hour_en'])?$_POST['take_hour_en'].":".$_POST['take_minute_en']:'';
    $amount = isset($_POST['amount'])?$_POST['amount']:'';
    $equip = isset($_POST['equip'])?$_POST['equip']:'';
    $audio = isset($_POST['audio'])?$_POST['audio']:'';
    $mic_table = isset($_POST['mic_table'])?$_POST['mic_table']:'';
    $mic_wireless = isset($_POST['mic_wireless'])?$_POST['mic_wireless']:'';
    $mic_line = isset($_POST['mic_line'])?$_POST['mic_line']:'';
    $visualizer = isset($_POST['visualizer'])?$_POST['visualizer']:'';
    $projector = isset($_POST['projector'])?$_POST['projector']:'';
    $comp = isset($_POST['comp'])?$_POST['comp']:'';
    $format = isset($_POST['format'])?$_POST['format']:'';
    $room = isset($_POST['room'])?$_POST['room']:'';
    
    if ($_POST['method'] == 'request_room') {
        if($_SESSION['ss_status']=='USER'){
        $empno = $_SESSION['ss_id'];
        }else{
        $empno = $_POST['empno'];    
        }  
        $sql = "SELECT * FROM ss_conferance WHERE room = '".$room."'
AND ('".$start_date."' between start_date and end_date)
AND (

   (start_time BETWEEN '".$start_time."' AND '".$end_time."')
   OR 
   (end_time BETWEEN '".$start_time."' AND '".$end_time."')
   OR 
    ('".$start_time."' BETWEEN start_time  AND end_time)
   OR 
    ('".$end_time."' BETWEEN  start_time  AND end_time )
) and approve='Y'";
        $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
if($row = mysqli_fetch_array($qry))
{
echo "ห้องนี้มีผู้ใช้งาน ช่วงเวลา ". $row['start_time'] ." - ". $row['end_time'] ." กรุณาตรวจสอบอีกครั้ง!";
 echo "	<br><span class='fa fa-remove'></span>";
        echo "<a href='index.php?page=conferance/request_conf' >กลับ</a>";
}else{
        
        $regis_conferance=  mysqli_query($db,"select count from count where count_name='regis_conferance'");
$Regis_conferance=  mysqli_fetch_assoc($regis_conferance);
$Ln=$Regis_conferance['count']+1;
$Y=date('y')+43;
$conferance_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_conferance'");
    
    $request = mysqli_query($db,"insert into ss_conferance set empno_request='$empno', obj='$obj', record_date='$record_date', start_date='$start_date', end_date='$end_date',
                conferance_no='$conferance_no', start_time='$start_time', end_time='$end_time', amount='$amount', equip='$equip', audio='$audio', mic_table='$mic_table',
                   mic_wireless='$mic_wireless', mic_line='$mic_line', visualizer='$visualizer',projector='$projector', comp='$comp', format='$format',
                      room='$room' ");

    $last_insert = mysqli_insert_id($db);
    $sql_line = mysqli_query($db,"select ssc.conf_id,ssc.conferance_no,ssc.obj,ssc.start_date,ssc.start_time,ssc.end_date,ssc.end_time,ssc.amount
, concat(e1.firstname,' ',e1.lastname) as fullname, d1.depName, r.room_name
            from ss_conferance ssc  
            INNER JOIN ss_room r on r.room_id=ssc.room
            inner join emppersonal e1 on e1.empno=ssc.empno_request
            inner JOIN work_history wh ON wh.empno=e1.empno
            inner join department d1 on d1.depId=wh.depid
            where ssc.conf_id=".$last_insert." and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $LineText = mysqli_fetch_assoc($sql_line);
    include_once 'option/funcDateThai.php';
        //////////////////// Line Notify //////////////////////////////
define('LINE_API',"https://notify-api.line.me/api/notify");
function notify_message($message,$token){
 $queryData = array('message' => $message);
 $queryData = http_build_query($queryData,'','&');
 $headerOptions = array( 
         'http'=>array(
            'method'=>'POST',
            'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                      ."Authorization: Bearer ".$token."\r\n"
                      ."Content-Length: ".strlen($queryData)."\r\n",
            'content' => $queryData
         ),
 );
 $context = stream_context_create($headerOptions);
 $result = file_get_contents(LINE_API,FALSE,$context);
 $res = json_decode($result);
 return $res;
} 
$token = 'token key';
$text = "แจ้งขอห้องประชุม :    วันที่".DateThai1($LineText['start_date'])." ".$LineText['start_time']."น.\n ถึงวันที่".DateThai1($LineText['end_date'])." ".$LineText['end_time']."น.\n ".$LineText['room_name']." เพื่อ ".$LineText['obj']."\n  จำนวน ".$LineText['amount']." ผู้แจ้ง ".$LineText['fullname']." งาน ".$LineText['depName'];
 
$res = notify_message($text,$token);
//print_r($res);

/////////////////////
    
    if ($request == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/request_conf' >กลับ</a>";
    } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
}}
}else if ($_POST['method'] == 'edit_room') {
    $conf_id=$_REQUEST['edit_id'];
    $edit = mysqli_query($db,"update ss_conferance set obj='$obj', start_date='$start_date', end_date='$end_date',
                start_time='$start_time', end_time='$end_time', amount='$amount', equip='$equip', audio='$audio', mic_table='$mic_table',
                   mic_wireless='$mic_wireless', mic_line='$mic_line', visualizer='$visualizer',projector='$projector', comp='$comp', format='$format',
                      room='$room' where conf_id='$conf_id'");

    $edit_event=mysqli_query($db,"update tbl_event set event_start='$start_date $start_time',event_end='$end_date $end_time',typela='$room' where workid='$conf_id' and process='2'");

    if ($edit & $edit_event == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/pre_request'>";
        }
}else if ($_POST['method'] == 'confirm_conf') {
    include '../connection/connect.php';
    
    $confirm=$_POST['confirm'];
    $conf_id=$_POST['conf_id'];
    $depName=$_POST['depName'];
    $event_start=$_POST['event_start'];
    $event_end=$_POST['event_end'];
    $empno=$_POST['empno'];
    $room=$_POST['room'];
    
    $confirm_conf=  mysqli_query($db, "update ss_conferance set approve='$confirm', approver='".$_SESSION['ss_id']."' where conf_id='$conf_id' ");
    if($confirm=='Y'){
        $event2=  mysqli_query($db,"select url from hospital");
        $Event2=  mysqli_fetch_assoc($event2);
        $Events=$Event2['url'];
    $insert_event=mysqli_query($db,"insert into tbl_event set event_title='$depName',event_start='$event_start',event_end='$event_end',event_allDay='false',
            empno='$empno',workid='$conf_id',typela='$room',process='2', event_url='$Events/service&support1.2/conferance/confirm_conf.php?id=$conf_id&method=back'");
    }
    if ($confirm_conf == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    } }else if ($_POST['method'] == 'cancle_conf') {
    include '../connection/connect.php';
    $conf_id=$_POST['conf_id'];
    $cancle_conf=  mysqli_query($db, "update ss_conferance set approve='C', approver='".$_SESSION['ss_id']."' where conf_id='$conf_id' ");
    $delete_conf=  mysqli_query($db,"delete from tbl_event where workid='$conf_id' and process='2'");
    
                    if ($cancle_conf == false) {
        echo "<p>";
        echo "Cancle not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    }}else if ($_POST['method'] == 'add_conf') {
    include 'connection/connect.php';
    $room=$_POST['conf'];
    $sql_conf=  mysqli_query($db, "insert into ss_room set room_name='$room'");
    
                    if ($sql_conf == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/add_conf' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/add_conf'>";
     }
}else if ($_POST['method'] == 'edit_conf') {
    include 'connection/connect.php';
    $room_id=$_POST['room_id'];
    $room=$_POST['conf'];
    $edit_conf=  mysqli_query($db, "update ss_room set room_name='$room' where room_id='$room_id'");
    
                    if ($edit_conf == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/add_conf' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/add_conf'>";
     }
}
?>
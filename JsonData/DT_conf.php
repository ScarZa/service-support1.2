<?php
header('Content-type: text/json; charset=utf-8');

function __autoload($class_name) {
    include '../class/' . $class_name . '.php';
}
include_once '../option/function_date.php';
include_once '../option/funcDateThai.php';
$conn_DB = new EnDeCode();
$read = "../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db = $conn_DB->Read_Text();
$conn_DB->conn_PDO();
set_time_limit(0);
$rslt = array();
$series = array();
function insert_date($take_date_conv) {
    $take_date = explode("-", $take_date_conv);
    $take_date_year = @$take_date[2] - 543;
    $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
    return $take_date;
}
$date = isset($_GET['data'])?$_GET['data']:'';
if(empty($date)){
    $seldate = 'curdate()';
}else{
    $seldate = "'".insert_date($date)."'";
}
$sql="SELECT ".$seldate." as date,SUBSTR(sscon.start_time,1,5)start_time ,SUBSTR(sscon.end_time,1,5)end_time,sscon.obj,d1.depName,ssr.room_name,ssr.room_id
FROM ss_conferance sscon
inner join ss_room ssr on ssr.room_id=sscon.room
inner join emppersonal e1 on e1.empno=sscon.empno_request
inner JOIN work_history wh ON wh.empno=e1.empno
inner join department d1 on d1.depId=wh.depid
WHERE (".$seldate." between sscon.start_date and sscon.end_date) and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))
and sscon.approve='Y'  GROUP BY sscon.conf_id
ORDER BY ssr.room_id ASC,start_time ASC"; 
//$execute = array(':pd_id' => $data);
    $conn_DB->imp_sql($sql);
    $num_risk = $conn_DB->select();
    for($i=0;$i<count($num_risk);$i++){
    $series['date']= DateThai1($num_risk[$i]['date']);
    $series['stime'] = $num_risk[$i]['start_time'].'น.';
    $series['to'] = 'ถึง';
    $series['etime'] = $num_risk[$i]['end_time'].'น.';
    $series['obj'] = $num_risk[$i]['obj'];
    $series['depName']= $num_risk[$i]['depName'];
    $roomname = explode("(",$num_risk[$i]['room_name']);
    $series['room_name']= $roomname[0];
    $series['room_name2']= "( ".$roomname[1];
    $series['room_id']= $num_risk[$i]['room_id'];
    array_push($rslt, $series);    
    }
print json_encode($rslt);
$conn_DB->close_PDO();
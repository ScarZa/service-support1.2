<?php  
header("Content-type:application/json; charset=UTF-8");            
header("Cache-Control: no-store, no-cache, must-revalidate");           
header("Cache-Control: post-check=0, pre-check=0", false);      
include '../connection/connect.php'; // เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล  
 // เชื่อมต่อกับฐานข้อมูล      
if($_GET['gData']){  
    $event_array=array();  
    $i_event=0;  
    $q="SELECT e.empno,CONCAT(e.firstname,' ',e.lastname,' : ',d.depName)title,CONCAT(SUBSTR(NOW(),1,4),SUBSTR(e.birthdate,5))birth
,DATE_ADD(CONCAT(SUBSTR(NOW(),1,4),SUBSTR(e.birthdate,5)),INTERVAL 1 DAY)enbirth,e.sex
FROM emppersonal e
INNER JOIN department d on d.depId=e.depid
WHERE e.status=1 ORDER BY e.birthdate;";    
    $qr=mysqli_query($db,$q) or die(mysqli_error($db)); 
    
    $code_color=array("1"=>"#416cbb","2"=>"#d92727","3"=>"#1e6c06","4"=>"purple","5"=>"#00a6ba","6"=>"orange","7"=>"#4e5252");
    $sex=array("1"=>1,"2"=>2);
//    $sql_conf=  mysqli_query($db, "SELECT COUNT(room_id) as count_conf FROM ss_room") or die(mysqli_error($db));
//    $conf= mysqli_fetch_array($sql_conf);
    while($rs=mysqli_fetch_array($qr)){  
        for($i=1;$i<= count($sex);$i++){
        if ($rs['sex'] == "$i") {  
            $color = "$code_color[$i]";  
            }}
        $event_array[$i_event]['id']=$rs['empno'];  
        $event_array[$i_event]['title']=$rs['title'];  
        $event_array[$i_event]['start']=$rs['birth'];  
        $event_array[$i_event]['end']=$rs['enbirth'];  
        $event_array[$i_event]['url']=''; 
        $event_array[$i_event]['color']=$color;
        $event_array[$i_event]['allDay']=true;  
        $i_event++;  
    }    
}  
$json= json_encode($event_array);    
if(isset($_GET['callback']) && $_GET['callback']!=""){    
echo $_GET['callback']."(".$json.");";        
}else{    
echo $json;    
}   
?>  
<?php  /* 
header("Content-type:application/json; charset=UTF-8");            
header("Cache-Control: no-store, no-cache, must-revalidate");           
header("Cache-Control: post-check=0, pre-check=0", false);      
include '../connection/connect_i.php'; // เรียกใช้งานไฟล์เชื่อมต่อกับฐานข้อมูล 
if($_GET['gData']){    
    $q="SELECT * FROM tbl_event WHERE date(event_start)>='".$_GET['start']."'  ";    
    $q.=" AND date(event_end)<='".$_GET['end']."' ORDER by event_id";    
    $result = $db->query($q);  
    while($rs=$result->fetch_object()){  
        if ($rs->typela == '1') {  
            $color = 'orange';  
        } else if ($rs->typela == '2') {  
            $color = 'violet';  
        } else if ($rs->typela == '3') {  
            $color = 'green';  
        }else if ($rs->typela == '4') {  
            $color = 'red';  
        } else if ($rs->typela == '5') {  
            $color = 'yellow';  
        }else if ($rs->typela == '7') {  
            $color = 'brown';  
        } 
        $json_data[]=array(    
            "id"=>$rs->event_id,  
            "title"=>$rs->event_title,  
            "start"=>$rs->event_start,  
            "end"=>$rs->event_end,  
            "url"=>$rs->event_url,
            "color" => $color,
            "allDay"=>($rs->event_allDay==true)?true:false   
              
        );  
    }    
}  
$json= json_encode($json_data);    
if(isset($_GET['callback']) && $_GET['callback']!=""){    
echo $_GET['callback']."(".$json.");";        
}else{    
echo $json;    
}    */ 
?>    

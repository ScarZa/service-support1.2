<?php @session_start(); ?>
<?php include '../connection/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบบริการและสนับสนุน</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="../option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
<script src="../option/js/excellentexport.js"></script>
</head>
<?php
include_once ('../option/funcDateThai.php');

    $conf_id=$_GET['conf_id'];
    $sql_hos=  mysqli_query($db,"SELECT name FROM hospital");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, d2.dep_name AS depname, p2.posname AS posi, r.room_name
FROM ss_conferance ssc
INNER JOIN emppersonal e1 ON ssc.empno_request = e1.empno
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
inner JOIN work_history wh ON wh.empno=e1.empno
INNER JOIN department d1 ON d1.depId = wh.depid
INNER JOIN department_group d2 ON d2.main_dep = d1.main_dep
INNER JOIN posid p2 ON e1.posid = p2.posId
INNER JOIN ss_room r on r.room_id=ssc.room 
WHERE ssc.conf_id =$conf_id and (wh.dateEnd_w='0000-00-00' or ISNULL(wh.dateEnd_w))");
    $conf =  mysqli_fetch_assoc($sql);
    

?>
<body>
    <?php
require_once('../option/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
    

    <center><h4 align="center">แบบฟอร์มการขอใช้ห้องประชุม/อุปกรณ์โสตทัศนศึกษา<br>
                            งานโสตทัศนศึกษา <?= $hospital['name']?>
                                    </h4></center>
                    
<div class="col-lg-12">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ข้าพเจ้า &nbsp;<b><?= $conf['fullname']?></b>&nbsp;  งาน &nbsp;<b><?= $conf['dep']?></b>&nbsp; ฝ่าย &nbsp;<b><?= $conf['depname']?></b><br> 
    มีความประสงค์ที่จะขอใช้ห้องประชุมและอุปกรณ์โสตฯ เพื่อ <b><?= $conf['obj']?></b><br>
            ในวันที่&nbsp; <b><?= DateThai2($conf['start_date'])?></b>&nbsp;  ตั้งแต่เวลา &nbsp; <b><?= substr($conf['start_time'], 0,5)?></b>&nbsp; น. &nbsp;ถึงวันที่&nbsp; <b><?= DateThai2($conf['end_date'])?></b>&nbsp; เวลา&nbsp; <b><?= substr($conf['end_time'],0,5)?></b> &nbsp;น.
            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขอใช้ : <b><?=$conf['room_name']?></b> &nbsp; จำนวนผู้เข้าร่วมประชุม &nbsp; <b><?= $conf['amount']?></b>&nbsp; คน</p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    อุปกรณ์โสตฯ : 
    <?php 
                            if($conf['equip']=='Y'){
                                echo '<b>ขอรับการสนับสนุนอุปกรณ์โสตฯ</b>';
                            }elseif ($conf['equip']=='N') {
                                echo '<b>ไม่ขอรับการสนับสนุนอุปกรณ์โสตฯ</b>';
                            }
                            ?>
    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ลักษณะการจัดโต๊ะประชุม : <b><?= $conf['format']==1?'ประชุม':'สัมมนา'?></b>
</div><br> 
    <div class="col-lg-12">
        <table width="100%" border="1" cellspacing="0" ><tr><td>
                    <table width="100%" border="0">
                        <tr>
                            <td width="50%">&nbsp;&nbsp;[<?=$conf['audio']=='Y'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] เครื่องเสียงห้องประชุม</td>
                            <td width="50%">[<?=$conf['projector']=='Y'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] เครื่องฉายโปรเจ็คเตอร์ พร้อมจอ</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;[<?=$conf['mic_table']!='0'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] ไมค์ตั้งโต๊ะประชุม จำนวน....<?=$conf['mic_table']!='0'?$conf['mic_table']:'..'?>...ตัว</td>
                            <td>[<?=$conf['visualizer']=='Y'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] เครื่องฉายภาพ (Visualizer)</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;[<?=$conf['mic_wireless']!='0'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] ไมค์ลอย จำนวน....<?=$conf['mic_wireless']!='0'?$conf['mic_wireless']:'..'?>...ตัว</td>
                            <td>[<?=$conf['comp']=='Y'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] เครื่องคอมพิวเตอร์</td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;[<?=$conf['mic_line']!='0'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] ไมค์สาย จำนวน....<?=$conf['mic_line']!='0'?$conf['mic_wireless']:'..'?>...ตัว</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>   
                </td></tr></table>
    </div>
<!--<div class="col-xs-12">    
<div class="col-xs-6">&nbsp;</div>   
<div class="col-xs-6" align="right"> การตรวจสอบห้องว่าง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        [<?=$conf['room']=='1'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] ห้องประชุมกองสุข (ห้องประชุมใหญ่)&nbsp;&nbsp;&nbsp;<br>
        [<?=$conf['room']=='2'?"<img src='../images/check.png' width='12'>":'&nbsp;&nbsp;&nbsp;'?>] ห้องประชุมอุครานั้นท์ (ห้องประชุมเล็ก)</div></div>-->
<br><br>
    
    <div class="col-lg-12">
    <table width="100%" border="0" cellspacing="0">
        <tr>
            <td width='50%' align="center"> 
                (ลงชื่อ).............................................ผู้ขอใช้<br><br>
             ( <?= $conf['fullname']?> )<br><br>
                                                      <?= DateThai2($conf['record_date'])?><br><br>
                                         </td>
                                         <td width='50%' align="center">
    (ลงชื่อ).............................................ผู้ตรวจสอบ<br><br>
                                             ( ............................................. )<br><br>
                                         ........../............/............<br><br>
    </td></tr></table></div><br>
    <b>ความเห็นของหัวหน้าฝ่ายบริหารงานทั่วไป</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ &nbsp; ] ไม่อนุญาต เนื่องจาก..................................................................................<br> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<?=$conf['room']!=''?"<img src='../images/check.png' width='10'>":'&nbsp;&nbsp;&nbsp;'?>] อนุญาต ให้ใช้ <?=$conf['room_name']?><p> 
     <div class="col-lg-12" align="center">
         <table width="100%" border="0" cellspacing="0" >
             <tr>
                 <td width='40%' height="35" valign="top"><b>เห็นควร</b></td>
                 <td width='60%' height="35" valign="top"><b>รับทราบดำเนินการ</b></td>
             </tr>
             <tr>
                 <td height="35">[ &nbsp; ] ผู้ควบคุมเครื่องเสียง</td>
                <td height="35">(ลงชื่อ).........................................................ผู้ควบคุมเครื่องเสียง</td>
             </tr>
             <tr>
                 <td height="35">[ &nbsp; ] ผู้ควบคุมคอมพิวเตอร์</td>
                <td height="35">(ลงชื่อ).........................................................ผู้ควบคุมคอมพิวเตอร์</td>
             </tr>
             <tr>
                 <td height="35">[ &nbsp; ] ผู้จัดห้องประชุม</td>
                <td height="35">(ลงชื่อ).........................................................ผู้จัดห้องประชุม</td>
             </tr>
             <tr>
                 <td>&nbsp;</td>
                <td>&nbsp;</td>
             </tr>
             <tr>
                 <td height="35">&nbsp;</td>
                <td height="35">(ลงชื่อ).........................................................ผู้อนุมัติ</td>
             </tr>
             <tr>
                 <td>&nbsp;</td>
                <td height="35">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(........................................................)</td>
             </tr>
             <tr>
                 <td></td>
                <td align='right'>F-PU-02</td>
             </tr>
        </table>
     </div>
                                         
<?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('tha2','A4','10','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("../MyPDF/conf.pdf");
echo "<meta http-equiv='refresh' content='0;url=../MyPDF/conf.pdf' />";
?>
</body>
</html>
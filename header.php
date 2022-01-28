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
        <title>ระบบสนับสนุน</title>
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
        <!--Data picker Thai-->
        <script src="js/DatepickerThai4.js" type="text/javascript"></script>
        <!-- DataTables -->
        <link rel="stylesheet" href="option/DataTables/dataTables.bootstrap4.css">
        <!-- Select2--> 
        <link href="option/select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- excell export -->
        <script src="option/js/excellentexport.js"></script>

        <!-- InstanceBeginEditable name="head" -->
            <!--<style type="text/css">
        html{
        -moz-filter:grayscale(100%);
        -webkit-filter:grayscale(100%);
        filter:gray;
        filter:grayscale(100%);
        }
        </style>-->
        <style type="text/css">
            .black-ribbon {   position: fixed;   z-index: 9999;   width: 70px; }
            @media only all and (min-width: 768px) { .black-ribbon { width: auto; } }

            .stick-left { left: 0; }
            .stick-right { right: 0; }
            .stick-top { top: 0; }
            .stick-bottom { bottom: 0; }
        </style>
        <script type="text/javascript">
            function getRefresh() {
                $("#auto").show("slow");
                $("#autoRefresh").load("count_conf.php", '', callback);
            }

            function callback() {
                $("#autoRefresh").fadeIn("slow");
                setTimeout("getRefresh();", 1000);
            }

            $(document).ready(getRefresh);
        </script>
        <script language="JavaScript">
            var HttPRequest = false;
            function doCallAjax(Sort) {
                HttPRequest = false;
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    HttPRequest = new XMLHttpRequest();
                    if (HttPRequest.overrideMimeType) {
                        HttPRequest.overrideMimeType('text/html');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                        }
                    }
                }
                if (!HttPRequest) {
                    alert('Cannot create XMLHTTP instance');
                    return false;
                }
                var url = 'count_conf.php';
                var pmeters = 'mySort=' + Sort;
                HttPRequest.open('POST', url, true);
                HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //HttPRequest.setRequestHeader("Content-length", pmeters.length);
               // HttPRequest.setRequestHeader("Connection", "close");
                HttPRequest.send(pmeters);
                HttPRequest.onreadystatechange = function ()
                {
                    if (HttPRequest.readyState == 3)  // Loading Request
                    {
                        document.getElementById("mySpan").innerHTML = "Now is Loading...";
                    }
                    if (HttPRequest.readyState == 4) // Return Request
                    {
                        document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
                    }
                }
            }
        </script>


    </head>
    <?php if (!empty($_POST['popup'])) { ?>
        <body onLoad="KillMe();self.focus();window.opener.location.reload();">
        <?php } else { ?>
        <body Onload="bodyOnload();">    
<?php } ?>
            <!-- Top Left 
<img src="/images/black_ribbon_top_left.png" class="black-ribbon stick-top stick-left"/>-->

        <!-- Top Right 
        <img src="/images/black_ribbon_top_right.png" class="black-ribbon stick-top stick-right"/>-->

        <!-- Bottom Left 
        <img src="/images/black_ribbon_bottom_left.png" class="black-ribbon stick-bottom stick-left"/>-->

        <!-- Bottom Right 
        <img src="images/black_ribbon_bottom_right.png" class="black-ribbon stick-bottom stick-right"/>-->
        <div id="wrapper">
            <!-- Sidebar -->
            <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="./"><font color='#fedd00'><b>Service & Support System v.1.2.1 </b></font><!--ระบบบริหารความเสี่ยง <? echo $resultHos['name']; ?>--></a>
                </div>
                <?php
//                if (!empty($_SESSION['ssuser_id'])) {
//                    $sqlUser = mysqli_query($db, "select admin from user where user_id='$user_id' ");
//                    $resultUser = mysqli_fetch_assoc($sqlUser);
//                    $admin = $_SESSION['admin'];
//                }
                ?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">

                    <ul class="nav  navbar-custom navbar-nav side-nav">
                        <li><a href="./"><img src='images/gohome.ico' width='25'> หน้าหลัก</a></li> 		
                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar1.php', popup, 820, 670);" title="ดูการใช้ห้องประชุม"><img src='images/calendar-clock.ico' width='25'> ปฏิทินการใช้ห้องประชุม</a></li>
                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar2.php', popup, 820, 670);" title="ดูการใช้รถยนต์"><img src='images/schedule.ico' width='25'> ปฏิทินการใช้รถยนต์</a></li>
                        <li><a href="#" onClick="return popup('display_conf.html', popup, 1366, 768);" title="ดูการใช้ห้องประชุมวันนี้"><img src='images/calendar-clock.ico' width='25'> ใช้ห้องประชุมวันนี้</a></li>
                        <?php if (!empty($_SESSION['ss_status'])) { ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Notepad.ico' width='25'> ขอใช้บริการ/สนับสนุน <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if ($_SESSION['ss_status'] == 'ADMIN' or $_SESSION['ss_status'] == 'SUSER') { ?>    
                                        <li><a href="index.php?page=conferance/request_conf" title="ดูการใช้ห้องประชุม"><img src='images/meeting.png' width='25'> เขียนขอห้องประชุม</a></li>
                                        <li><a href="index.php?page=car/request_car" title="ดูการใช้รถยนต์"><img src='images/Vroum Vroum.ico' width='25'> เขียนขอรถยนต์</a></li>
                                    <?php } else { ?>
                                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar1.php?check=1', popup, 820, 670);" title="ดูการใช้ห้องประชุม"><img src='images/meeting.png' width='25'> เขียนขอห้องประชุม</a></li>
                                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar2.php?check=1', popup, 820, 670);" title="ดูการใช้รถยนต์"><img src='images/Vroum Vroum.ico' width='25'> เขียนขอรถยนต์</a></li>
                                    <?php } ?>
                                    <li><a href="index.php?page=user/pre_order"><img src='images/analysis.ico' width='25'> ตรวจสอบสถานะ</a></li>                                   
                                </ul>
                            </li>
                        <?php
                        if ($_SESSION['ss_status'] == 'ADMIN' or $_SESSION['ss_status'] == 'SUSER') {
                            if ($_SESSION['ss_process'] == '2' or $_SESSION['ss_process'] == '0') {
                                ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Meeting_Dark.ico' width='25'> ระบบขอใช้ห้องประชุม <b class="caret"></b></a>
                                    <ul class="dropdown-menu">

                                        <li><a href="index.php?page=conferance/pre_request"><img src='images/Lfolder.ico' width='25'> บันทึกขอใช้ห้องประชุม</a></li>
                                        <li><a href="index.php?page=conferance/pre_confirm"><img src='images/Lfolder.ico' width='25'> บันทึกอนุมัติใช้ห้องประชุม</a></li>
                                        <li><a href="index.php?page=conferance/pre_req_cancel"><img src='images/Lfolder.ico' width='25'> บันทึกยกเลิกห้องประชุม</a></li>
                                        <li><a href="index.php?page=conferance/pre_cancle"><img src='images/Lfolder.ico' width='25'> บันทึกไม่อนุมัติ/ยกเลิกห้องประชุม</a></li>
                                        <li class="divider"></li>
                                        <li><a href="index.php?page=conferance/report_month_conf"><img src='images/if_Report_669954.ico' width='25'> รายงานห้องประชุม(รายเดือน)</a></li>
                                        <li><a href="index.php?page=conferance/report_year_conf"><img src='images/if_Report_669954.ico' width='25'> รายงานห้องประชุม(รายปี)</a></li>
                                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar4.php', popup, 820, 670);" title="ดูวันเกิด"><img src='images/calendar-clock.ico' width='25'> ปฏิทินวันเกิด</a></li>
                                    </ul>            
                                </li>
    <?php } if ($_SESSION['ss_process'] == '3' or $_SESSION['ss_process'] == '0') { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Ambulance.ico' width='25'> ระบบขอใช้รถยนต์ <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="index.php?page=car/pre_request"><img src='images/Lfolder.ico' width='25'> บันทึกขอใช้รถยนต์</a></li>
                                        <li><a href="index.php?page=car/pre_confirm"><img src='images/Lfolder.ico' width='25'> บันทึกอนุมัติใช้รถยนต์</a></li>
                                        <li><a href="index.php?page=car/pre_cancle"><img src='images/Lfolder.ico' width='25'> บันทึกไม่อนุมัติ/ยกเลิกรถยนต์</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" onclick="return popup('car/record_oil.php?method=sel_car', popup, 550, 550);"><img src='images/Gas-pump.ico' width='25'> บันทึกการเติมน้ำมัน</a></li>
                                        <li><a href="?page=car/listoil"><img src='images/vehicles-27.ico' width='25'> รายการการเติมน้ำมัน</a></li>
                                        <li class="divider"></li>
                                        <li><a href="index.php?page=car/report_oil"><img src='images/space-rocket.ico' width='25'> รายงานการใช้น้ำมันเชื้อเพลิง</a></li>
                                        <li><a href="index.php?page=car/report_work_car"><img src='images/run.ico' width='25'> รายงานผลการปฏิบัติงาน</a></li>
                                        <li><a href="index.php?page=car/report_drive_out"><img src='images/Vroum Vroum.ico' width='25'> รายงานการใช้รถยนต์</a></li>
                                        <li><a href="index.php?page=car/report_work_rider"><img src='images/driver.ico' width='25'> รายงานการปฏิบัติงาน พขร.</a></li>
                                    </ul>            
                                </li><?php }
                        }}
?>
                        <li><a href="#">&nbsp;</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right navbar-user">


<?PHP if (empty($_SESSION['ss_id'])) { ?>            	
                            <li> 	
                                <form class="navbar-form navbar-right" action='process/checkLogin.php' method='post'>
                                    <div class="form-group">
                                        <input type="text" placeholder="User Name" name='user_account' class="form-control" value='' required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Password" name='user_pwd' class="form-control"  value='' required>
                                    </div>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Sign in</button> 
                                    <div class="form-group">
                                    </div>
                                </form>
                            </li>
                                <?PHP } else { 
                            if ($_SESSION['ss_status'] == 'SUSER' or $_SESSION['ss_status'] == 'ADMIN') { ?>

                            <script language="JavaScript">
                                function bodyOnload()
                                {
                                    doCallAjax('CustomerID')
                                    setTimeout("doLoop();", 10000);
                                }
                                function doLoop()
                                {
                                    bodyOnload();
                                }
                            </script>
                            <ul class="nav navbar-nav navbar-user" id="mySpan"></ul>
                            <?php
                        }
                        ?>
                            <li class="dropdown user-dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/personal.ico' width='20'> 
                                    <?php
                                    $user_id = $_SESSION['ss_id'];
                                    if (isset($user_id)) {
                                        echo $_SESSION['ssfullname'];
                                    }
                                    ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php if ($_SESSION['ss_status'] == 'ADMIN' or $_SESSION['ss_status'] == 'SUSER') { ?>
                                        <li><a href="index.php?page=admin/add_User&ss_id=<?= $_SESSION['ss_id'] ?>"><img src='images/personal.ico' width='25'> แก้ไขข้อมูลส่วนตัว</a></li>
                                        <li class="divider"></li>
                                        <?php if ($_SESSION['ss_process'] == '3' or $_SESSION['ss_process'] == '0') { ?>
                                            <li><a href="index.php?page=car/add_car"><img src='images/Settings.ico' width='25'> ตั้งค่ารถยนต์</a></li>
                                        <?php } if ($_SESSION['ss_process'] == '2' or $_SESSION['ss_process'] == '0') { ?>
                                            <li><a href="index.php?page=conferance/add_conf"><img src='images/Settings.ico' width='25'> ตั้งค่าห้องประชุม</a></li>
                                        <?php } ?>
                                        <?php if ($_SESSION['ss_status'] == 'ADMIN') { ?>
                                            <li><a href="index.php?page=admin/add_User"><img src='images/Settings.ico' width='25'> ตั้งค่าผู้ใช้งาน</a></li>
                                            <li><a href="index.php?page=admin/add_notify"><img src='images/Settings.ico' width='25'> ตั้งค่า Notify</a></li>
        <?php } echo "<li class='divider'></li>";
    }
    ?>
                                    <li><a href="#" onClick="return popup('about.php', popup, 500, 500);" title="เกี่ยวกับเรา"><img src='images/Paper Mario.ico' width='25'> เกี่ยวกับเรา</a></li>    
                                    <li class="divider"></li>
                                    <li><a href="index.php?page=process/logout"><img src='images/exit.ico' width='25'> Log Out</a></li>
                                </ul>
 <?PHP } ?>
                      </li>
                    </ul>  
                </div><!-- /.navbar-collapse -->
            </nav>
             <script type="text/javascript">
            function popup(url, name, windowWidth, windowHeight) {
                myleft = (screen.width) ? (screen.width - windowWidth) / 2 : 100;
                mytop = (screen.height) ? (screen.height - windowHeight) / 2 : 100;
                properties = "width=" + windowWidth + ",height=" + windowHeight;
                properties += ",scrollbars=yes,resizable=no,toolbar=no, top=" + mytop + ",left=" + myleft;
                window.open(url, name, properties);
            }
        </script>
            <script type="text/javascript">
                function inputDigits(sensor) {
                    var regExp = /[0-9.-]$/;
                    if (!regExp.test(sensor.value)) {
                        alert("กรอกตัวเลขเท่านั้นครับ");
                        sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                    }
                }
            </script>
            <?php
           /* function insert_date($take_date_conv) {
            $take_date = explode("-", $take_date_conv);
            $take_date_year = @$take_date[2] - 543;
            $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
            return $take_date;
        }*/

        function edit_date($take_date) {

            $take_date = explode("-", $take_date);
            $pyear = @$take_date[0] + 543;
            $take_date = "".@$take_date[2]."-".@$take_date[1]."-".$pyear."";
            return $take_date;
        }
        
        /////ตรวจสอบว่าค่านั้นเป็นประเภทวันที่หรือไม่    
    function validateDate($date, $format = 'Y-m-d H:i:s')//หาค่าว่าเป็นชนิด date หรือไม่
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
        ?>
            <div id="page-wrapper">

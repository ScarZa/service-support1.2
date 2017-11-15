<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  ข้อมูลรายละเอียดการใช้ห้องประชุม(รายเดือน) </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> การใช้ห้องประชุม(รายเดือน)</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางข้อมูลรายละเอียดการใช้ห้องประชุม(รายเดือน)</font></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <div class="form-group">
                <select name="month_id" id="month"  class="form-control" required=""> 
				<?php	$sql = mysqli_query($db,"SELECT month_id, month_name FROM month order by m_id");
				 echo "<option value=''>--เลือกเดือน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['month_id']."' $selected>".$result['month_name']." </option>";
				 } ?>
			 </select>
            </div> 
                        <div class="form-group"> 
                            <select name='year'  class="form-control" required="">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">ตกลง</button> 						
                    </form>
                <?php
               
                
                if (!empty($_POST['year'])) {
                    $year = $_POST['year'] - 543;
                    include 'option/function_date.php';
                    $years = $year + 543;
                    $sql_month = mysqli_query($db,"SELECT month_name FROM month where month_id='".$_POST['month_id']."'");
                    $month = mysqli_fetch_assoc( $sql_month );
                    
                    if($date >= $bdate and $date <= $edate){
                $take_month=$_POST['month_id'];                      
               
                            if($take_month=='1' or $take_month=='2' or $take_month=='3' or $take_month=='4' or $take_month=='5' or $take_month=='6' or $take_month=='7' or $take_month=='8' or $take_month=='9'){
                            $take_month1="$y-$take_month-01";
                             if($take_month=='4' or $take_month=='6' or $take_month=='9'){
                            $take_month2="$y-$take_month-30";  
                             }elseif ($take_month=='2') {
                            $take_month2="$y-$take_month-29"; 
                            }else{
                             $take_month2="$y-$take_month-31";
                            }
                             $take_date1="$Y-10-01";
                             $take_date2="$y-09-30"; 
                }elseif($take_month=='10' or $take_month=='11' or $take_month=='12') {
                    $take_month1="$Y-$take_month-01";
                    if($take_month=='11'){
                        $take_month2="$Y-$take_month-30"; 
                    }else{
                        $take_month2="$Y-$take_month-31";
                            }
                            $take_date1="$Y-10-01";
                            $take_date2="$y-09-30";
                }
    }  else {
                $take_month=$_POST['month_id'];
                
                if($take_month=='1' or $take_month=='2' or $take_month=='3' or $take_month=='4' or $take_month=='5' or $take_month=='6' or $take_month=='7' or $take_month=='8' or $take_month=='9'){
                 $this_year=$y;
                 $ago_year=$Y;
                  $take_month1="$this_year-$take_month-01";
                   if($take_month=='4' or $take_month=='6' or $take_month=='9'){
                               $take_month2="$this_year-$take_month-30";  
                             }elseif ($take_month=='2') {
                               $take_month2="$this_year-$take_month-29"; 
                            }else{
                             $take_month2="$this_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  elseif($take_month=='10' or $take_month=='11' or $take_month=='12') {
                 $this_year=$y;
                 $ago_year=$Y;
                 $next_year=$Yy;
                  $take_month1="$ago_year-$take_month-01";
                   if($take_month=='11'){
                               $take_month2="$ago_year-$take_month-30";  
                             }else{
                             $take_month2="$ago_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  else {
                 $this_year=$y;
                 $ago_year=$Y;   
                }
    }  

    $q="SELECT start_date,
SUM(CASE room
WHEN '1' THEN 1
WHEN '2' THEN 0
ELSE NULL END) AS bigroom,
SUM(CASE room
WHEN '1' THEN 0
WHEN '2' THEN 1
ELSE NULL END) AS smallroom,
COUNT(room) as totalroom
FROM ss_conferance
WHERE (start_date BETWEEN '$take_month1' AND '$take_month2') 
GROUP BY start_date 
UNION 
SELECT 'รวม' as total,
SUM(CASE room
WHEN '1' THEN 1
WHEN '2' THEN 0
ELSE NULL END) AS bigroom,
SUM(CASE room
WHEN '1' THEN 0
WHEN '2' THEN 1
ELSE NULL END) AS smallroom,
COUNT(room) as totalroom
FROM ss_conferance ssc
WHERE (start_date BETWEEN '$take_month1' AND '$take_month2') 
ORDER BY start_date";
    $qr = mysqli_query($db,$q);
       }         ?>
<div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_confM_<?= $month['month_name']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', '<?= $month['month_name'].$years?>');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" class="table table-responsive table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <td colspan="4"><h4>รายงานการใช้ห้องประชุม(รายเดือน)</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="4"><b>ปีงบประมาณ <?= isset($years)?$years:''?>  ประจำเดือน <?= isset($month['month_name'])?$month['month_name']:''?></b></td>
                    </tr>
                    <tr align="center" >
                        <td width="15%" align="center" bgcolor="#898888"><b>วันที่</b></td>
                        <td align="center" bgcolor="#898888"><b>ห้องประชุมกองสุข(ห้องใหญ่)</b></td>
                        <td align="center" bgcolor="#898888"><b>ห้องประชุมอุครานันท์(ห้องเล็ก)</b></td>
                        <td width="8%" align="center" bgcolor="#898888"><b>รวม</b></td>
                     </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_POST['year'])) {
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <?php if (validateDate($result['start_date'], 'Y-m-d')) {?>
                            <td align="center"><?= DateThai1($result['start_date']) ?></td>
                            <?php }else{?>
                            <td align="center"><?= $result['start_date'] ?></td>
                            <?php }?>
                            <td align="center"><?= $result['bigroom'] ?></td>
                            <td align="center"><?= $result['smallroom'] ?></td>
                            <td align="center"><?= $result['totalroom'] ?></td>
                        </tr>
                    <?php }}?>
                    </tbody>
                </table>
</div>
            </div>
        </div>
    </div>
</div>

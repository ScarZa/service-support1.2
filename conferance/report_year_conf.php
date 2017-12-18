<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  ข้อมูลรายละเอียดการใช้ห้องประชุม(รายปีงบประมาณ) </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> การใช้ห้องประชุม(รายปี)</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางข้อมูลรายละเอียดการใช้ห้องประชุม(รายปี)</font></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
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
                         if (!empty($_REQUEST['year'])) {
                $year = $_POST['year'] - 543;
                include 'option/function_date.php';
                
                    $this_year=$Y;
                    $next_year=$y;
                 }else{
                     include 'option/function_date.php';
                    if($date >= $bdate and $date <= $edate){
    //include 'option/function_date.php';
    $this_year=$y;
    $next_year=$Yy;
}  else {
    $this_year=$Y;
    $next_year=$y;
                } } 

    $q="SELECT m.month_name,
SUM(CASE ssc.room
WHEN '1' THEN 1
WHEN '2' THEN 0
ELSE NULL END) AS bigroom,
SUM(CASE ssc.room
WHEN '1' THEN 0
WHEN '2' THEN 1
ELSE NULL END) AS smallroom,
COUNT(ssc.room) as totalroom
FROM ss_conferance ssc
INNER JOIN month m on m.month_id=SUBSTR(start_date,6,2)
WHERE (start_date BETWEEN '$this_year-10-01' and '$next_year-09-30') and approve='Y'
GROUP BY m.m_id
UNION 
SELECT 'รวม' as total,
SUM(CASE ssc.room
WHEN '1' THEN 1
WHEN '2' THEN 0
ELSE NULL END) AS bigroom,
SUM(CASE ssc.room
WHEN '1' THEN 0
WHEN '2' THEN 1
ELSE NULL END) AS smallroom,
COUNT(ssc.room) as totalroom
FROM ss_conferance ssc
INNER JOIN month m on m.month_id=SUBSTR(ssc.start_date,6,2)
WHERE (ssc.start_date BETWEEN '$this_year-10-01' and '$next_year-09-30') and approve='Y'
";
    $qr = mysqli_query($db,$q);
       //}         ?>
<div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_confY_<?= $_POST['year']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', '<?= $_POST['year']?>');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" class="table table-responsive table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <td colspan="4"><h4>รายงานการใช้ห้องประชุม(รายปี)</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="4"><b>ปีงบประมาณ <?= isset($_POST['year'])?$_POST['year']:''?></b></td>
                    </tr>
                    <tr align="center" >
                        <td width="15%" align="center" bgcolor="#898888"><b>เดือน</b></td>
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
                            <td align="center"><?= $result['month_name'] ?></td>
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

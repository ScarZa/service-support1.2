<?php require_once 'header.php'; ?>
<!-- Content Header (Page header) -->
<?php
function getRenderedHTML($path) {
    ob_start();
    include_once ("$path.php");
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}
if (isset($_SESSION['ss_id'])) {
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
        echo getRenderedHTML($page);
    } else { 
        include_once ('option/funcDateThai.php');
                        include 'option/function_date.php';
                        if (empty($_POST['year'])) {
                            
                            if($date >= $bdate and $date <= $edate){
                             $y= $Yy;
                             $Y= date("Y");
                             $year = $Yy;
                        $years = $year + 543;
                            }else{
                            $y = date("Y");
                            $Y = date("Y") - 1;
                            $year = date('Y');
                            $years = $year + 543;
                            }
                        } else {
                            $y = $_POST['year'] - 543;
                            $Y = $y - 1;
                            $year = $_POST['year'] - 543;
                            $years = $year + 543;
                        }
                        
  //////////////// graph line conf /////////////////////////
                        $month_start = "$Y-10-01";
                        $month_end = "$y-09-30";
                    
                        $num_license = mysqli_query($db,"select count(room_id) as count_room from ss_room");
                        $count_license = mysqli_fetch_assoc($num_license);
                        $count_cl = $count_license['count_room'];
                    
                    $sql2 = mysqli_query($db, "select room_name from ss_room ORDER BY room_id ASC");
                    while ($rs2 = mysqli_fetch_assoc($sql2)){
                    @$name_license[].=$rs2['room_name'];
                    }
                   $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
                        } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        $C=0;
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select COUNT(conf_id) as conf from ss_conferance
						 where  room='$c' and start_date between '$month_start' and '$month_end' and approve='Y' order by conf_id");
                        
                        $rs = mysqli_fetch_assoc($sql);
                       
                        @$countnum[$C].= $rs['conf'] . ',';
                        $C++;
                        }
                        @$name.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysqli_error($db);
    //////////////// End graph line conf ///////////////////////// 
    //////////////// begin graph pie conf1 ///////////////////////// 
                    $m_start = "$Y-10-01";
                    $m_end = "$y-09-30";
//                    $sql1=  mysqli_query($db, "SELECT sscl.license_name as cl_name,
//(SELECT COUNT(ssc.car_id) from ss_car ssc where sscl.license_id=ssc.license_plate and ((ssc.start_date between '$m_start' and '$m_end') AND
//(ssc.end_date between '$m_start' and '$m_end')) and ssc.pay='Y' and approve='Y')use_car
//FROM ss_car ssc
//LEFT OUTER JOIN ss_carlicense sscl on sscl.license_id=ssc.license_plate
//WHERE sscl.license_id=ssc.license_plate and ssc.pay='Y' and approve='Y'
//GROUP BY sscl.license_id  
//order by sscl.license_id");
    //////////////// End graph pie conf1 ///////////////////////// 
    //////////////// End graph pie conf2 /////////////////////////
     $sql2=  mysqli_query($db, "SELECT COUNT(conf_id) big
,(SELECT COUNT(conf_id) FROM ss_conferance WHERE room=2 and start_date between '$m_start' and '$m_end' and approve='Y')small
FROM ss_conferance WHERE room=1 and start_date between '$m_start' and '$m_end' and approve='Y'");
              $row = mysqli_fetch_assoc($sql2);   
    //////////////// begin graph pie conf2 /////////////////////////                
        ?>
<script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                Highcharts.theme = {
    colors: ['#2b908f', '#90ee7e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066',
        '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
    chart: {
        backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
                [0, '#2a2a2b'],
                [1, '#3e3e40']
            ]
        },
        style: {
            fontFamily: '\'Unica One\', sans-serif'
        },
        plotBorderColor: '#606063'
    },
    title: {
        style: {
            color: '#E0E0E3',
            textTransform: 'uppercase',
            fontSize: '20px'
        }
    },
    subtitle: {
        style: {
            color: '#E0E0E3',
            textTransform: 'uppercase'
        }
    },
    xAxis: {
        gridLineColor: '#707073',
        labels: {
            style: {
                color: '#E0E0E3'
            }
        },
        lineColor: '#707073',
        minorGridLineColor: '#505053',
        tickColor: '#707073',
        title: {
            style: {
                color: '#A0A0A3'

            }
        }
    },
    yAxis: {
        gridLineColor: '#707073',
        labels: {
            style: {
                color: '#E0E0E3'
            }
        },
        lineColor: '#707073',
        minorGridLineColor: '#505053',
        tickColor: '#707073',
        tickWidth: 1,
        title: {
            style: {
                color: '#A0A0A3'
            }
        }
    },
    tooltip: {
        backgroundColor: 'rgba(0, 0, 0, 0.85)',
        style: {
            color: '#F0F0F0'
        }
    },
    plotOptions: {
        series: {
            dataLabels: {
                color: '#B0B0B3'
            },
            marker: {
                lineColor: '#333'
            }
        },
        boxplot: {
            fillColor: '#505053'
        },
        candlestick: {
            lineColor: 'white'
        },
        errorbar: {
            color: 'white'
        }
    },
    legend: {
        itemStyle: {
            color: '#E0E0E3'
        },
        itemHoverStyle: {
            color: '#FFF'
        },
        itemHiddenStyle: {
            color: '#606063'
        }
    },
    credits: {
        style: {
            color: '#666'
        }
    },
    labels: {
        style: {
            color: '#707073'
        }
    },

    drilldown: {
        activeAxisLabelStyle: {
            color: '#F0F0F3'
        },
        activeDataLabelStyle: {
            color: '#F0F0F3'
        }
    },

    navigation: {
        buttonOptions: {
            symbolStroke: '#DDDDDD',
            theme: {
                fill: '#505053'
            }
        }
    },

    // scroll charts
    rangeSelector: {
        buttonTheme: {
            fill: '#505053',
            stroke: '#000000',
            style: {
                color: '#CCC'
            },
            states: {
                hover: {
                    fill: '#707073',
                    stroke: '#000000',
                    style: {
                        color: 'white'
                    }
                },
                select: {
                    fill: '#000003',
                    stroke: '#000000',
                    style: {
                        color: 'white'
                    }
                }
            }
        },
        inputBoxBorderColor: '#505053',
        inputStyle: {
            backgroundColor: '#333',
            color: 'silver'
        },
        labelStyle: {
            color: 'silver'
        }
    },

    navigator: {
        handles: {
            backgroundColor: '#666',
            borderColor: '#AAA'
        },
        outlineColor: '#CCC',
        maskFill: 'rgba(255,255,255,0.1)',
        series: {
            color: '#7798BF',
            lineColor: '#A6C7ED'
        },
        xAxis: {
            gridLineColor: '#505053'
        }
    },

    scrollbar: {
        barBackgroundColor: '#808083',
        barBorderColor: '#808083',
        buttonArrowColor: '#CCC',
        buttonBackgroundColor: '#606063',
        buttonBorderColor: '#606063',
        rifleColor: '#FFF',
        trackBackgroundColor: '#404043',
        trackBorderColor: '#404043'
    },

    // special colors for some of the
    legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
    background2: '#505053',
    dataLabelsColor: '#B0B0B3',
    textColor: '#C0C0C0',
    contrastTextColor: '#F0F0F3',
    maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);
                                Highcharts.setOptions({
                                    colors: ['#3ec613', '#cc6945', '#6c94dd', 'purple', '#d92727', 'orange', 'yellow']    
                                });
                                chart = new Highcharts.Chart({
                                    
                                    chart: {
                                        renderTo: 'containerconf',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'จำนวนการใช้ห้องประชุมในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'จำนวนครั้ง'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ครั้ง';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 0; $c < $count_cl; $c++) {?>
                                    {
                                        
                                            name: '<?= $name_license[$c]?>',
                                            data: [<?= $countnum[$c]?>]
                                        
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'containconf',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการใช้รถในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [<?php
                while ($row1 = mysqli_fetch_assoc($sql1)) {
                    $depnamex = $row1['cl_name'];
                    $countx = $row1['use_car'];
                    $sss = "['" . $depnamex . "'," . $countx . "],";
                    echo $sss;
                }
                ?>
                                            ]
                                        }]
                                });
                            });

                        });
                    </script>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'containconf2',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการห้องประชุม <br> ในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [
                                                ['ห้องประชุมใหญ่', <?= $row['big'] ?>],
                                                ['ห้องประชุมเล็ก', <?= $row['small'] ?>]
                                        ]
                                        }]
                                });
                            });

                        });
                    </script>
        <section class="content-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <div class="col-lg-1 col-md-2 col-xs-3" align="center"><img src='../hrd1.9/<?= $fol . $pic; ?>' width="80"></div>
                        <div class="col-lg-11 col-md-10 col-xs-9" valign="top">
                            <h2><b>ระบบบริการและสนับสนุน </b><small><br><b><font color="green">
        <?php echo $resultHos['name']; ?></font></b></small></h2>
                            ยินดีต้อนรับสู่ <a class="alert-link" href="http://startbootstrap.com" target="_blank"> ระบบบริการและสนับสนุน</a>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
            </div>
            <div>
                <ol class="breadcrumb alert-warning">
              <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
                    <li class="active"><i class="fa fa-hospital"></i> หน้าหลัก</li>
                </ol>  
            </div>
        </section>
        <section class="content">

<div class="row">
    <!----- ขอใช้ห้องประชุม -------->
            <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Use of meeting room Statistics :                 
                        <?php
                        
                        $date_start = "$Y-10-01";
                        $date_end = "$y-09-30";
                        echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                        ?>	</h3>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 col-xs-12">
                    <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                    </form>
                    </div><br><br><br>
                    <?="<center>รายงานการใช้ห้องประชุม&nbsp;&nbsp;ปีงบประมาณ : $years</center>"?>
                    
                
                    <?php
            /*        echo "<center>";
                    echo "รายงานระยะทางการใช้รถยนต์ : ทั้งหมด";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    for ($c = 1; $c <= $count_cl; $c++) {
                    $sql4 = mysqli_query($db, "select license_name from ss_carlicense where license_id='$c'");
                    $rs4 = mysqli_fetch_assoc($sql4);
                    $name_license4[$c].=$rs4['license_name'] . ',';
                    }
                   $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
              /*          } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select sum(distance) as distance from ss_car  
						 where  license_plate='$c' and start_date between '$month_start' and '$month_end' order by license_plate");
                        
                        $rs3 = mysqli_fetch_assoc($sql);
                       
                        $distance[$c].= $rs3['distance'] . ',';
                        }
                        $name2.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysql_error(); */?>
                    <!--<script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container01',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'ระยะทางการใช้รถยนต์ในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?//= $name2; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'ระยะทาง (ก.ม.)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ก.ม.';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php// for ($c = 1; $c <= $count_cl; $c++) {?>
                                    {
                                            name: '<?//= $name_license4[$c]?>',
                                            data: [<?//= $distance[$c]?>]
                                        },
                                                <?php// }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container01" style="margin: 0 auto"></div>
                    </div>
                    </div>-->
                     
                    <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="containerconf" style="margin: 0 auto"></div>
                    </div>
                    </div>
                    <br><br>
<!--                    <div class="col-lg-6 col-xs-12" id="containconf" style="margin: 0 auto"></div>-->
                    <div class="col-lg-6 col-xs-12" id="containconf2" style="margin: 0 auto"></div>
                    </div>
                </div>
            </div>
    <!----- ขอใช้รถ -------->
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Use of cars Statistics :                 
                        <?php
                        
                        $date_start = "$Y-10-01";
                        $date_end = "$y-09-30";
                        echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                        ?>	</h3>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 col-xs-12">
                    <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                    </form>
                    </div><br><br><br>
                    <?php
               echo "<center>";



                    echo "รายงานการใช้น้ำมัน";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    
                    $num_license = mysqli_query($db,"select count(license_id) as count_cl from ss_carlicense");
                        $count_license = mysqli_fetch_assoc($num_license);
                        $count_cl = $count_license['count_cl'];
                    
                    $sql2 = mysqli_query($db, "select license_name from ss_carlicense ORDER BY license_id ASC");
                    while ($rs2 = mysqli_fetch_assoc($sql2)){
                    @$name_license1[].=$rs2['license_name'];
                    }
                   $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month2 = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
                        } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        $C=0;
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select if(ISNULL(sum(bath)),0,sum(bath)) as sum_oil from ss_detial_oil   
						 where  license_id='$c' and reg_date between '$month_start' and '$month_end' order by license_id");
                        
                        $rs = mysqli_fetch_assoc($sql);
                       
                        @$countnum1[$C].= $rs['sum_oil'] . ',';
                        $C++;
                        }
                        @$name1.="'".$month2['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysqli_error($db);?>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'จำนวนการใช้น้ำมันในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name1; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'จำนวนเงิน (บาท)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' บาท';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 0; $c < $count_cl; $c++) {?>
                                    {
                                        
                                            name: '<?= $name_license1[$c]?>',
                                            data: [<?= $countnum1[$c]?>]
                                        
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container" style="margin: 0 auto"></div>
                    </div>
                    </div>
                    <br><br>
                    <?php
            /*        echo "<center>";
                    echo "รายงานระยะทางการใช้รถยนต์ : ทั้งหมด";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    for ($c = 1; $c <= $count_cl; $c++) {
                    $sql4 = mysqli_query($db, "select license_name from ss_carlicense where license_id='$c'");
                    $rs4 = mysqli_fetch_assoc($sql4);
                    $name_license4[$c].=$rs4['license_name'] . ',';
                    }
                   $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
              /*          } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select sum(distance) as distance from ss_car  
						 where  license_plate='$c' and start_date between '$month_start' and '$month_end' order by license_plate");
                        
                        $rs3 = mysqli_fetch_assoc($sql);
                       
                        $distance[$c].= $rs3['distance'] . ',';
                        }
                        $name2.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysql_error(); */?>
                    <!--<script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container01',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'ระยะทางการใช้รถยนต์ในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name2; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'ระยะทาง (ก.ม.)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ก.ม.';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 1; $c <= $count_cl; $c++) {?>
                                    {
                                            name: '<?= $name_license4[$c]?>',
                                            data: [<?= $distance[$c]?>]
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container01" style="margin: 0 auto"></div>
                    </div>
                    </div>-->
                    
                 <?php   
                    $m_start = "$Y-10-01";
                    $m_end = "$y-09-30";
                    $sql=  mysqli_query($db, "SELECT sscl.license_name as cl_name,
(SELECT COUNT(ssc.car_id) from ss_car ssc where sscl.license_id=ssc.license_plate and ((ssc.start_date between '$m_start' and '$m_end') AND
(ssc.end_date between '$m_start' and '$m_end')) and ssc.pay='Y' and approve='Y')use_car
FROM ss_car ssc
LEFT OUTER JOIN ss_carlicense sscl on sscl.license_id=ssc.license_plate
WHERE sscl.license_id=ssc.license_plate and ssc.pay='Y' and approve='Y'
GROUP BY sscl.license_id  
order by sscl.license_id");
?>
                    
                    
                    
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'contain',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการใช้รถในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [<?php
                while ($row = mysqli_fetch_assoc($sql)) {
                    $depnamex = $row['cl_name'];
                    $countx = $row['use_car'];
                    $sss = "['" . $depnamex . "'," . $countx . "],";
                    echo $sss;
                }
                ?>
                                            ]
                                        }]
                                });
                            });

                        });
                    </script>
                    <div class="col-lg-6 col-xs-12" id="contain" style="margin: 0 auto"></div>
      <?php
      $sql=  mysqli_query($db, "SELECT count(car_id) as in_province,
(select count(car_id) from ss_car where province!='30' and((start_date between '$m_start' and '$m_end') AND
(end_date between '$m_start' and '$m_end')) and pay='Y' and approve='Y') out_province
FROM `ss_car` 
where province='30' and((start_date between '$m_start' and '$m_end') AND
(end_date between '$m_start' and '$m_end')) and pay='Y' and approve='Y'");
              $row = mysqli_fetch_assoc($sql);
      ?>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'contain2',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการใช้รถภายใน/ภายนอกจังหวัด <br> ในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [
                                                ['ภายในจังหวัด', <?= $row['in_province'] ?>],
                                                ['ภายนอกจังหวัด', <?= $row['out_province'] ?>]
                                        ]
                                        }]
                                });
                            });

                        });
                    </script>
                    <div class="col-lg-6 col-xs-12" id="contain2" style="margin: 0 auto"></div>
                    
                    
                    </div>
                </div>
            </div>
        </div>
        </section>
    <?php }
} else { ?>
    <!-- Main content -->
    <section class="content">
        <meta http-equiv='refresh' content='0;url=fullcalendar1_2.php' />
    </section>
<?php } ?>


<?php require_once 'footer.php'; ?>
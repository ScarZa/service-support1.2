 <section class="content-header">
 <div class="row">
          <div class="col-lg-12">
              <h1> <font color="blue">ตั้งค่า Notify</font></h1>
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่า Notify</li>
            </ol>
          </div>
        </div><!-- /.row -->
</section>
			<?php include 'connection/connect.php';
			 $sqlGet=mysqli_query($db,"select * from notify where notify_id=2 or notify_id=3");
			 while($resultGet=mysqli_fetch_assoc($sqlGet)){
         $res[]=$resultGet['notify_tokenkey'];
         $id[]=$resultGet['notify_id'];
       }
			  
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-6 col-xs-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่า Notify</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcnotify' method='post' enctype="multipart/form-data">
                        <div class="form-group">	
			<b>Notify ระบบจองห้องประชุม</b>
                        <input type='text' name='room_notify_tokenkey'  size="50"  id='room_notify_tokenkey' placeholder='ใส่ token key' class='form-control' value='<?= isset($res[1])?$res[1]:''?>' required>
			 </div> <br><br>
       <div class="form-group">	
			<b>Notify ระบบจองรถยนต์</b>
                        <input type='text' name='car_notify_tokenkey'  size="50"  id='car_notify_tokenkey' placeholder='ใส่ token key' class='form-control' value='<?= isset($res[0])?$res[0]:''?>' required>
			 </div> 
                        <br><br>
                        
 <?PHP 

                echo "<input type='hidden' name='room_notify_id' value='".$id[1]."'><input type='hidden' name='car_notify_id' value='".$id[0]."'>";
		echo "<input type='hidden' name='method' value='notify'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"> </p>
		</form>

      </div>
    </div>
              </div>
</div>
</section>
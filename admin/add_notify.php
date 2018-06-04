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
			 $sqlGet=mysqli_query($db,"select * from notify where notify_id=3");
			 $resultGet=mysqli_fetch_assoc($sqlGet);
			  
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-6 col-xs-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ตั้งค่า Notify</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcroom' method='post' enctype="multipart/form-data">
                        <div class="form-group">	
			<b>Notify</b>
                        <input type='text' name='notify_tokenkey'  size="50"  id='notify_tokenkey' placeholder='ใส่ token key' class='form-control' value='<?= isset($resultGet['notify_tokenkey'])?$resultGet['notify_tokenkey']:''?>' required>
			 </div> 
                        <br><br>
                        
 <?PHP 

                echo "<input type='hidden' name='notify_id' value='".$resultGet['notify_id']."'>";
		echo "<input type='hidden' name='method' value='notify'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"> </p>
		</form>

      </div>
    </div>
              </div>
</div>
</section>
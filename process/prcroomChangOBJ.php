<?php 
  @session_start(); 
  header('Content-type: text/json; charset=utf-8');
  
        include '../connection/connect.php';
        include '../option/funcDateThai.php'; 

        $conf_id=$_POST['conf_id'];
        $obj=$_POST['obj'];

        $edit = mysqli_query($db,"update ss_conferance set obj='$obj' where conf_id='$conf_id'");

        if ($edit == false) {
          $res = array("messege"=>'บันทึกข้อมูลไม่สำเร็จครับ!!!!',"check"=>'N');
        }else{
          $res = array("messege"=>'บันทึกข้อมูลสำเร็จครับ!!!!',"check"=>'Y');
        }
        print json_encode($res);
        
?>
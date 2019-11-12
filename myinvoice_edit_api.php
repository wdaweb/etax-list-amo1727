<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["upk"])) {
  $upk = fun_testinput($_POST["upk"]);
  $first_id=fun_testinput($_POST['first_id']);
  $last_num=fun_testinput($_POST['last_num']);
  $invoice_price=fun_testinput($_POST['invoice_price']);
  $invoice_date=fun_testinput($_POST['invoice_date']);  

  $editdata=[];
  $editdata['first_id']=$first_id; 
  $editdata['last_num']=$last_num;  
  $editdata['invoice_price']=$invoice_price;  
  $editdata['invoice_date']=$invoice_date;  
  $editdata['user_data_pk']=$_SESSION['userpk']; 
  $editdata['modify_time']=date("Y-m-d h:i:s"); 
  $result=fun_updateDB('user_invoice',$upk,$editdata);
  if ($result) {
    fun_alertmsg ('修改成功！ \n','myinvoice.php');
    exit();
  }else{
    fun_alertmsg ('修改失敗！ \n','myinvoice_edit.php?upk='.$upk);
    exit();
  }
}
?>
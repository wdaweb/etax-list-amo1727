<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["sub_add"])) {
  $first_id=fun_testinput($_POST['first_id']);
  $last_num=fun_testinput($_POST['last_num']);
  $invoice_price=fun_testinput($_POST['invoice_price']);
  $invoice_date=fun_testinput($_POST['invoice_date']);  

  $adddata=[];
  $adddata['first_id']=$first_id; 
  $adddata['last_num']=$last_num;  
  $adddata['invoice_price']=$invoice_price;  
  $adddata['invoice_date']=$invoice_date;  
  $adddata['user_data_pk']=$_SESSION['userpk']; 
  $result=fun_insertDB('user_invoice',$adddata);
  if ($result) {
    fun_alertmsg ('新增成功！ \n','myinvoice.php');
    exit();
  }else{
    fun_alertmsg ('新增失敗！ \n','myinvoice_add.php');
    exit();
  }
}
?>
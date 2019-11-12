<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ayear = fun_testinput($_POST["ayear"]);
  $anum = fun_testinput($_POST["anum"]);

  if (empty($ayear) || empty($anum)) {
      fun_alertmsg ('【西元年】【筆數】不可空白！ \n','invoice_autoproduce.php');
      exit();
  } else {
    if (!is_numeric($anum)) {
      fun_alertmsg ('【筆數】請填入數字！ \n','invoice_autoproduce.php');
      exit();
    }else{
      $success_i=0;
      for ($i=1; $i <= (int)$anum ; $i++) { 
        
        $insdata=[];
        $insdata['user_data_pk']=$_SESSION['userpk'];
        $insdata['first_id']=fun_randfirstid(); 
        $insdata['last_num']=fun_randlastnum();  
        $insdata['invoice_price']=fun_randprice(); 
        $insdata['invoice_date']=fun_randdate($ayear); 
        $result=fun_insertDB('user_invoice',$insdata);
        if ($result) {
          $success_i++;  
        }
      }
      fun_alertmsg ('共產生'. $success_i .'筆！ \n','main.php');
      exit();
    }
  }
}


?>

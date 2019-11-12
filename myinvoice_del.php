<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["dpk"])) {
  $dpk = fun_testinput($_GET["dpk"]);
  $result=fun_delDB('user_invoice',$dpk);
  if ($result) {
    fun_alertmsg ('刪除成功！ \n','myinvoice.php');
    exit();
  }else{
    fun_alertmsg ('刪除失敗！ \n','myinvoice.php');
    exit();
  }
}
?>
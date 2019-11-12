<?php
include_once 'include/_common.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $acc = fun_testinput($_POST["acc"]);
  $pw = fun_testinput($_POST["pw"]);

  if (empty($acc) || empty($pw)) {
      fun_alertmsg ('【帳號】【密碼】不可空白！ \n','index.php');
      exit();
  } else {
    $data=fun_loginDB($acc,$pw);
    if (!empty($data)) {
      $_SESSION['userpk'] = $data['pk'];
      $_SESSION['username'] = $data['name'];
      fun_alertmsg ('登入成功！ \n','main.php');
      exit();
    } else {
      fun_alertmsg ('登入失敗，請重新填寫帳密！ \n','index.php');
      exit();
    }
    $conn = null;
  }
}
?>




?>
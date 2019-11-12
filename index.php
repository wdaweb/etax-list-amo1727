<?php 
include_once 'include/_common.php';
if (!empty($_GET['logout'])) {
  if ($_GET['logout'] == '1') {
    unset($_SESSION['userpk']);
    fun_alertmsg ("已登出系統!!","index.php");
    exit();
  } 
}
if (!empty($_SESSION["userpk"])) {
  header("location: main.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="#" type="image/x-icon">
  <title>統一發票紀錄與對獎系統</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <div id="login">
    <h1>統一發票紀錄與對獎系統</h1>
    <form action="login_api.php" method="post"> 
    <table class="wrapper">
      <tr>
        <td>帳號：</td>
        <td><input type="text" name="acc" id="acc" value="adm"></td>
      </tr>
      <tr>
        <td>密碼：</td>
        <td><input type="password" name="pw" id="pw" value="admpw"></td>
      </tr>
      <tr>
        <td colspan="2" class="ct">
            <input type="submit" value="登入">
        </td>
      </tr>
    </table>
    </form> 
  </div> 
</body>
</html>

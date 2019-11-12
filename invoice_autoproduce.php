<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="#" type="image/x-icon">
  <title>統一發票紀錄與對獎系統-發票資料產生器</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include_once 'include/_header.php';?>
  <div class="main">
    <div class="menu">
      <ul>
        <li class="b"><a href="main.php">當期統一發票中獎號碼與中獎清單</a></li>
        <li class="b"><a href="myinvoice.php">我的發票</a></li>
        <li class="b"><a href="winnum.php">中獎號碼登錄</a></li>
        <li class="a">發票資料產生器</li>
      </ul>
    </div>
    <div class="clear"></div>
    <div class="cont">
      <h1>發票資料產生器</h1>
      <form action="invoice_autoproduce_api.php" method="post">
        <table class="table-bordered">
          <tr>
            <th>西元年</th>
            <td class="title">
              <select name="ayear" id="ayear">
              <option value=""></option>
                <?php 
                for ($i=2018; $i <= date("Y"); $i++) { 
                  echo '<option value="'.$i.'">'.$i.'</option>\n';
                }
                ?>
              </select></td>
          </tr>
          <tr>
            <th>筆數</th>
            <td class="number">
              <input type="text" id="anum" name="anum" maxlength="4">
            </td>
          </tr>
        </table>
        <div class="win subarea"><input type="submit" value=" 開 始 產 生 "></div>
      </form>
    </div>
  </div>
  <script src="./js/timeout.js"></script>
</body>
</html>
<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["upk"])) {
  $upk = fun_testinput($_GET["upk"]);
  $sql="select * from user_invoice where user_data_pk = '". $_SESSION['userpk'] ."' and pk ='". $upk ."'";
  $data=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
  if (!empty($data)) {
    $first_id=$data['first_id'];
    $last_num=$data['last_num'];
    $invoice_price=$data['invoice_price'];
    $invoice_date=$data['invoice_date'];  
  }
}else{
  fun_alertmsg ('無此發票!!','myinvoice.php');
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
  <title>統一發票紀錄與對獎系統-我的發票</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include_once 'include/_header.php';?>
  <div class="main">
    <div class="menu">
      <ul>
        <li class="b"><a href="main.php">當期統一發票中獎號碼與中獎清單</a></li>
        <li class="a">我的發票</li>
        <li class="b"><a href="winnum.php">中獎號碼登錄</a></li>
        <li class="b"><a href="invoice_autoproduce.php">發票資料產生器</a></li>
      </ul>
    </div>
    <div class="clear"></div>
    <div class="cont">
      <h1>我的發票</h1>
      <div class="backarea">[<a href="myinvoice.php">回發票列表</a>]</div>
      <h2>發票修改</h2>
      <form action="myinvoice_edit_api.php" method="post" onsubmit="return chk_myinvoice(this);">
      <table class="table-bordered"> 
         <tr> 
          <th >號碼</th> 
          <td ><input type="text" class="txt_first_id" id="first_id" name="first_id" maxlength="2" value="<?php echo $first_id?>"> <input type="text" class="txt_last_num" id="last_num" name="last_num" maxlength="8" value="<?php echo $last_num?>"></td> 
         </tr> 
         <tr> 
          <th >金額</th> 
          <td class="number">NT$ <input type="text" class="txt_invoice_price" id="invoice_price" name="invoice_price" maxlength="5" value="<?php echo $invoice_price?>">元</td> 
         </tr>
         <tr> 
          <th >日期</th> 
          <td ><input type="date" class="txt_invoice_date" id="invoice_date" name="invoice_date" maxlength="10" value="<?php echo $invoice_date?>"></td> 
         </tr>
       </table> 
       <div class="win subarea"><input type="submit" value="儲 存"><input type="hidden" name="upk" value="<?php echo $upk?>"></div>
       </form>
    </div>
  </div>
  <script src="./js/chk_form.js"></script>
  <script src="./js/timeout.js"></script>
</body>
</html>
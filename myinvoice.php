<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
// 最新一期
$sql="select winnum_year,winnum_stage from `winnum_original` order by winnum_year DESC,winnum_stage DESC";
$rows=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
$ystage_new=$rows["winnum_year"].$rows["winnum_stage"];

// 搜尋
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["sub_srh"])) {
  $srh_ystage = fun_testinput($_POST["srh_ystage"]);
  if (fun_chkStage($srh_ystage)) {
    $_SESSION["srh_ystage"]=$srh_ystage;
  }
}
if (empty($_SESSION["srh_ystage"])) {
  $_SESSION["srh_ystage"]=$ystage_new;
}

// 把搜尋條件帶入db 
$srhsqlcount="select count(*) as tCount from user_invoice where user_data_pk = '". $_SESSION['userpk'] ."' ". fun_stage_datebetween(substr($_SESSION["srh_ystage"], 0, 4),substr($_SESSION["srh_ystage"], 4, 1)). "";
$rowsCount=$pdo->query($srhsqlcount)->fetch();
$tTotal=$rowsCount["tCount"];

$tSum = 1;    //'總筆數
$tPageTotal = 1;    //'總頁數
$tPageSize = 50;    //'每頁筆數
if ($tTotal == 0) {
	$tPageTotal = 1 ;
}else{
	$tPageTotal = ceil($tTotal/$tPageSize);
}
if (!isset($_GET["tPage"])){
    $tPage = 1;
} else {
    $tPage = intval($_GET["tPage"]);
}
$tPageStart = ($tPage - 1) * $tPageSize;
$limit_sql=" LIMIT ". ($tPage-1)*$tPageSize .",". $tPage*$tPageSize ." ";

$srhsql="select * from user_invoice where user_data_pk = '". $_SESSION['userpk'] ."' ". fun_stage_datebetween(substr($_SESSION["srh_ystage"], 0, 4),substr($_SESSION["srh_ystage"], 4, 1)). " order by invoice_date DESC ".$limit_sql;
// echo $srhsql;
// exit();
$rows=$pdo->query($srhsql)->fetchAll();
$list_str="";
foreach ($rows as $k => $v) {
  $list_str.='<tr>';
  $list_str.='<td>'. $v['first_id'] .'-'. $v['last_num'] .'</td>';
  $list_str.='<td>'. $v['invoice_price'] .'</td>';
  $list_str.='<td>'. $v["invoice_date"] .'</td>';
  $list_str.='<td>[ <a href="myinvoice_edit.php?upk='. $v['pk'] .'">修改</a> ] [ <a href="#" onClick="if(confirm(\'確定刪除嗎\')){location.href=\'myinvoice_del.php?dpk='. $v['pk'] .'\';} else{ return false ; }">刪除</a> ]</td>';
  $list_str.='</tr>';      
}

// 上下頁
$ThisPage_url = 'myinvoice.php';
$tPageSelMsg = '';
if ($tPageTotal > 1) {
	$tPageSelMsg .= '<ul>';
	if ($tPage == 1) {
    $tPageSelMsg .= '<li><i class="fas fa-angle-double-left"></i></li>';
    $tPageSelMsg .= '<li><i class="fas fa-angle-left"></i></li>';
    $tPageSelMsg .= '<li>'. $tPage .'</li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPage + 1) . '"><i class="fas fa-angle-right"></i></a></li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPageTotal) . '"><i class="fas fa-angle-double-right"></i></a></li>';
	} elseif ($tPage ==  $tPageTotal) {
		$tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=1"><i class="fas fa-angle-double-left"></i></a></li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPage - 1) . '"><i class="fas fa-angle-left"></i></a></li>';
    $tPageSelMsg .= '<li>'. $tPage .'</li>';
    $tPageSelMsg .= '<li><i class="fas fa-angle-right"></i></li>';
    $tPageSelMsg .= '<li><i class="fas fa-angle-double-right"></i></li>';
	} else {
		$tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=1"><i class="fas fa-angle-double-left"></i></a></li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPage - 1) . '"><i class="fas fa-angle-left"></i></a></li>';
    $tPageSelMsg .= '<li>'. $tPage .'</li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPage + 1) . '"><i class="fas fa-angle-right"></i></a></li>';
    $tPageSelMsg .= '<li><a href="'. $ThisPage_url .'?tPage=' . ($tPageTotal) . '"><i class="fas fa-angle-double-right"></i></a></li>';
	}
	$tPageSelMsg .= '</ul>';
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
  <link rel="stylesheet" href="./css/all.min.css">
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
      <form action="myinvoice.php" method="post"> 
      <table class="table-search"> 
        <tr> 
         <th>搜尋</th> 
         <td>期別：
          <select name="srh_ystage">
            <?php 
            for ($i=date("Y"); $i >= 2018; $i--) { 
              for ($j=6; $j >= 1 ; $j--) { 
                $selstr="";
                if ($i==substr($_SESSION["srh_ystage"], 0, 4) && $j==substr($_SESSION["srh_ystage"], 4, 1)) {
                  $selstr=" selected ";
                }
                echo '<option value="'.$i.$j.'" '. $selstr .'>西元'.$i.'年'.fun_stageName($j).'</option>';
              }
            }
            ?>
        </select>
         </td> 
         <th><input type="submit" value="開始搜尋"><input type="hidden" name="sub_srh" value="1"></th>
        </tr> 
      </table> 
      </form>
      <table class="table-invoicelist"> 
         <tr> 
          <th>號碼</th> 
          <th>金額</th> 
          <th>日期</th>
          <th>[ <a href="myinvoice_add.php">新增</a> ]</th>
         </tr> 
         <?php echo $list_str;?>
       </table> 
       <div class="page_next">
         <div class="updown">
           <?php echo $tPageSelMsg;?>
        </div>
         <div class="info">共 <?php echo $tPageTotal;?> 頁 / 共 <?php echo $tTotal;?> 筆</div>
       </div>
    </div>
  </div>
  <script src="./js/timeout.js"></script>
</body>
</html>
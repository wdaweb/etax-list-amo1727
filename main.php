<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
$new_ystage="1";
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["ystage"])) {
  $ystage = fun_testinput($_GET["ystage"]);
  if (fun_chkStage($ystage)) {
    $new_ystage="0";
  }
}
if ($new_ystage=="1") {
  // 最新一期
  $sql="select winnum_year,winnum_stage from `winnum_original` order by winnum_year DESC,winnum_stage DESC";
  $rows=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
  $ystage=$rows["winnum_year"].$rows["winnum_stage"];
}
$winnum_year=substr($ystage, 0, 4);
$winnum_stage=substr($ystage, 4, 1);
$data=fun_findDB_winnum_o($winnum_year,$winnum_stage);
if (!empty($data)) {
  $winnum_opk=$data['pk'];
  $special1_num=$data['special1_num'];
  $special2_num=$data['special2_num'];
  $head1_num=$data['head1_num'];
  $head2_num=$data['head2_num'];
  $head3_num=$data['head3_num']; 

  $data6=fun_findDB_winnum_6($winnum_opk);
  $num6_ii=0;
  $num6_str="";
  foreach ($data6 as $v) {
    $num6_str.="<p>". $v["winadd6_num"] ."</p> ";
    
    $num6_ii++;
    if ($num6_ii==1) {
      $winadd6_num1=$v['winadd6_num'];
    } elseif($num6_ii==2) {
      $winadd6_num2=$v['winadd6_num'];
    } elseif($num6_ii==3) {
      $winadd6_num3=$v['winadd6_num'];
    } elseif($num6_ii==4) {
      $winadd6_num4=$v['winadd6_num'];
    } elseif($num6_ii==5) {
      $winadd6_num5=$v['winadd6_num'];
    }
    
  }
}
$str_nextprv="";
if ($winnum_stage == "6") {
  $prv_winnum_year = $winnum_year;
  $prv_winnum_stage = $winnum_stage-1;
  $next_winnum_year = $winnum_year + 1;
  $next_winnum_stage = "1";
} else if ($winnum_stage == '1'){
  $prv_winnum_year = $winnum_year-1;
  $prv_winnum_stage = "6";
  $next_winnum_year = $winnum_year;
  $next_winnum_stage = $winnum_stage+1;
} else {
  $prv_winnum_year = $winnum_year;
  $prv_winnum_stage = $winnum_stage-1;
  $next_winnum_year = $winnum_year;
  $next_winnum_stage = $winnum_stage+1;
}

// 上下期
$data_prv=fun_findDB_winnum_o($prv_winnum_year,$prv_winnum_stage);
if (!empty($data_prv)) {
  $str_nextprv.='[<a href="?ystage='. $prv_winnum_year . $prv_winnum_stage .'">上一期</a>] ';
}else{
  $str_nextprv.='[上一期] ';
}
$data_next=fun_findDB_winnum_o($next_winnum_year,$next_winnum_stage);
if (!empty($data_next)) {
  $str_nextprv.='[<a href="?ystage='. $next_winnum_year . $next_winnum_stage .'">下一期</a>] ';
}else{
  $str_nextprv.='[下一期] ';
}

// 中獎清單
$win_allstr="";
$win_allmoney=0;
$win_special1_str="";
$win_special2_str="";
$win_head_str="";
$win_two_str="";
$win_three_str="";
$win_four_str="";
$win_five_str="";
$win_sex_str="";

$sql_win="select * from user_invoice where user_data_pk = '". $_SESSION['userpk'] ."' ". fun_stage_datebetween($winnum_year,$winnum_stage);
$rows_win=$pdo->query($sql_win)->fetchAll();
foreach ($rows_win as $k => $v) {
  $invoice=$v["last_num"];
  
  if ($special1_num == $v["last_num"]) {
    // 判斷是否中特別獎
    $win_allmoney=$win_allmoney+10000000;
    $win_special1_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if ($special2_num == $v["last_num"]) {  
    // 判斷是否中特獎
    $win_allmoney=$win_allmoney+10000000;
    $win_special2_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if ($head1_num == $v["last_num"] || $head2_num == $v["last_num"] || $head3_num == $v["last_num"]) {  
    // 判斷是否中頭獎
    $win_allmoney=$win_allmoney+100000;
    $win_head_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if (substr($head1_num, 1) == substr($v["last_num"],1) || substr($head2_num, 1) == substr($v["last_num"],1) || substr($head3_num, 1) == substr($v["last_num"],1)) {  
    // 判斷是否中二獎
    $win_allmoney=$win_allmoney+40000;
    $win_two_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if (substr($head1_num, 2) == substr($v["last_num"],2) || substr($head2_num, 2) == substr($v["last_num"],2) || substr($head3_num, 2) == substr($v["last_num"],2)) {  
    // 判斷是否中三獎
    $win_allmoney=$win_allmoney+10000;
    $win_three_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if (substr($head1_num, 3) == substr($v["last_num"],3) || substr($head2_num, 3) == substr($v["last_num"],3) || substr($head3_num, 3) == substr($v["last_num"],3)) {  
    // 判斷是否中四獎
    $win_allmoney=$win_allmoney+4000;
    $win_four_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if (substr($head1_num, 4) == substr($v["last_num"],4) || substr($head2_num, 4) == substr($v["last_num"],4) || substr($head3_num, 4) == substr($v["last_num"],4)) {  
    // 判斷是否中五獎
    $win_allmoney=$win_allmoney+1000;
    $win_five_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else if (substr($head1_num, 5) == substr($v["last_num"],5) || substr($head2_num, 5) == substr($v["last_num"],5) || substr($head3_num, 5) == substr($v["last_num"],5)) {  
    // 判斷是否中六獎
    $win_allmoney=$win_allmoney+200;
    $win_sex_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
  } else {  
    // 判斷是否中增開六獎
    $win_data6=fun_findDB_winnum_6($winnum_opk);
    foreach ($win_data6 as $v6) {
      if ($v6["winadd6_num"]==substr($v["last_num"],5)) {
        $win_allmoney=$win_allmoney+200;
        $win_sex_str.="<tr><th >". $v["first_id"] ."-". $v["last_num"] ."</th><td >". $v["invoice_price"] ." 元</td><td >". $v["invoice_date"] ."</td></tr>\n";
      } 
    }
  }  
}
if ($win_special1_str != "") {
  $win_allstr.='<h3>特別獎 (獎金1,000萬元)</h3><table class="table-list">'. $win_special1_str .'</table>';
}
if ($win_special2_str != "") {
  $win_allstr.='<h3>特獎 (獎金1,000萬元)</h3><table class="table-list">'. $win_special2_str .'</table>';
}
if ($win_head_str != "") {
  $win_allstr.='<h3>頭獎 (獎金10萬元)</h3><table class="table-list">'. $win_head_str .'</table>';
}
if ($win_two_str != "") {
  $win_allstr.='<h3>二獎 (獎金4萬元)</h3><table class="table-list">'. $win_two_str .'</table>';
}
if ($win_three_str != "") {
  $win_allstr.='<h3>三獎 (獎金1萬元)</h3><table class="table-list">'. $win_three_str .'</table>';
}
if ($win_four_str != "") {
  $win_allstr.='<h3>四獎 (獎金4千元)</h3><table class="table-list">'. $win_four_str .'</table>';
}
if ($win_five_str != "") {
  $win_allstr.='<h3>五獎 (獎金1千元)</h3><table class="table-list">'. $win_five_str .'</table>';
}
if ($win_sex_str != "") {
  $win_allstr.='<h3>六獎 (獎金2百元)</h3><table class="table-list">'. $win_sex_str .'</table>';
}
if ($win_allstr != "") {
  $win_allstr.='<div class="allmoney">總獎金：'. $win_allmoney .'元</div>';
} else {
  $win_allstr.='<div class="allmoney">本期槓龜</div>';
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
  <?php include_once 'include/_header.php';?>
  <div class="main">
    <div class="menu">
      <ul>
        <li class="a">當期統一發票中獎號碼與中獎清單</li>
        <li class="b"><a href="myinvoice.php">我的發票</a></li>
        <li class="b"><a href="winnum.php">中獎號碼登錄</a></li>
        <li class="b"><a href="invoice_autoproduce.php">發票資料產生器</a></li>
      </ul>
    </div>
    <div class="clear"></div>
    <div class="cont">
      <h1>當期統一發票中獎號碼與中獎清單</h1>
      <h2>統一發票中獎號碼</h2>
      <table class="table-bordered"> 
         <tr> 
          <th >月份</th> 
          <td class="title">西元<?php echo $winnum_year;?>年 <?php echo fun_stageName($winnum_stage);?> <span class="title_r"><?php echo $str_nextprv; ?></span></td> 
         </tr> 
         <tr> 
          <th rowspan="2">特別獎</th> 
          <td class="number"><?php echo $special1_num; ?></td> 
         </tr> 
         <tr> 
          <td> 同期統一發票收執聯8位數號碼與特別獎號碼相同者獎金1,000萬元 </td> 
         </tr> 
         <tr> 
          <th rowspan="2">特獎</th> 
          <td class="number"><?php echo $special2_num; ?></td> 
         </tr> 
         <tr> 
          <td > 同期統一發票收執聯8位數號碼與特獎號碼相同者獎金200萬元 </td> 
         </tr> 
         <tr> 
          <th rowspan="2">頭獎</th> 
          <td class="number"> <p><?php echo $head1_num; ?></p> <p><?php echo $head2_num; ?></p> <p><?php echo $head3_num; ?></p> <p></p> </td> 
         </tr> 
         <tr> 
          <td > 同期統一發票收執聯8位數號碼與頭獎號碼相同者獎金20萬元 </td> 
         </tr> 
         <tr> 
          <th >二獎</th> 
          <td > 同期統一發票收執聯末7 位數號碼與頭獎中獎號碼末7 位相同者各得獎金4萬元 </td> 
         </tr> 
         <tr> 
          <th >三獎</th> 
          <td > 同期統一發票收執聯末6 位數號碼與頭獎中獎號碼末6 位相同者各得獎金1萬元 </td> 
         </tr> 
         <tr> 
          <th >四獎</th> 
          <td > 同期統一發票收執聯末5 位數號碼與頭獎中獎號碼末5 位相同者各得獎金4千元 </td> 
         </tr> 
         <tr> 
          <th >五獎</th> 
          <td > 同期統一發票收執聯末4 位數號碼與頭獎中獎號碼末4 位相同者各得獎金1千元 </td> 
         </tr> 
         <tr> 
          <th >六獎</th> 
          <td > 同期統一發票收執聯末3 位數號碼與 頭獎中獎號碼末3 位相同者各得獎金2百元 </td> 
         </tr> 
         <tr> 
          <th >增開六獎</th> 
          <td class="number"><?php echo $num6_str;?></td> 
         </tr> 
       </table> 
       <h2>中獎清單</h2>
       <?php echo $win_allstr; ?>
    </div>
  </div>
  <script src="./js/timeout.js"></script>
</body>
</html>
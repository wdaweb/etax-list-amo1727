<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
$ystage='';
$winnum_chkStage=false;
$winnum_opk='';
$winnum_year='';
$winnum_stage='';
$special1_num='';
$special2_num='';
$head1_num='';
$head2_num='';
$head3_num='';
$winadd6_num1='';
$winadd6_num2='';
$winadd6_num3='';
$winadd6_num4='';
$winadd6_num5='';
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["ystage"])) {
  $ystage = fun_testinput($_GET["ystage"]);
    if (fun_chkStage($ystage)) {
      $winnum_chkStage=true;
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
        foreach ($data6 as $v) {
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
    } else {
      fun_alertmsg ('期別有誤，請重新選取！ \n','winnum.php');
      exit();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="#" type="image/x-icon">
  <title>統一發票紀錄與對獎系統-中獎號碼登錄</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <?php include_once 'include/_header.php';?>
  <div class="main">
    <div class="menu">
      <ul>
        <li class="b"><a href="main.php">當期統一發票中獎號碼與中獎清單</a></li>
        <li class="b"><a href="myinvoice.php">我的發票</a></li>
        <li class="a">中獎號碼登錄</li>
        <li class="b"><a href="invoice_autoproduce.php">發票資料產生器</a></li>
      </ul>
    </div>
    <div class="clear"></div>
    <div class="cont">
      <h1>中獎號碼登錄</h1>
      <table class="table-bordered">
        <tr>
          <th>期別</th>
          <td class="title">
            <select name="select" onChange="location.href=this.options[this.selectedIndex].value;">			
            <option value="" >請選擇</option>
            <?php 
            for ($i=date("Y"); $i >= date("Y",strtotime("-1 year")); $i--) { 
              for ($j=6; $j >= 1 ; $j--) { 
                $selectstr='';
                if ($winnum_year==$i && $winnum_stage==$j) {
                  $selectstr=' selected ';
                }
                echo '<option value="winnum.php?ystage='.$i.$j.'" '. $selectstr .'>西元'.$i.'年'.fun_stageName($j).'</option>\n';
              } 
            }
            ?>
            </select>   
            </td>
        </tr>
      </table>
      <?php
      if ($winnum_chkStage) {
      ?>
      <div class="allmoney">↓↓↓↓↓</div>
      <form action="winnum_api.php" method="post" onsubmit="return chk_winForm(this);">
      <table class="table-bordered">
        <tr>
          <th rowspan="2">特別獎</th>
          <td class="number"><input type="text" class="num15" id="special1_num" name="special1_num" maxlength="8" value="<?php echo $special1_num?>"></td>
        </tr>
        <tr>
          <td> 同期統一發票收執聯8位數號碼與特別獎號碼相同者獎金1,000萬元 </td>
        </tr>
        <tr>
          <th rowspan="2">特獎</th>
          <td class="number"><input type="text" class="num15" id="special2_num" name="special2_num" maxlength="8" value="<?php echo $special2_num?>"></td>
        </tr>
        <tr>
          <td> 同期統一發票收執聯8位數號碼與特獎號碼相同者獎金200萬元 </td>
        </tr>
        <tr>
          <th rowspan="2">頭獎</th>
          <td class="number">
            <input type="text" class="num15" id="head1_num" name="head1_num" maxlength="8" value="<?php echo $head1_num?>"><br>
            <input type="text" class="num15" id="head2_num" name="head2_num" maxlength="8" value="<?php echo $head2_num?>"><br>
            <input type="text" class="num15" id="head3_num" name="head3_num" maxlength="8" value="<?php echo $head3_num?>"></td>
        </tr>
        <tr>
          <td> 同期統一發票收執聯8位數號碼與頭獎號碼相同者獎金20萬元 </td>
        </tr>
        <tr>
          <th>二獎</th>
          <td> 同期統一發票收執聯末7 位數號碼與頭獎中獎號碼末7 位相同者各得獎金4萬元 </td>
        </tr>
        <tr>
          <th>三獎</th>
          <td> 同期統一發票收執聯末6 位數號碼與頭獎中獎號碼末6 位相同者各得獎金1萬元 </td>
        </tr>
        <tr>
          <th>四獎</th>
          <td> 同期統一發票收執聯末5 位數號碼與頭獎中獎號碼末5 位相同者各得獎金4千元 </td>
        </tr>
        <tr>
          <th>五獎</th>
          <td> 同期統一發票收執聯末4 位數號碼與頭獎中獎號碼末4 位相同者各得獎金1千元 </td>
        </tr>
        <tr>
          <th>六獎</th>
          <td> 同期統一發票收執聯末3 位數號碼與 頭獎中獎號碼末3 位相同者各得獎金2百元 </td>
        </tr>
        <tr>
          <th>增開六獎</th>
          <td class="number">
            <input type="text" class="num6" id="winadd6_num1" name="winadd6_num1" maxlength="3" value="<?php echo $winadd6_num1?>">
            <input type="text" class="num6" id="winadd6_num2" name="winadd6_num2" maxlength="3" value="<?php echo $winadd6_num2?>">
            <input type="text" class="num6" id="winadd6_num3" name="winadd6_num3" maxlength="3" value="<?php echo $winadd6_num3?>">
            <input type="text" class="num6" id="winadd6_num4" name="winadd6_num4" maxlength="3" value="<?php echo $winadd6_num4?>">
            <input type="text" class="num6" id="winadd6_num5" name="winadd6_num5" maxlength="3" value="<?php echo $winadd6_num5?>">
          </td>
        </tr>
      </table>
      <div class="win subarea"><input type="submit" value=" 儲 存 " ></div>
      <input type="hidden" name="ystage" value="<?php echo $ystage ?>">
      </form>
      <?php 
      }
      ?>
    </div>
  </div>
  <script src="./js/chk_form.js"></script>
  <script src="./js/timeout.js"></script>
</body>
</html>
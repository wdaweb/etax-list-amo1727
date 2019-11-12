<?php
include_once 'include/_common.php';
if (empty($_SESSION['userpk'])) {
  fun_alertmsg ('尚未登入或閒置時間過長，請重新登入!!','index.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ystage = fun_testinput($_POST["ystage"]);
  $special1_num=fun_testinput($_POST['special1_num']);
  $special2_num=fun_testinput($_POST['special2_num']);
  $head1_num=fun_testinput($_POST['head1_num']);
  $head2_num=fun_testinput($_POST['head2_num']);
  $head3_num=fun_testinput($_POST['head3_num']); 

  $winadd6_num1=fun_testinput($_POST['winadd6_num1']);
  $winadd6_num2=fun_testinput($_POST['winadd6_num2']);
  $winadd6_num3=fun_testinput($_POST['winadd6_num3']);
  $winadd6_num4=fun_testinput($_POST['winadd6_num4']);
  $winadd6_num5=fun_testinput($_POST['winadd6_num5']);
  if (fun_chkStage($ystage)) {
    $winnum_year=substr($ystage, 0, 4);
    $winnum_stage=substr($ystage, 4, 1);
    $data=fun_findDB_winnum_o($winnum_year,$winnum_stage);
    if (!empty($data)) {
      // 已有資料
      $editdata=[];
      $editdata['winnum_year']=$winnum_year; 
      $editdata['winnum_stage']=$winnum_stage;  
      $editdata['special1_num']=$special1_num;  
      $editdata['special2_num']=$special2_num;  
      $editdata['head1_num']=$head1_num;  
      $editdata['head2_num']=$head2_num;  
      $editdata['head3_num']=$head3_num;  
      $editdata['modify_userpk']=$_SESSION['userpk']; 
      $editdata['modify_time']=date("Y-m-d h:i:s"); 
      $result=fun_updateDB('winnum_original',$data['pk'],$editdata);
      if ($result) {
        fun_delDB_add6($data['pk']);        
        for ($i=1; $i <= 5 ; $i++) {  
          if (${'winadd6_num'.$i} != '') {
            $insdata=[];
            $insdata['original_pk']=$data['pk'];
            $insdata['winadd6_num']=${'winadd6_num'.$i};
            $insdata['modify_userpk']=$_SESSION['userpk']; 
            $insdata['modify_time']=date("Y-m-d h:i:s"); 
            $result6=fun_insertDB('winnum_add6',$insdata);
          } 
        }
        fun_alertmsg ('修改登錄資料(西元'.$winnum_year.'年'.fun_stageName($winnum_stage).')成功！ \n','winnum.php');
        exit();
      }
    }else{
      // 新資料
      $insdata=[];
      $insdata['winnum_year']=$winnum_year; 
      $insdata['winnum_stage']=$winnum_stage;  
      $insdata['special1_num']=$special1_num;  
      $insdata['special2_num']=$special2_num;  
      $insdata['head1_num']=$head1_num;  
      $insdata['head2_num']=$head2_num;  
      $insdata['head3_num']=$head3_num;  
      $insdata['modify_userpk']=$_SESSION['userpk']; 
      $insdata['modify_time']=date("Y-m-d h:i:s"); 
      $result=fun_insertDB('winnum_original',$insdata);
      if ($result) {
        $datai=fun_findDB_winnum_o($winnum_year,$winnum_stage);
        if (!empty($datai)) {
          $datai_opk=$datai['pk'];
          for ($i=1; $i <= 5 ; $i++) {  
            if (${'winadd6_num'.$i} != '') {
              $insdata=[];
              $insdata['original_pk']=$datai_opk;
              $insdata['winadd6_num']=${'winadd6_num'.$i};
              $insdata['modify_userpk']=$_SESSION['userpk']; 
              $insdata['modify_time']=date("Y-m-d h:i:s"); 
              $result6=fun_insertDB('winnum_add6',$insdata);
            } 
          }
        }
        fun_alertmsg ('登錄新資料(西元'.$winnum_year.'年'.fun_stageName($winnum_stage).')成功！ \n','winnum.php');
        exit();
      }
    }
  }
}
?>
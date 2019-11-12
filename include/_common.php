<?php 
    session_start();
    $db_server='localhost';
    $db_user='invoice';
    $db_pwd='4rfv5tgb';
    $db_name='dbinvoice';
    $pdo=new PDO("mysql:host=$db_server;charset=utf8;dbname=$db_name",$db_user,$db_pwd);

    function fun_testinput($datatestinput) {
        if (!empty($datatestinput)) {
            $datatestinput = trim($datatestinput);
            $datatestinput = stripslashes($datatestinput);  
            $datatestinput = htmlspecialchars($datatestinput);
        } else {
            $datatestinput='';
        }
        return $datatestinput;
    }
    function fun_alertmsg($msg,$link){
        $alertmsg = "<script>\n";
        $alertmsg .= "alert('". $msg ."');\n";
        $alertmsg .= "location.href='".$link."';\n";
        $alertmsg .= "</script>\n";
        echo $alertmsg;
    }
    
    // update()-給定資料表的條件後，會去更新相應的資料。
    function fun_updateDB($table,$pk,$data){
        global $pdo;
        $updatesdtr="";
        foreach ($data as $key => $value) {
            $updatesdtr.=",`". $key ."`='". $value ."'";
        }       
        $updatesdtr=substr($updatesdtr, 1);
        $sql="UPDATE `". $table ."` SET ". $updatesdtr ." WHERE pk ='". $pk ."'";
        $result = $pdo->exec($sql);
        return $result;
    }    
    // insert()-給定資料內容後，會去新增資料到資料表
    function fun_insertDB($table,$data){
        global $pdo;
        
        $keys="`". implode("`,`",array_keys($data)) ."`";
        $values="'". implode("','",$data) ."'";
        $sql="INSERT INTO ". $table ."(". $keys .") VALUES (". $values .")";
        $result = $pdo->exec($sql);
        return $result;
    }
    // del()-給定條件後，會去刪除指定的資料
    function fun_delDB($table,$pk){
        global $pdo;
        $sql="DELETE FROM  `". $table ."` WHERE pk ='". $pk ."'";
        $result = $pdo->exec($sql);
        return $result;
    }
    function fun_delDB_add6($opk){
        global $pdo;
        $sql="DELETE FROM  `winnum_add6` WHERE original_pk ='". $opk ."'";
        $result = $pdo->exec($sql);
        return $result;
    }

    // 回傳會員登入資料
    function fun_loginDB($acc,$pw){
        global $pdo;
        $sql="SELECT * FROM `user_data` where acc = '". $acc ."' and pw = '" . $pw ."' and enable = '1' ";
        $rows = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    
    // all()-給定資料表名後，會回傳整個資料表的資料
    function fun_all($table){
        global $pdo;
        $sql="select * from ".$table;
        $rows=$pdo->query($sql)->fetchAll();
        return $rows;
    }

    function fun_findDB_winnum_o($y,$s){
        global $pdo;
        $sql="SELECT * FROM `winnum_original` where winnum_year = '". $y ."' and winnum_stage = '". $s ."'";
        $rows = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }
    function fun_findDB_winnum_6($opk){
        global $pdo;
        $sql="SELECT * FROM `winnum_add6` where original_pk = '". $opk ."'";
        $rows = $pdo->query($sql)->fetchAll();
        return $rows;
    }

    function fun_randfirstid(){
        return chr(rand(65,90)) . chr(rand(65,90));
      }
      function fun_randlastnum(){
        $value = rand(00000001,99999999);
        return str_pad($value,8,'0',STR_PAD_LEFT);
      }
      function fun_randprice(){
        return rand(10,2000);
      }
      function fun_randdate($year){
        $firstday=strtotime("$year-1-1");
        $lastday=strtotime("$year-12-31");
        return date("Y-m-d",rand($firstday,$lastday));
      }

      function fun_stageName($j){
        switch ($j) {
            case '1':
                return "1-2月";
                break;
            case '2':
                return "3-4月";
                break;
            case '3':
                return "5-6月";
                break;
            case '4':
                return "7-8月";
                break;
            case '5':
                return "9-10月";
                break;
            case '6':
                return "11-12月";
                break;
        }
    }
    function fun_stage_datebetween($year,$j){
        switch ($j) {
            case '1':
                return " and (invoice_date >= '". $year ."-1-1' and invoice_date < '". $year ."-3-1') ";
                break;
            case '2':
                return " and (invoice_date >= '". $year ."-3-1' and invoice_date < '". $year ."-5-1') ";
                break;
            case '3':
                return " and (invoice_date >= '". $year ."-5-1' and invoice_date < '". $year ."-7-1') ";
                break;
            case '4':
                return " and (invoice_date >= '". $year ."-7-1' and invoice_date < '". $year ."-9-1') ";
                break;
            case '5':
                return " and (invoice_date >= '". $year ."-9-1' and invoice_date < '". $year ."-11-1') ";
                break;
            case '6':
                return " and (invoice_date >= '". $year ."-11-1' and invoice_date < '". ($year+1) ."-1-1') ";
                break;
        }
    }
    function fun_chkStage($str){
        if (strlen($str)==5) {
            $year=substr($str, 0, 4);
            $stage=substr($str, 4, 1);
            $yearChk=false;
            $stageChk=false;
            for ($i=2018; $i <= date("Y"); $i++) { 
                if ($year == $i){
                    $yearChk=1;
                }
            }
            for ($j=1; $j <= 6 ; $j++) { 
                if ($stage == $j){
                    $stageChk=true;
                }
            }
            if ($yearChk && $stageChk) {
                return true;
            } else {
                return false;
            }            
        } else {
            return false;
        }
    }
?>
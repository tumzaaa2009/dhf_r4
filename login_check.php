<?php
    session_start();
    include("include/connect.php");

    $user = $_REQUEST["user"];
	 $pass = $_REQUEST["pass"];
	if($user=='' || $pass==''){
        //ไม่เติมคำในช่องว่าง
		echo "empty";
		die();
	}
   $sql = "SELECT * FROM dhf_user WHERE dhf_user='$user' AND dhf_pass='$pass'";
    //echo $sql;
    $db_r4->exec("set names utf8");
    $rs = $db_r4->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
    
    

    if(!$rs) {
        //connect ไม่ผ่าน
        echo "error";
    } else {
        
        if($rs->rowCount() == 1) {
           


            if($results[0]["status"] == "N"){
                //บล๊อกสถานะ
                echo "suspen";
		        die();
            }
     
          $_SESSION['valid_dhf_first'] = $results[0]["dhf_first_name"];
            $_SESSION['valid_dhf_last'] = $results[0]["dhf_last_name"];
            $_SESSION['valid_dhf_id'] = $results[0]["dhf_id"];
           $_SESSION['valid_dhf_user'] = $results[0]["dhf_user"];
            $_SESSION['valid_user_type'] = $results[0]["user_type"];

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $sql_update_log = "INSERT INTO dhf_login (dhf_user,login_date, ip)
            VALUES ('".$_SESSION['valid_dhf_user']."','".date("Y-m-d H:i:s")."','".$ip."')";

            $sql_insert_log = "UPDATE dhf_user
            SET last_login = '".date("Y-m-d H:i:s")."'
            WHERE dhf_user = '".$_SESSION['valid_dhf_user']."' AND dhf_id = '".$_SESSION['valid_dhf_id']."'";

            $rs_update_log = $db_r4->prepare($sql_update_log);
            $rs_update_log->execute();
            if($rs_update_log === true){
                //connect update ไม่ผ่าน
                "error_update";
                session_unset();
                die();
            }

            $rs_insert_log = $db_r4->prepare($sql_insert_log);
            $rs_insert_log->execute();
            if($rs_insert_log === true){
                //connect insert ไม่ผ่าน
                "error_insert";
                session_unset();
                die();
            }
            //สำเร็จ
            echo "yes";
        } else {
            //ค้นหาไม่สำเร็จ
            echo "fail";
        }
	}
?>
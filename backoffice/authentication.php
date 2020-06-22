<?php
    session_start();
    include("../config/connect.php");
    include("../config/func.php");
    include("../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $user = $_REQUEST["user"];
	$pass = $_REQUEST["pass"];

    $sql = "SELECT * FROM dhf_user WHERE dhf_user = '$user' AND dhf_status = '1'";
    $db_r4->exec("set names utf8");
    $rs = $db_r4->prepare($sql);
    $rs->execute();
    //echo $rs->rowCount();
    if(!$rs) {
        //connect ไม่ผ่าน
        $result = "error";
    } else {
        if($rs->rowCount() == 1) {
            $results=$rs->fetchAll(PDO::FETCH_ASSOC);

            $secure_text = $results[0]['secure_text'];
            $secure_pointer = $results[0]['secure_pointer'];
            $secure_loop = $results[0]['secure_loop'];

            					
			$pass = md5($pass);
			$pass = stringInsert($pass,$secure_text,$secure_pointer);
			for($i=1;$i<=$secure_loop;$i++){
				$pass = md5($pass);
			}
            if($pass == $results[0]['dhf_pass']){   // Login สำเร็จ //

                $token = array();
				$token['dhf_id'] = $results[0]["dhf_id"];
                $token['dhf_user'] = $results[0]["dhf_user"];
                $token['dhf_fullname'] = $results[0]["dhf_fullname"];
                $token['dhf_area'] = $results[0]["dhf_area"];
                $token['dhf_level'] = $results[0]["dhf_level"];
                $token['dhf_admin'] = $results[0]["dhf_admin"];
                $token['dhf_status'] = $results[0]["dhf_status"];
                $token['group_id_506'] = "";
                $token['group_name'] = "";
                $token['group_id'] = "";

                $authorization = JWT::encode($token, 'Hdk21sTs47kjTad47DsMzz74Lof');
                $_SESSION['JWT_Dengue_Fever'] = $authorization;
    
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
    
                $sql_update_log = "INSERT INTO dhf_login (dhf_user,login_date, ip)
                VALUES ('".$results[0]["dhf_user"]."','".date("Y-m-d H:i:s")."','".$ip."')";
    
                $sql_insert_log = "UPDATE dhf_user 
                SET last_login = '".date("Y-m-d H:i:s")."'
                WHERE dhf_user = '".$results[0]["dhf_user"]."' AND dhf_id = '".$results[0]["dhf_id"]."'";
    
                $rs_update_log = $db_r4->prepare($sql_update_log);
                $rs_update_log->execute();
                if($rs_update_log === true){
                    //connect update ไม่ผ่าน
                    session_unset();
                    $result = "error_update";
                    $arr['result'] = $result;
                    echo json_encode($arr);
                    die();
                }
    
                $rs_insert_log = $db_r4->prepare($sql_insert_log);
                $rs_insert_log->execute();
                if($rs_insert_log === true){
                    //connect insert ไม่ผ่าน
                    session_unset();
                    $result = "error_insert";
                    $arr['result'] = $result;
                    echo json_encode($arr);
                    die();
                }
                //สำเร็จ
                $result = "yes";
            } else {
                $result = "fail2";
            }
        } else {
            //ค้นหาไม่สำเร็จ
            $result = "fail1";
        }
    }
    $arr['level'] = $results[0]["dhf_level"];
    $arr['result'] = $result;
    echo json_encode($arr);
?>
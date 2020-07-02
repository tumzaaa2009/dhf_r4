<?php
    session_start();
    include("../config/connect.php");
    include("../config/func.php");
    include("../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");
    $freelogin=$_REQUEST["freelogin"];
   


    //echo $rs->rowCount();
  


   // Login สำเร็จ //
if (isset($freelogin)) {
    # code...

                $token = array();
		
                $token['dhf_user'] =$freelogin;

                $token['group_id_506'] = "";
                $token['group_name'] = "";
                $token['group_id'] = "";

                $authorization = JWT::encode($token, 'Hdk21sTs47kjTad47DsMzz74Lof');
                $_SESSION['JWT_Dengue_Fever'] = $authorization;
    
  
                //สำเร็จ
                $result = "yes";
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
            }

    $arr['level'] = "1";
    $arr['result'] = $result;
    echo json_encode($arr);
?>
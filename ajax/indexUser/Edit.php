<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $dhf_id = $_POST["dhf_id"];
    $dhf_user = $_POST["dhf_user"];
    $dhf_pass = $_POST["dhf_pass"];
    $dhf_fullname = $_POST['dhf_fullname'];
    $dhf_phone = $_POST['dhf_phone'];
    $dhf_email = $_POST['dhf_email'];
    $dhf_level = $_POST['dhf_level'];
    $dhf_status = $_POST['dhf_status'];

    if($dhf_level == "1"){
        $dhf_admin = $_POST['dhf_admin'];
        $dhf_area = "19";
    }elseif($dhf_level == "2"){
        $dhf_area = $_POST['dhf_area'];
    }elseif($dhf_level == "3"){
        $dhf_area = $_POST['dhf_area'];
    }

    if($dhf_admin != "1"){
        $dhf_admin = "0";
    }

    if($dhf_pass != ""){
        $secure_text = generateRandomString(5);
        $secure_pointer = rand(2,15);
        $secure_loop = rand(1,5);
                
        $pass = md5($dhf_pass);
        $pass = stringInsert($pass,$secure_text,$secure_pointer);
        for($i=1;$i<=$secure_loop;$i++){
            $pass = md5($pass);
        }

        $temp_pass = " dhf_pass = '$pass', 
        secure_text = '$secure_text', 
        secure_pointer = '$secure_pointer', 
        secure_loop = '$secure_loop', 
        ";
    }else{
        $temp_pass = "";
    }




    $datetime = date('Y-m-d H:i:s');
    $sql_edit = "UPDATE dhf_user SET 
        $temp_pass 
        dhf_fullname = '$dhf_fullname',
        dhf_phone = '$dhf_phone',
        dhf_email = '$dhf_email',
        dhf_level = '$dhf_level',
        dhf_admin = '$dhf_admin',
        dhf_status = '$dhf_status',
        dhf_area = '$dhf_area'
        WHERE dhf_id = '$dhf_id'";

    $result_update = $db_saraburi->exec($sql_edit);
    if($result_update == "1"){
        $result = 1;

        $authorization = $_SESSION['JWT_Dengue_Fever'];
        $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

        if($token->dhf_user == $dhf_user){
            $token->dhf_fullname = $dhf_fullname;
            $token->dhf_area = $dhf_area;
            $token->dhf_level = $dhf_level;
            $token->dhf_admin = $dhf_admin;
            $token->dhf_status = $dhf_status;

            $authorization = JWT::encode($token, 'Hdk21sTs47kjTad47DsMzz74Lof');
            $_SESSION['JWT_Dengue_Fever'] = $authorization;
            $arr['reload'] = "reload";
        }
    } elseif($result_update == "0") {
        $result = 2;
    } elseif($result_update == "") {
        $result = 0;
    }    
    $arr['result'] = $result;
    echo json_encode($arr);
?>

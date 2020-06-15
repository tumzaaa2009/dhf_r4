<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


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

    $secure_text = generateRandomString(5);
    $secure_pointer = rand(2,15);
    $secure_loop = rand(1,5);

                        
    $pass = md5($dhf_pass);
    $pass = stringInsert($pass,$secure_text,$secure_pointer);
    for($i=1;$i<=$secure_loop;$i++){
        $pass = md5($pass);
    }

    $sql_max = "SELECT MAX(dhf_id) AS max_id FROM dhf_user";
    $rs_max = $db_saraburi->prepare($sql_max);
    $rs_max->execute();
    $results_max = $rs_max->fetchAll(PDO::FETCH_ASSOC);
    if($results_max[0]["max_id"] == "" || $results_max[0]["max_id"] == "0"){
        $dhf_id = 1;
    }else{
        $dhf_id = $results_max[0]["max_id"] + 1;
    }

    $datetime = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO dhf_user SET 
        dhf_id = '$dhf_id',
        dhf_user = '$dhf_user',
        dhf_pass = '$pass',
        dhf_fullname = '$dhf_fullname',
        dhf_phone = '$dhf_phone',
        dhf_email = '$dhf_email',
        dhf_level = '$dhf_level',
        dhf_admin = '$dhf_admin',
        dhf_status = '$dhf_status',
        dhf_area = '$dhf_area',
        secure_text = '$secure_text',
        secure_pointer = '$secure_pointer',
        secure_loop = '$secure_loop'";
    
    $resultSQL = $db_saraburi->exec($sql_insert);

    if($resultSQL == "1"){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>

<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    $token->group_id = $_POST["group_id"];
    $token->group_name = $_POST["group_name"];
    $token->group_id_506 = $_POST["group_id_506"];

    $authorization = JWT::encode($token, 'Hdk21sTs47kjTad47DsMzz74Lof');
    $_SESSION['JWT_Dengue_Fever'] = $authorization;

    if($token->group_id != ""){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>
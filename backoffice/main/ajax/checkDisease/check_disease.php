<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    if($token->group_id == ""){
        $reCkeck = 1;
    }else{
        $reCkeck = 0;
    }
    $arr['reCkeck'] = $reCkeck;
    echo json_encode($arr);
?>
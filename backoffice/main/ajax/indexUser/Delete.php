<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $dhf_id = $_POST["dhf_id"];

    $sql="DELETE FROM dhf_user WHERE dhf_id = '$dhf_id'";
    if($db_saraburi->exec($sql) == "1"){
        $result = 1;
    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
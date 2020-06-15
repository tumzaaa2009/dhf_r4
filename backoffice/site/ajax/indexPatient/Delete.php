<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $E0 = $_POST["E0"];
    $DATESICK = $_POST['DATESICK'];

    $sql="DELETE FROM dhf_patient WHERE E0 = '$E0' AND DATESICK = '$DATESICK'";
    if($db_saraburi->exec($sql) == "1"){
        $result = 1;
    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
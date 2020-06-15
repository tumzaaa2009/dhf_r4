<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');
    $user = $token->dhf_user;

    $E0 = $_POST["E0"];
    $DATESICK = $_POST["DATESICK"];
    $follow_id = $_POST["follow_id"];

    $sql = "DELETE FROM dhf_patient_follow WHERE E0='".$E0."' AND follow_id='".$follow_id."' AND DATESICK = '".$DATESICK."'";
    if($db_saraburi->exec($sql) == "1"){
        $result = 1;
    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
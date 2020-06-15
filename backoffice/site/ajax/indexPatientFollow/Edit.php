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
    $follow_date = $_POST["follow_date"];
    $follow_detail = $_POST['follow_detail'];

    $datetime = date('Y-m-d H:i:s');
    $sql_edit = "UPDATE dhf_patient_follow SET 
        follow_detail = '$follow_detail',
        follow_date = '$follow_date',
        update_user = '$user',
        update_date = '$datetime' 
        WHERE E0 = '$E0' AND follow_id = '$follow_id' AND DATESICK = '$DATESICK'";
    
    $result_update = strval($db_saraburi->exec($sql_edit));      
    if($result_update == "1"){
      $result = 1;
    } elseif($result_update == "0") {
      $result = 2;
    } elseif($result_update == "") {
      $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>
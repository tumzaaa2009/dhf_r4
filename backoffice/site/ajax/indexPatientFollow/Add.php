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
    $follow_date = $_POST["follow_date"];
    $follow_detail = $_POST['follow_detail'];

    $sql_max = "SELECT MAX(follow_id) AS max_id FROM dhf_patient_follow";
    $rs_max = $db_saraburi->prepare($sql_max);
    $rs_max->execute();
    $results_max = $rs_max->fetchAll(PDO::FETCH_ASSOC);
  
    if($results_max[0]["max_id"] == "" || $results_max[0]["max_id"] == "0"){
      $follow_id = 1;
    }else{
      $follow_id = $results_max[0]["max_id"] + 1;
    }

    $datetime = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO dhf_patient_follow SET 
        follow_id = '$follow_id',
        E0 = '$E0',
        DATESICK = '$DATESICK',
        follow_detail = '$follow_detail',
        follow_date = '$follow_date',
        follow_datetime = '$datetime',
        create_user = '$user'";
    
    $resultSQL = $db_saraburi->exec($sql_insert);

    if($resultSQL == "1"){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>
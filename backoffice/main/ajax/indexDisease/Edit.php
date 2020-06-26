<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $group_id = $_POST["group_id"];
    $group_name = $_POST["group_name"];
    $group_id_506 = $_POST["id_506"];

    $group_id_506 = "";
    $i = 1;
    foreach($_POST['id_506'] as $key => $value) {
		if($i == "1"){
            $group_id_506 = $value;
        }else{
            $group_id_506 = $group_id_506.",".$value;
        }
        $i++;
    }

    $sql_edit = "UPDATE dhf_group_506 SET 
        group_name = '$group_name',
        group_id_506 = '$group_id_506'
        WHERE group_id = '$group_id'";
    
    $result_update = $db_saraburi->exec($sql_edit);
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

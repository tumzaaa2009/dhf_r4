<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


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
    $sql_max = "SELECT MAX(group_id) AS max_id FROM dhf_group_506";
    $rs_max = $db_saraburi->prepare($sql_max);
    $rs_max->execute();
    $results_max = $rs_max->fetchAll(PDO::FETCH_ASSOC);
    if($results_max[0]["max_id"] == "" || $results_max[0]["max_id"] == "0"){
        $group_id = 1;
    }else{
        $group_id = $results_max[0]["max_id"] + 1;
    }

    $datetime = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO dhf_group_506 SET 
        group_id = '$group_id',
        group_name = '$group_name',
        group_id_506 = '$group_id_506'";
    
    $resultSQL = $db_saraburi->exec($sql_insert);

    if($resultSQL == "1"){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>

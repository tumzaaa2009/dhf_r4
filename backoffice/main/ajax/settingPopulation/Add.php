<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $year = $_POST["year"];
    $population = $_POST["population"];

    $datetime = date('Y-m-d H:i:s');
    $sql_insert = "INSERT INTO dhf_population_lvl1 SET 
        year = '$year',
        population = '$population'";
    
    $resultSQL = $db_saraburi->exec($sql_insert);

    if($resultSQL == "1"){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>

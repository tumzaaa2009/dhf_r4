<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $year = $_POST["year"];
    $ampur = $_POST["ampur"];
    $cnt = $_POST["cnt"];
    $population = $_POST["population"];

    $temp_array = array();
    $i = 0;
    foreach ($_POST['tumbol_code'] as $key => $value) {
        $temp_array[$i]['tumbol_code'] = $value;
        $i++;
    }
    $i = 0;
    foreach ($_POST['population'] as $key => $value) {
        $temp_array[$i]['population'] = $value;
        $i++;
    }

    $datetime = date('Y-m-d H:i:s');
    if($cnt > 1){
        $sql_delete = "DELETE FROM dhf_population_lvl3 WHERE year = '$year' AND amp_code = '$ampur'";
        $db_saraburi->exec($sql_delete);
    }

    $sql_insert = "INSERT IGNORE INTO dhf_population_lvl3 (year,tum_code,amp_code,population) VALUES ";
    $i_insert = 1;
    for ($a=0; $a < $i; $a++) { 
        $tumbol_code = $temp_array[$a]['tumbol_code'];
        $population = $temp_array[$a]['population'];

        if($i_insert == 1){
            $sql_insert = $sql_insert . "('".$year."','".$tumbol_code."','".$ampur."', '".$population."')";
        }else{
            $sql_insert = $sql_insert . ",('".$year."','".$tumbol_code."','".$ampur."', '".$population."')";
        }
        $i_insert++;
    }

    $resultSQL = $db_saraburi->exec($sql_insert);
    if($resultSQL > 1){
        $result = 1;
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>

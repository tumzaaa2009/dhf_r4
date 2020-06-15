<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];

    $sql_lvl1 = "DELETE FROM dhf_population_lvl1 WHERE year = '$year'";
    if($db_saraburi->exec($sql_lvl1) == "1"){
        $sql_lvl2 = "DELETE FROM dhf_population_lvl2 WHERE year = '$year'";
        $db_saraburi->exec($sql_lvl2);

        $sql_lvl3 = "DELETE FROM dhf_population_lvl3 WHERE year = '$year'";
        $db_saraburi->exec($sql_lvl3);

        $result = 1;
    } else {
        $result = 0;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
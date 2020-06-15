<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $year = $_POST["year"];
    $year_th = $_POST["year_th"];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $datetime = date('Y-m-d H:i:s');
    $sql_insert_lvl1 = "INSERT INTO dhf_calendar_lvl1 SET 
        year = '$year',
        year_th = '$year_th',
        start_date = '$start_date',
        end_date = '$end_date'";
    
    $resultSQL_lvl1 = $db_saraburi->exec($sql_insert_lvl1);

    if($resultSQL_lvl1 == "1"){
        $i_insert = 1;
        $begin = new DateTime($start_date);
        $end = new DateTime(date('Y-m-d', strtotime("+1 day",strtotime($end_date))));
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        $sql_insert_lvl3 = "INSERT IGNORE INTO dhf_calendar_lvl3 (date,week,year) VALUES ";
        foreach($daterange as $date){
            $dateFormat = $date->format("Y-m-d");
            if($i_insert == 1){
                $sql_insert_lvl3 = $sql_insert_lvl3 . "('".$dateFormat."','','".$year."')";
            }else{
                $sql_insert_lvl3 = $sql_insert_lvl3 . ",('".$dateFormat."','','".$year."')";
            }
            $i_insert++;
        }
        $resultSQL_lvl3 = $db_saraburi->exec($sql_insert_lvl3);

        if($resultSQL_lvl3 > 1){
            $sql_edit = "UPDATE dhf_calendar_lvl3 SET week = WEEK(date,2) WHERE year = '$year'";
            $result_update = $db_saraburi->exec($sql_edit);

            if($result_update > 1){

                $sql_insert_lvl2 = "INSERT INTO dhf_calendar_lvl2 (year, week, start_date, end_date)
                    SELECT dcl3.year AS year, dcl3.week AS week, MIN(dcl3.date) AS start_date, MAX(dcl3.date) AS end_date
                    FROM dhf_calendar_lvl3  dcl3
                    WHERE dcl3.year = '$year'
                    GROUP BY dcl3.week ASC";

                $resultSQL_lvl2 = $db_saraburi->exec($sql_insert_lvl2);

                if($resultSQL_lvl2 >= 1){
                    $result = 1;
                }else{
                    $result = 0;
                }
            }else{
                $result = 0;
            }
        }else{
            $result = 0;
        }
    }else{
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);
?>

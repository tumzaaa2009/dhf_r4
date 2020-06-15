<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
/*----------------------------------------------------------Chart--------------------------------------------------------*/
    if($_REQUEST["btnChartMain"] == "Main"){
        $sql = "SELECT dp.DATESICK, COUNT(dp.E0) AS CountDate
        FROM dhf_patient dp
        WHERE dp.DISEASE IN ($id_506) AND dp.DATESICK BETWEEN '$date_start' AND '$date_end'
        GROUP BY dp.DATESICK ASC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            $resultPatient[$row['DATESICK']] = $row['CountDate'];
        }

        //date_range
        $begin = new DateTime($date_start);
        $end = new DateTime($date_end);
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        $arrJson =  array();
        $arrJson["categories"] = array(array("category" => array()));
        $arrJson["dataset"] = array();
        array_push($arrJson["dataset"], array("seriesName" => "รายวัน", "data" => array()));
        array_push($arrJson["dataset"], array("seriesName" => "สะสม",  "parentYAxis" => "S", "renderAs" => "spline","showValues" => "0", "data" => array()));
        
        $Sum_Cumulative = 0;
        foreach($daterange as $date){
            $dateFormat = $date->format("Y-m-d");
            array_push($arrJson["categories"][0]["category"], array("label" => thai_date_short(strtotime($dateFormat))));
            if(isset($resultPatient[$dateFormat])){
                array_push($arrJson["dataset"][0]["data"], array("value" => $resultPatient[$dateFormat]));
                $Sum_Cumulative = $Sum_Cumulative + $resultPatient[$dateFormat];
            }else{
                array_push($arrJson["dataset"][0]["data"], array("value" => 0));
                $Sum_Cumulative = $Sum_Cumulative + 0;
            }

            array_push($arrJson["dataset"][1]["data"], array("value" => $Sum_Cumulative));
        }

        echo json_encode($arrJson);
    }
/*----------------------------------------------------------Chart--------------------------------------------------------*/
    if($_REQUEST["btnChartMain"] == "01"){
        $sql = "SELECT da.AMP_CODE,da.AMP_NAME,dpl2.population AS Population
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
        FROM dhf_ampur da 
        INNER JOIN dhf_population_lvl2 dpl2 ON dpl2.amp_code = da.AMP_CODE
        ORDER BY CountPatient DESC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            array_push($resultPatient, array("label" => $row['AMP_NAME'], "value" => ($row['CountPatient']*100000)/$row['Population'])); 
        }

        echo json_encode($resultPatient);
    }
    if($_REQUEST["btnChartMain"] == "02"){
        $sql = "SELECT da.AMP_CODE,da.AMP_NAME
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
        FROM dhf_ampur da
        ORDER BY CountPatient DESC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            array_push($resultPatient, array("label" => $row['AMP_NAME'], "value" => $row['CountPatient'])); 
        }

        echo json_encode($resultPatient);
    }
/*----------------------------------------------------------Chart--------------------------------------------------------*/
    if($_REQUEST["btnChartMain"] == "03"){
        $sql = "SELECT dp.NDIS,COUNT(dp.E0) AS CountGroup 
        FROM dhf_patient dp 
        WHERE dp.DISEASE IN ($id_506) AND dp.DATESICK BETWEEN '$date_start' AND '$date_end'
        GROUP BY dp.DISEASE
        ORDER BY dp.DISEASE DESC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            array_push($resultPatient, array("label" => $row['NDIS']." (".number_format($row['CountGroup']).")", "value" => $row['CountGroup'])); 
        }

        echo json_encode($resultPatient);
    }
    if($_REQUEST["btnChartMain"] == "04"){
        $sql = "SELECT dp.gender, COUNT(*) AS CountPatient
        FROM dhf_patient dp
        WHERE dp.DISEASE IN ($id_506) AND dp.DATESICK BETWEEN '$date_start' AND '$date_end'
        GROUP BY dp.gender ASC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            if($row['gender'] != ""){
                $temp_patient_sex = $row['gender'];
            }else{
                $temp_patient_sex = "ไม่ระบุ";
            }
            array_push($resultPatient, array("label" => $temp_patient_sex." (".number_format($row['CountPatient']).")", "value" => $row['CountPatient'])); 
        }

        echo json_encode($resultPatient);
    }
/*----------------------------------------------------------Chart--------------------------------------------------------*/
    if($_REQUEST["btnChartMain"] == "Week"){
        $sql_start_week = "SELECT CONCAT(dcl2.year,lpad(dcl2.week,2,'0')) AS result
        FROM dhf_calendar_lvl2 dcl2
        WHERE '$date_start' BETWEEN start_date AND end_date";
        $StartWeek = GetSqlData($sql_start_week);

        $sql_end_week = "SELECT CONCAT(dcl2.year,lpad(dcl2.week,2,'0')) AS result 
        FROM dhf_calendar_lvl2 dcl2
        WHERE '$date_end' BETWEEN start_date AND end_date";
        $EndWeek = GetSqlData($sql_end_week);

        $sql_week = "SELECT CONCAT(dcl2.year,lpad(dcl2.week,2,'0')) AS WeekCount
        FROM dhf_calendar_lvl2 dcl2
        WHERE CONCAT(dcl2.year,lpad(dcl2.week,2,'0')) BETWEEN '$StartWeek' AND '$EndWeek'
        ORDER BY WeekCount ASC";

        $rs_week = $db_saraburi->prepare($sql_week);
        $rs_week->execute();
        $results_week = $rs_week->fetchAll();

        $sql = "SELECT YEARWEEK(df.DATESICK,2) AS WeekGroup,COUNT(df.E0) AS CountPatient 
        FROM dhf_patient df
        WHERE df.DISEASE IN ($id_506) AND df.DATESICK BETWEEN '$date_start' AND '$date_end'
        GROUP BY WEEK(df.DATESICK,2)";
   
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            $resultPatient[$row['WeekGroup']] = $row['CountPatient'];
        }

        $resultWeek = array();
        foreach($results_week as $row_week) {

            array_push($resultWeek, array("label" => "สัปดาห์ที่ ".substr($row_week['WeekCount'],4,2).",".substr($row_week['WeekCount'],0,4), "value" => $resultPatient[$row_week['WeekCount']])); 
        }

        echo json_encode($resultWeek);
    }
?>
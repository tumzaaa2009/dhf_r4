<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year_temp = $_POST['year_temp'];
    $month_temp = $_POST['month_temp'];
    $AMP_CODE_temp = $_POST['AMP_CODE_temp'];
    
    if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['TUM_CODE'])){
        $temp_array = array();
        $i = 1;
        foreach ($_POST['year'] as $key => $value) {
            $temp_array[$i]['year'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['month'] as $key => $value) {
            $temp_array[$i]['month'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['AMP_CODE'] as $key => $value) {
            $temp_array[$i]['AMP_CODE'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['TUM_CODE'] as $key => $value) {
            $temp_array[$i]['TUM_CODE'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['date_in_month'] as $key => $value) {
            $temp_array[$i]['date_in_month'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['hi_survey'] as $key => $value) {
            $temp_array[$i]['hi_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['hi_find'] as $key => $value) {
            $temp_array[$i]['hi_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_religion_survey'] as $key => $value) {
            $temp_array[$i]['ci_religion_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_religion_find'] as $key => $value) {
            $temp_array[$i]['ci_religion_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_school_survey'] as $key => $value) {
            $temp_array[$i]['ci_school_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_school_find'] as $key => $value) {
            $temp_array[$i]['ci_school_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_hospital_survey'] as $key => $value) {
            $temp_array[$i]['ci_hospital_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_hospital_find'] as $key => $value) {
            $temp_array[$i]['ci_hospital_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_hotel_survey'] as $key => $value) {
            $temp_array[$i]['ci_hotel_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_hotel_find'] as $key => $value) {
            $temp_array[$i]['ci_hotel_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_factory_survey'] as $key => $value) {
            $temp_array[$i]['ci_factory_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_factory_find'] as $key => $value) {
            $temp_array[$i]['ci_factory_find'] = $value;
            $i++;
        }
    
        $i = 1;
        foreach ($_POST['ci_official_survey'] as $key => $value) {
            $temp_array[$i]['ci_official_survey'] = $value;
            $i++;
        }
        $i = 1;
        foreach ($_POST['ci_official_find'] as $key => $value) {
            $temp_array[$i]['ci_official_find'] = $value;
            $i++;
        }
    
    
        $sql = "DELETE FROM dhf_hi_ci WHERE year = '$year_temp' AND month = '$month_temp' AND AMP_CODE = '$AMP_CODE_temp'";
        $db_saraburi->exec($sql);
    
        $datetime = date('Y-m-d H:i:s');
        for ($a = 1; $a < $i; $a++) {
            $year = $temp_array[$a]['year'];
            $month = $temp_array[$a]['month'];
            $AMP_CODE = $temp_array[$a]['AMP_CODE'];
            $TUM_CODE = $temp_array[$a]['TUM_CODE'];
            $date_in_month = $temp_array[$a]['date_in_month'];
            $hi_survey = $temp_array[$a]['hi_survey'];
            $hi_find = $temp_array[$a]['hi_find'];
            $ci_religion_survey = $temp_array[$a]['ci_religion_survey'];
            $ci_religion_find = $temp_array[$a]['ci_religion_find'];
            $ci_school_survey = $temp_array[$a]['ci_school_survey'];
            $ci_school_find = $temp_array[$a]['ci_school_find'];
            $ci_hospital_survey = $temp_array[$a]['ci_hospital_survey'];
            $ci_hospital_find = $temp_array[$a]['ci_hospital_find'];
            $ci_hotel_survey = $temp_array[$a]['ci_hotel_survey'];
            $ci_hotel_find = $temp_array[$a]['ci_hotel_find'];
            $ci_factory_survey = $temp_array[$a]['ci_factory_survey'];
            $ci_factory_find = $temp_array[$a]['ci_factory_find'];
            $ci_official_survey = $temp_array[$a]['ci_official_survey'];
            $ci_official_find = $temp_array[$a]['ci_official_find'];
    
            $sql_insert = "INSERT INTO dhf_hi_ci SET
                    year = '$year',
                    month = '$month',
                    AMP_CODE = '$AMP_CODE',
                    TUM_CODE = '$TUM_CODE',
                    date_in_month = '$date_in_month',
                    list_order = '$a',
                    hi_survey = '$hi_survey',
                    hi_find = '$hi_find',
                    ci_religion_survey = '$ci_religion_survey',
                    ci_religion_find = '$ci_religion_find',
                    ci_school_survey = '$ci_school_survey',
                    ci_school_find = '$ci_school_find',
                    ci_hospital_survey = '$ci_hospital_survey',
                    ci_hospital_find = '$ci_hospital_find',
                    ci_hotel_survey = '$ci_hotel_survey',
                    ci_hotel_find = '$ci_hotel_find',
                    ci_factory_survey = '$ci_factory_survey',
                    ci_factory_find = '$ci_factory_find',
                    ci_official_survey = '$ci_official_survey',
                    ci_official_find = '$ci_official_find'";
    
            $resultSQL = $db_saraburi->exec($sql_insert);
            if ($resultSQL == "1") {
                $result = 1;
            } else {
                $result = 0;
            }
        }
    }else{
        $sql = "DELETE FROM dhf_hi_ci WHERE year = '$year_temp' AND month = '$month_temp' AND AMP_CODE = '$AMP_CODE_temp'";
        $db_saraburi->exec($sql);
        
        $result = 1;
    }

    $arr['result'] = $result;
    echo json_encode($arr);
?>
<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    $arrMonths = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');

    $year = $_POST["year"];
    $month = $_POST["month"];
    $ampur = $_POST["ampur"];

    if($ampur != "0"){
        $sql_ampur = " AND da.AMP_CODE = '$ampur'";
    }

    $sql = "SELECT da.*
    ,(SELECT COUNT(dft.TUM_CODE) FROM dhf_tumbol dft WHERE dft.AMP_CODE = da.AMP_CODE) AS CountAll
    ,(SELECT COUNT(hici.TUM_CODE) FROM dhf_hi_ci hici WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = da.AMP_CODE) AS CountAction
    FROM dhf_ampur da
    WHERE 1 $sql_ampur 
    ORDER BY da.AMP_CODE ASC";  
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

    $arrJson =  array();
    $arrJson["categories"] = array(array("category" => array()));
    $arrJson["dataset"] = array();
    array_push($arrJson["dataset"], array("seriesName" => "ลงข้อมูลแล้ว", "color" => "#62B58F", "data" => array()));
    array_push($arrJson["dataset"], array("seriesName" => "ยังไม่ลงข้อมูล", "color" => "#F2726F", "data" => array()));

    foreach ($results as $row) {

        array_push($arrJson["categories"][0]["category"], array("label" => "อ.".$row['AMP_NAME']));
     
        array_push($arrJson["dataset"][0]["data"], array("value" => $row['CountAction']));

        array_push($arrJson["dataset"][1]["data"], array("value" => ($row['CountAll'] - $row['CountAction'])));
    }

    echo json_encode($arrJson);
?>
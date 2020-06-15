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
    $j = 1;
    if(isset($_POST['ampur'])){
        foreach($_POST['ampur'] as $key => $value) {
            if($j == "1"){
                $ampur = $value;
            }else{
                $ampur = $ampur.",".$value;
            }
            $j++;
        }
    }
    if($ampur != ""){
        $sql_ampur = " AND da.AMP_CODE IN ($ampur) ";
    }

    $sql = "SELECT da.AMP_CODE,da.AMP_NAME
    ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND df.DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
    ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND df.DATESICK BETWEEN '$date_start' AND '$date_end' AND df.lat IS NOT NULL AND  df.lon IS NOT NULL) AS CountPoint
    FROM dhf_ampur da
    WHERE 1 $sql_ampur
    ORDER BY CountPatient DESC";
    
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
    $i = 1;
    $SumPatient = 0;
    $SumPoint = 0;

    $arrJson =  array();
    $arrJson["categories"] = array(array("category" => array()));
    $arrJson["dataset"] = array();
    array_push($arrJson["dataset"], array("seriesName" => "ลงพิกัดแล้ว", "color" => "#62B58F", "data" => array()));
    array_push($arrJson["dataset"], array("seriesName" => "ยังไม่ลงพิกัด", "color" => "#F2726F", "data" => array()));

    foreach ($results as $row) {

        array_push($arrJson["categories"][0]["category"], array("label" => "อ.".$row['AMP_NAME']));
     
        array_push($arrJson["dataset"][0]["data"], array("value" => $row['CountPoint']));

        array_push($arrJson["dataset"][1]["data"], array("value" => ($row['CountPatient'] - $row['CountPoint'])));
    }

    echo json_encode($arrJson);
?>
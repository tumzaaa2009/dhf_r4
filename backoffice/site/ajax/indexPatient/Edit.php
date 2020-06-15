<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $E0 = $_POST["E0"];
    $E1 = $_POST["E1"];
    $NAME = $_POST["NAME"];
    $cid = $_POST['cid'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $OCCUPAT = $_POST['OCCUPAT'];
    $nation = $_POST['nation'];
    $address_all = $_POST['address_all'];
    $ADDRESS = $_POST['ADDRESS'];
    $HSERV = $_POST['HSERV'];
    $DATESICK = $_POST['DATESICK'];
    $DATEDEFINE = $_POST['DATEDEFINE'];
    $Rerx = $_POST['Rerx'];
    $Typept = $_POST['Typept'];


    $datetime = date('Y-m-d H:i:s');
    $sql_edit = "UPDATE dhf_patient SET 
        NAME = '$NAME',
        cid = '$cid',
        gender = '$gender',
        age = '$age',
        OCCUPAT = '$OCCUPAT',
        nation = '$nation',
        address_all = '$address_all',
        ADDRESS = '$ADDRESS',
        HSERV = '$HSERV',
        DATEDEFINE = '$DATEDEFINE',
        Rerx = '$Rerx',
        Typept = '$Typept'
        WHERE E0 = '$E0' AND E1 = '$E1' AND DATESICK = '$DATESICK'";

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

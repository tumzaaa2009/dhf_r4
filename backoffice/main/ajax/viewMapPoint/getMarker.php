<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
    $i++;   
    if(isset($_POST['ampur'])){
        foreach($_POST['ampur'] as $key => $value) {
            if($i == "1"){
                $ampur = $value;
            }else{
                $ampur = $ampur.",".$value;
            }
            $i++;
        }
    }
    if($ampur != ""){
        $sql_ampur = " AND LEFT(dp.ADDRCODE,4) IN ($ampur) ";
    }

    $sql = "SELECT dp.*, dfa.AMP_NAME, dft.TUM_NAME
    FROM dhf_patient dp 
    LEFT JOIN dhf_ampur dfa ON LEFT(dp.ADDRCODE,4) = dfa.AMP_CODE
    LEFT JOIN dhf_tumbol dft ON LEFT(dp.ADDRCODE,6) = dft.TUM_CODE
    WHERE dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506) AND dp.lat IS NOT NULL AND  dp.lon IS NOT NULL $sql_ampur
    ORDER BY dp.DATESICK ASC";
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

    $geojson = array(
        'type'      => 'FeatureCollection',
        'features'  => array()
    );
    $order_list = 1;
    foreach ($results as $row) {

        $feature = array(
            "type" => "Feature",
            "properties" => array(
                "name"=> $row['TUM_NAME'],
                "ampur"=> $row['AMP_NAME'],
                "order_list" => $order_list,
                "E0" => $row['E0'],
                "E1" => $row['E1'],
                "fullname" => $row['NAME'],
                "DISEASE" => $row['DISEASE'],
                "NDIS" => $row['NDIS'],
                "address_all" => $row['address_all'],
                "ADDRESS" => $row['ADDRESS'],
                "DATESICK" => thai_date_fullmonth(strtotime($row['DATESICK'])),
                "radius" => $row['radius'],
            ),
            "geometry" => array(
                "type" => "Point",
                "coordinates" => json_decode("[" . $row['lon'] . "," . $row['lat'] . "]", true)
            )
        );
        array_push($geojson['features'], $feature);
        $order_list++;
    }
    echo json_encode($geojson);
?>

<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    if($_REQUEST["btnGeojson"] == "01"){


        $sql = "SELECT ga.*
        FROM gis_area ga
        WHERE ga.type = 'Tumbon'
        ORDER BY ga.aid ASC";
        $db_saraburi->exec("set names utf8");
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results=$rs->fetchAll(PDO::FETCH_ASSOC);

        $AmpurName = array(
            "1901" => "เมืองสระบุรี", 
            "1902" => "แก่งคอย", 
            "1903" => "หนองแค", 
            "1904" => "วิหารแดง", 
            "1905" => "หนองแซง	", 
            "1906" => "บ้านหมอ", 
            "1907" => "ดอนพุด", 
            "1908" => "หนองโดน", 
            "1909" => "พระพุทธบาท", 
            "1910" => "เสาไห้", 
            "1911" => "มวกเหล็ก",
            "1912" => "วังม่วง", 
            "1913" => "เฉลิมพระเกียรติ", 
        );

        $geojson = array(
            'type'      => 'FeatureCollection',
            'features'  => array()
        ); 
        
        foreach($results as $row) {

            $feature = array(
                "type"=> "Feature",
                "properties"=> array(
                    "id" => $row['aid'], 
                    "name"=> $row['name'],
                    "ampur"=> $AmpurName[substr($row['aid'],0,4)],
                ),
                "geometry"=> array(
                    "type"=> "Polygon",
                    "coordinates"=> json_decode($row['coordinates'], true),
                )
            );
            // Add feature array to feature collection array
            array_push($geojson['features'], $feature);
        }
        echo json_encode($geojson);
    }

?>
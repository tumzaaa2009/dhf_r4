<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $type_map = $_POST["type_map"];
    $year = $_POST["year"];
    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
    $ampur = $_POST["ampur"];
    $scale_type = $_POST["scale_type"];
    $i++;   

    $date_start = date('Y-m-01', strtotime("$year-$date_start-01"));
    $date_end = date('Y-m-t', strtotime("$year-$date_end-01"));

    if($type_map == "1"){
        $sql = "SELECT ga.*, dpl2.population AS Population
        ,(SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,4),'0000') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506)) AS CountPatient
        ,((SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,4),'0000') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506))*100000)/dpl2.population AS RatePopulation
        FROM gis_area ga 
        INNER JOIN dhf_population_lvl2 dpl2 ON dpl2.amp_code = LEFT(ga.aid,4)
        WHERE ga.type = 'Amphur'
        ORDER BY ga.aid ASC";    
        
    }elseif($type_map == "2"){
        $sql = "SELECT ga.*, dpl3.population AS Population
        ,(SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506)) AS CountPatient
        ,((SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506))*100000)/dpl3.population AS RatePopulation
        FROM gis_area ga 
        INNER JOIN dhf_population_lvl3 dpl3 ON dpl3.tum_code = LEFT(ga.aid,6)
        WHERE ga.type = 'Tumbon' AND CONCAT(LEFT(ga.aid,4),'0000') = '$ampur' 
        ORDER BY ga.aid ASC";    
    }

    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

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

    $Scale = array(
        array(0,5,10,20),
        array(0,20,30,50),
        array(0,50,100,150),
    );


    $geojson = array(
        'type'      => 'FeatureCollection',
        'features'  => array()
    ); 
    foreach($results as $row) {

        if(($row['RatePopulation'] != 0)){
            if($row['RatePopulation'] > $Scale[$scale_type][0] && $row['RatePopulation'] < $Scale[$scale_type][1]){
                $color = "#28A745";
                $opacity = 0.7;
            }else{
                if($row['RatePopulation'] >= $Scale[$scale_type][1] && $row['RatePopulation'] < $Scale[$scale_type][2]){
                    $color = "#ffff4d";
                    $opacity = 0.7;
                }else{
                    if($row['RatePopulation'] >= $Scale[$scale_type][2] && $row['RatePopulation'] < $Scale[$scale_type][3]){
                        $color = "#FF7C2C";
                        $opacity = 0.7;
                    }else{
                        $color = "#DC3545";
                        $opacity = 0.7;
                    }
                }
            }
        }else{
            $color = "#fff";
            $opacity = 0.7;
        }

        $feature = array(
            "type"=> "Feature",
            "properties"=> array(
                "id" => $row['aid'], 
                "name"=> $row['name'],
                "ampur"=> $AmpurName[substr($row['aid'],0,4)],
                "color"=> $color,
                "opacity"=> $opacity,
                "CountPatient"=> number_format($row['CountPatient']),
                "Population"=> number_format($row['Population']),
                "RatePopulation"=> number_format($row['RatePopulation'],2),
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

?>

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
        $sql = "SELECT *
        ,(SELECT COUNT(patien.E1) FROM dhf_patient_r4 patien
        WHERE 
         patien.DATESICK BETWEEN '$date_start' AND '$date_end'
        AND
        patien.DISEASE IN ($id_506)
        AND
        SUBSTRING(patien.ADDRCODE, 1, 2)=g4.areacode ) AS CountPatient
        ,((SELECT COUNT(dp.E1) FROM dhf_patient_r4 dp 
         WHERE 
         dp.DATESICK BETWEEN '$date_start' AND '$date_end'
        AND
        SUBSTRING(dp.ADDRCODE, 1, 2)=g4.areacode
        AND 
        dp.DISEASE IN ($id_506))*100000)/dhflvl2.population AS RatePopulation
        FROM gis_area_r4  g4
        INNER JOIN dhf_province dh_pro ON dh_pro.Pro_CODE=g4.areacode
        INNER JOIN dhf_population_lvl2 AS dhflvl2 ON dhflvl2.amp_code=dh_pro.Province_CODE
        
        GROUP BY g4.areacode
        ORDER BY dh_pro.Province_CODE ASC";    
        
    // }elseif($type_map == "2"){
        // $sql = "SELECT ga.*, dpl3.population AS Population
        // ,(SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506)) AS CountPatient
        // ,((SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506))*100000)/dpl3.population AS RatePopulation
        // FROM gis_area ga 
        // INNER JOIN dhf_population_lvl3 dpl3 ON dpl3.tum_code = LEFT(ga.aid,6)
        // WHERE ga.type = 'Tumbon' AND CONCAT(LEFT(ga.aid,4),'0000') = '$ampur' 
        // ORDER BY ga.aid ASC";    
    }

    $rs = $db_r4->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

    $AmpurName = array(
        "1901" => "จ.นครนายก", 
        "1902" => "จ.นนทบุรี", 
        "1903" => "จ.ปทุมธานี", 
        "1904" => "จ.อยุธยา", 
        "1905" => "จ.ลพบุรี", 
        "1906" => "จ.สระบุรี", 
        "1907" => "จ.สิงห์บุรี", 
        "1908" => "จ.อ่างทอง", 
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
                "id" => $row['areacode'], 
                "name"=> $row['areaname'],
                "ampur"=> $AmpurName[$row['Province_CODE']],
                "color"=> $color,
                "opacity"=> $opacity,
                "CountPatient"=> number_format($row['CountPatient']),
                "Population"=> number_format($row['population']),
                "RatePopulation"=> number_format($row['RatePopulation'],2),
            ),
            "geometry"=> array(
                "type"=> "Polygon",
                "coordinates"=> json_decode($row['areacoordinates'], true),
            )
        );
        // Add feature array to feature collection array
        array_push($geojson['features'], $feature);
    }
    echo json_encode($geojson);

?>

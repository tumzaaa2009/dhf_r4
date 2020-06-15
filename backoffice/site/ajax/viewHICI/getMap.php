<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];
    $month = $_POST["month"];
    $map_type = $_POST["map_type"];
    $HICI = $_POST["HICI"];
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
        $sql_ampur = " AND LEFT(ga.aid,4) IN ($ampur) ";
    }
    if($map_type == "Amphur"){
        if($HICI == "HI"){
            $sql = "SELECT ga.* 
            ,(SELECT (SUM(hici.hi_find)*100)/SUM(hici.hi_survey) 
                FROM dhf_hi_ci hici 
                WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = LEFT(ga.aid,4)) AS HICI
            FROM gis_area ga
            WHERE ga.type = '$map_type' $sql_ampur
            ORDER BY ga.aid ASC";   
        }elseif($HICI == "CI"){
            $sql = "SELECT ga.* 
            ,(SELECT ((SUM(hici.ci_religion_find)+SUM(hici.ci_school_find)+SUM(hici.ci_hospital_find)+SUM(hici.ci_hotel_find)+SUM(hici.ci_factory_find)+SUM(hici.ci_official_find))*100)/
                (SUM(hici.ci_religion_survey)+SUM(hici.ci_school_survey)+SUM(hici.ci_hospital_survey)+SUM(hici.ci_hotel_survey)+SUM(hici.ci_factory_survey)+SUM(hici.ci_official_survey)) 
                FROM dhf_hi_ci hici 
                WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = LEFT(ga.aid,4)) AS HICI
            FROM gis_area ga
            WHERE ga.type = '$map_type' $sql_ampur
            ORDER BY ga.aid ASC";   
        }  
    }elseif($map_type == "Tumbon"){
        if($HICI == "HI"){
            $sql = "SELECT ga.* 
            ,(SELECT (SUM(hici.hi_find)*100)/SUM(hici.hi_survey) 
                FROM dhf_hi_ci hici 
                WHERE hici.year = '$year' AND hici.month = '$month' AND hici.TUM_CODE = LEFT(ga.aid,6)) AS HICI
            FROM gis_area ga
            WHERE ga.type = '$map_type' $sql_ampur
            ORDER BY ga.aid ASC";   
        }elseif($HICI == "CI"){
            $sql = "SELECT ga.* 
            ,(SELECT ((SUM(hici.ci_religion_find)+SUM(hici.ci_school_find)+SUM(hici.ci_hospital_find)+SUM(hici.ci_hotel_find)+SUM(hici.ci_factory_find)+SUM(hici.ci_official_find))*100)/
                (SUM(hici.ci_religion_survey)+SUM(hici.ci_school_survey)+SUM(hici.ci_hospital_survey)+SUM(hici.ci_hotel_survey)+SUM(hici.ci_factory_survey)+SUM(hici.ci_official_survey)) 
                FROM dhf_hi_ci hici 
                WHERE hici.year = '$year' AND hici.month = '$month' AND hici.TUM_CODE = LEFT(ga.aid,6)) AS HICI
            FROM gis_area ga
            WHERE ga.type = '$map_type' $sql_ampur
            ORDER BY ga.aid ASC";   
        }  
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

    $geojson = array(
        'type'      => 'FeatureCollection',
        'features'  => array()
    ); 
    foreach($results as $row) {

        if($HICI == "HI"){
            if(($row['HICI'] != "")){
                if($row['HICI'] >= 0 && $row['HICI'] < 10){
                    $color = "#28A745";
                    $opacity = 0.7;
                }else{
                    if($row['HICI'] >= 10 && $row['HICI'] < 50){
                        $color = "#FF7C2C";
                        $opacity = 0.7;
                    }else{
                        if($row['HICI'] >= 50){
                            $color = "#DC3545";
                            $opacity = 0.7;
                        }else{
                            $color = "#fff";
                            $opacity = 0.3;
                        }
                    }
                }
            }else{
                $color = "#111";
                $opacity = 0.7;
            }
        }elseif($HICI == "CI"){
            if(($row['HICI'] != "")){
                if($row['HICI'] >= 0 && $row['HICI'] < 5){
                    $color = "#28A745";
                    $opacity = 0.7;
                }else{
                    if($row['HICI'] >= 5 && $row['HICI'] < 10){
                        $color = "#FF7C2C";
                        $opacity = 0.7;
                    }else{
                        if($row['HICI'] >= 10){
                            $color = "#DC3545";
                            $opacity = 0.7;
                        }else{
                            $color = "#fff";
                            $opacity = 0.3;
                        }
                    }
                }
            }else{
                $color = "#111";
                $opacity = 0.7;
            }
        }

        $feature = array(
            "type"=> "Feature",
            "properties"=> array(
                "id" => $row['aid'], 
                "name"=> $row['name'],
                "ampur"=> $AmpurName[substr($row['aid'],0,4)],
                "color"=> $color,
                "colorline"=> $ColorLine[substr($row['aid'],0,4)],
                "opacity"=> $opacity,
                "HICI"=> (isset($row['HICI']) ? round($row['HICI'],2) : ""),
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

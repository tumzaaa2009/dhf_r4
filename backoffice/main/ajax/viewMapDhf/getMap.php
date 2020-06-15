<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];
    $week = $_POST["week"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
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
        $sql_ampur = " AND LEFT(ga.aid,4) IN ($ampur) ";
    }

    $sql_week = "SELECT dcl2.* 
    FROM dhf_calendar_lvl2 dcl2 
    WHERE CONCAT(dcl2.year,lpad(dcl2.week,2,'0')) <= CONCAT('".$year."',lpad('".$week."',2,'0'))
    ORDER BY dcl2.year DESC,dcl2.week DESC
    LIMIT 0,5";
    $rs_week = $db_saraburi->prepare($sql_week);
    $rs_week->execute();
    $results_week = $rs_week->fetchAll();
    $sql_text_patient = "";
    $sql_dead_patient = "";
    $sql_text_week = "";
    $sql_text_year = "";
    $sql_index_patient = 1;
    foreach($results_week as $row_week){
        $sql_text_patient = $sql_text_patient." ,(SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '".$row_week['start_date']."' AND '".$row_week['end_date']."' AND dp.DISEASE IN (".$id_506.")) AS CountPatient". $sql_index_patient." ";
        $sql_dead_patient = $sql_dead_patient." ,(SELECT COUNT(dp.E0) FROM dhf_patient dp WHERE CONCAT(LEFT(dp.ADDRCODE,6),'00') = ga.aid AND dp.DATESICK BETWEEN '".$row_week['start_date']."' AND '".$row_week['end_date']."' AND dp.DISEASE IN (".$id_506.") AND dp.Rerx = 'ตาย') AS CountDead". $sql_index_patient." ";
        $sql_text_week = $sql_text_week." , '".$row_week['week']."' AS Week". $sql_index_patient." ";
        $sql_text_year = $sql_text_year." , '".$row_week['year']."' AS Year". $sql_index_patient." ";
        $sql_index_patient++;
    }
    $sql = "SELECT ga.*  ".$sql_text_patient." ".$sql_dead_patient." ".$sql_text_week." ".$sql_text_year."
    FROM gis_area ga
    WHERE ga.type = 'Tumbon' $sql_ampur
    ORDER BY ga.aid ASC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

    $ColorLine = array(
        "1901" => "#000", 
        "1902" => "#000", 
        "1903" => "#000", 
        "1904" => "#000", 
        "1905" => "#000", 
        "1906" => "#000", 
        "1907" => "#000", 
        "1908" => "#000", 
        "1909" => "#000", 
        "1910" => "#000", 
        "1911" => "#000",
        "1912" => "#000", 
        "1913" => "#000", 
    );
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

        if($row['CountPatient1'] > 0){
            $CountPatient1 = 1;
        }else{
            $CountPatient1 = 0;
        }
        if($row['CountPatient2'] > 0){
            $CountPatient2 = 1;
        }else{
            $CountPatient2 = 0;
        }
        if($row['CountPatient3'] > 0){
            $CountPatient3 = 1;
        }else{
            $CountPatient3 = 0;
        }
        if($row['CountPatient4'] > 0){
            $CountPatient4 = 1;
        }else{
            $CountPatient4 = 0;
        }

        $CountAll = $CountPatient1 + $CountPatient2 + $CountPatient3 + $CountPatient4;

        if(($row['CountDead1'] == "" || $row['CountDead1'] == "0") && ($row['CountDead2'] == "" || $row['CountDead2'] == "0") 
        && ($row['CountDead3'] == "" || $row['CountDead3'] == "0") && ($row['CountDead4'] == "" || $row['CountDead4'] == "0") 
        && ($row['CountDead5'] == "" || $row['CountDead5'] == "0")){
            if($CountAll == 4){
                $color = "#DC3545";
                $opacity = 0.7;
            }else{
                if($CountAll == 3){
                    $color = "#FF7C2C";
                    $opacity = 0.7;
                }else{
                    if($CountAll == 2){
                        $color = "#F8DC00";
                        $opacity = 0.7;
                    }else{
                        if($CountAll == 1){
                            $color = "#28A745";
                            $opacity = 0.7;
                        }else{
                            $color = "#fff";
                            $opacity = 0.3;
                        }
                    }
                }
            }
        }else{
            $color = "#111";
            $opacity = 0.7;
        }

        /*
                    if($row['CountPatient3'] > 0){
                        if($row['CountPatient4'] > 0){
                            if($row['CountPatient5'] > 0){
                                $color = "#DC3545";
                                $opacity = 0.9;
                            }else{
                                $color = "#F8A000";
                                $opacity = 0.5;
                            }
                        }else{
                            $color = "##F8DC00";
                            $opacity = 0.5;
                        }
                    }else{
                        $color = "#28A745";
                        $opacity = 0.5;
                    }

        */

        $feature = array(
            "type"=> "Feature",
            "properties"=> array(
                "id" => $row['aid'], 
                "name"=> $row['name'],
                "ampur"=> $AmpurName[substr($row['aid'],0,4)],
                "color"=> $color,
                "colorline"=> $ColorLine[substr($row['aid'],0,4)],
                "opacity"=> $opacity,
                "CountPatient1"=> (isset($row['CountPatient1']) ? $row['CountPatient1'] : ""),
                "CountPatient2"=> (isset($row['CountPatient2']) ? $row['CountPatient2'] : ""),
                "CountPatient3"=> (isset($row['CountPatient3']) ? $row['CountPatient3'] : ""),
                "CountPatient4"=> (isset($row['CountPatient4']) ? $row['CountPatient4'] : ""),
                "CountPatient5"=> (isset($row['CountPatient5']) ? $row['CountPatient5'] : ""),
                "CountDead1"=> (isset($row['CountDead1']) ? $row['CountDead1'] : ""),
                "CountDead2"=> (isset($row['CountDead2']) ? $row['CountDead2'] : ""),
                "CountDead3"=> (isset($row['CountDead3']) ? $row['CountDead3'] : ""),
                "CountDead4"=> (isset($row['CountDead4']) ? $row['CountDead4'] : ""),
                "CountDead5"=> (isset($row['CountDead5']) ? $row['CountDead5'] : ""),
                "Week1"=> (isset($row['Week1']) ? $row['Week1'] : ""),
                "Week2"=> (isset($row['Week2']) ? $row['Week2'] : ""),
                "Week3"=> (isset($row['Week3']) ? $row['Week3'] : ""),
                "Week4"=> (isset($row['Week4']) ? $row['Week4'] : ""),
                "Week5"=> (isset($row['Week5']) ? $row['Week5'] : ""),
                "Year1"=> (isset($row['Year1']) ? $row['Year1'] : ""),
                "Year2"=> (isset($row['Year2']) ? $row['Year2'] : ""),
                "Year3"=> (isset($row['Year3']) ? $row['Year3'] : ""),
                "Year4"=> (isset($row['Year4']) ? $row['Year4'] : ""),
                "Year5"=> (isset($row['Year5']) ? $row['Year5'] : ""),
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

<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

/*----------------------------------------------------------Chart--------------------------------------------------------*/
    if($_REQUEST["btnChartMain"] == "01"){
        if($token->group_id_506 != ""){
            $sql = "SELECT cp.age, COUNT(*) AS age_count
            FROM
            (
                SELECT
                    CASE WHEN age BETWEEN 1 AND 10
                        THEN '1'
                    WHEN age BETWEEN 11 AND 20
                        THEN '2'
                    WHEN age BETWEEN 21 AND 30
                        THEN '3'
                    WHEN age BETWEEN 31 AND 40
                        THEN '4'
                    WHEN age BETWEEN 41 AND 50
                        THEN '5'
                    WHEN age BETWEEN 51 AND 60
                        THEN '6'
                    WHEN age BETWEEN 61 AND 70
                        THEN '7'
                    WHEN age BETWEEN 71 AND 80
                        THEN '8'
                    WHEN age BETWEEN 81 AND 90
                        THEN '9'
                    WHEN age >= 90
                        THEN '10'
                        ELSE '11'
                    END AS age
                FROM dhf_patient
                WHERE DISEASE IN ($token->group_id_506) AND DATESICK BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31'
            ) cp
            GROUP BY cp.age
            ORDER BY cp.age ASC";
            $db_saraburi->exec("set names utf8");
            $rs = $db_saraburi->query($sql);
            $rs->execute();
            $results = $rs->fetchAll(PDO::FETCH_ASSOC);
    
            $arrCode = array(
                "1" => "0-10", 
                "2" => "11-20", 
                "3" => "21-30", 
                "4" => "31-40",
                "5" => "41-50",
                "6" => "51-60",
                "7" => "61-70",
                "8" => "71-80",
                "9" => "81-90",
                "10" => "มากกว่า 90",
                "11" => "ไม่ทราบอายุ",
            );
            $cnt_code = count($arrCode); 
    
            $resultPatient = array();
            foreach($results as $row) {
                $resultPatient[$row['age']] = $row['age_count'];
            }
    
            $arrJson = array();
            for ($i = 1; $i <= $cnt_code ; $i++) { 
                array_push($arrJson, array("label" => $arrCode[$i], "value" => number_format($resultPatient[$i],2))); 
            }
        }

        echo json_encode($arrJson);
    }
    if($_REQUEST["btnChartMain"] == "02"){
        $sql = "SELECT da.AMP_CODE,da.AMP_NAME
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($token->group_id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31') AS CountPatient
        FROM dhf_ampur da
        ORDER BY CountPatient DESC";
        $rs = $db_saraburi->prepare($sql);
        $rs->execute();
        $results = $rs->fetchAll();

        $resultPatient = array();
        foreach($results as $row) {
            array_push($resultPatient, array("label" => $row['AMP_NAME'], "value" => number_format($row['CountPatient'],2))); 
        }

        echo json_encode($resultPatient);
    }


?>
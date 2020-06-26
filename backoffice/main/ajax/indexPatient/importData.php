<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    include("../../../../PHPExcel/Classes/PHPExcel.php");
    include("../../../../PHPExcel/Classes/PHPExcel/IOFactory.php");
    date_default_timezone_set("Asia/Bangkok");

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    if($_FILES["fileImport"]["name"] != "") {
        $file_1 = explode(".",$_FILES['fileImport']['name']);
        $file_surname_1 = end($file_1);
        $filename_images_1 = md5(date("dmYhis").rand(1000,9999)).".".$file_surname_1;
        $target_file_1 = "../../../fileUpload/".$filename_images_1;
        if(move_uploaded_file($_FILES["fileImport"]["tmp_name"],$target_file_1)) {
            $inputFileName = $target_file_1;
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);  
            $objReader->setReadDataOnly(true);  
            $objPHPExcel = $objReader->load($inputFileName);  
            
            
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    $c = 1;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        if($c == 1){
                            $namedDataArray[$r]["E1"] = $dataRow[$row][$columnKey];
                        }elseif($c == 2){
                            $namedDataArray[$r]["DISEASE"] = $dataRow[$row][$columnKey];
                        }elseif($c == 3){
                            $namedDataArray[$r]["NDIS"] = $dataRow[$row][$columnKey];
                        }elseif($c == 4){
                            $namedDataArray[$r]["RACE"] = $dataRow[$row][$columnKey];
                        }elseif($c == 5){
                            $namedDataArray[$r]["SEX"] = $dataRow[$row][$columnKey];
                        }elseif($c == 6){
                            $namedDataArray[$r]["ADDRCODE"] = $dataRow[$row][$columnKey];
                        }elseif($c == 7){
                            $namedDataArray[$r]["DATESICK"] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dataRow[$row][$columnKey]));
                        }elseif($c == 8){
                            $namedDataArray[$r]["DATEDEFINE"] =date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dataRow[$row][$columnKey]));
                        }elseif($c == 9){
                            $namedDataArray[$r]["DATEREACH"] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dataRow[$row][$columnKey]));
                        }elseif($c == 10){
                            $namedDataArray[$r]["DATEDEATH"] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dataRow[$row][$columnKey]));
                        }elseif($c == 11){
                            $namedDataArray[$r]["HSERV"] = $dataRow[$row][$columnKey];
                        }elseif($c == 12){
                            $namedDataArray[$r]["AGEY"] = $dataRow[$row][$columnKey];
                        }elseif($c == 13){
                            $namedDataArray[$r]["AGEM"] = $dataRow[$row][$columnKey];
                        }elseif($c == 14){
                            $namedDataArray[$r]["AGED"] = $dataRow[$row][$columnKey];
                        }elseif($c == 15){
                            $namedDataArray[$r]["MARIETAL"] = $dataRow[$row][$columnKey];
                        }elseif($c == 16){
                            $namedDataArray[$r]["RACE1"] = $dataRow[$row][$columnKey];
                        }elseif($c == 17){
                            $namedDataArray[$r]["OCCUPAT"] = $dataRow[$row][$columnKey];
                        }elseif($c == 18){
                            $namedDataArray[$r]["METROPOL"] = $dataRow[$row][$columnKey];
                        }
                        $c++;
                    }
                }
            }
            $sql_delete = "DELETE FROM dhf_patient_r4 ";
            $db_r4->exec($sql_delete);      
            $datetime = date('Y-m-d H:i:s');
            $i_insert = 1;
            $sql_insert = "INSERT IGNORE INTO dhf_patient_r4 (
            E1
            ,DATESICK
            ,DISEASE
            ,NDIS
            ,RACE
            ,SEX
            ,ADDRCODE
            ,DATEDEFINE
            ,DATEREACH
            ,DATEDEATH
            ,HSERV) VALUES ";
            foreach ($namedDataArray as $import) {
                if($i_insert == 1){
                    $sql_insert = $sql_insert . "('".$import["E1"]."','".$import["DATESICK"]."','".$import["DISEASE"]."','".$import["NDIS"]."'
                    ,'".$import["RACE"]."','".$import["SEX"]."','".$import["ADDRCODE"]."','".$import["DATEDEFINE"]."','".$import["DATEREACH"]."'
                    ,'".$import["DATEDEATH"]."','".$import["HSERV"]."')";
                }else{
                    $sql_insert = $sql_insert .",('".$import["E1"]."','".$import["DATESICK"]."','".$import["DISEASE"]."','".$import["NDIS"]."'
                    ,'".$import["RACE"]."','".$import["SEX"]."','".$import["ADDRCODE"]."','".$import["DATEDEFINE"]."','".$import["DATEREACH"]."'
                    ,'".$import["DATEDEATH"]."','".$import["HSERV"]."')";
                } $i_insert++;
            }
            $db_r4->exec($sql_insert);
            $result = 1;

        }else{
            $result = 0;
        }
        if (unlink($target_file_1)){
            $delete = 1;
        }else{
            $delete = 0;
        }
    }else{
        $result = 0;
    }

    $arr['delete'] = $delete;
    $arr['result'] = $result;
    echo json_encode($arr);
?>
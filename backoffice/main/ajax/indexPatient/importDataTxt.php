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
            $open = fopen($inputFileName,'r');

            $datetime = date('Y-m-d H:i:s');
            $i_insert = 1;
            $sql_insert = "INSERT IGNORE INTO dhf_patient_copy (E0,E1,DISEASE,NDIS,NAME,RACE,gender,age,OCCUPAT,nation,ADDRESS,address_all,ADDRCODE,DATESICK,DATEDEFINE,HSERV,Rerx,Typept) VALUES ";
 
            while (!feof($open)) 
            {
                $getTextLine = fgets($open);
                $explodeLine = explode(",",$getTextLine);
                
                list($E0,$E1,$PE0,$PE1,$DISEASE,$NAME,$HN,$NMEPAT,$SEX,$AGEY,$AGEM,$AGED,$MARIETAL,$RACE,$RACE1,$OCCUPAT,$ADDRESS,$ADDRCODE,$METROPOL,$HOSPITAL,$TYPE,$RESULT,$HSERV,$CLASS,$SCHOOL,$DATESICK,$DATEDEFINE,$DATEDEATH,$DATERECORD,$DATEREACH,$INTIME,$ORGANISM,$COMPLICA,$IDCARD,$ICD10,$OFFICEID) = $explodeLine;
                    if($i_insert == 1){
                        $sql_insert = $sql_insert . "('".floor($E0)."','".floor($E1)."', '".str_replace('"','',$DISEASE)."', '', '".$NAME."',
                        '".$RACE."','".$SEX."','','".$OCCUPAT."','','".$ADDRESS."',
                        '','".$ADDRCODE."','".date("Y-m-d", strtotime($DATESICK))."','".date("Y-m-d", strtotime($DATEDEFINE))."','".$HSERV."',
                        '','')";
                    }else{
                        $sql_insert = $sql_insert . ",('".floor($E0)."','".floor($E1)."', '".str_replace('"','',$DISEASE)."', '', '".$NAME."',
                        '".$RACE."','".$SEX."','','".$OCCUPAT."','','".$ADDRESS."',
                        '','".$ADDRCODE."','".date("Y-m-d", strtotime($DATESICK))."','".date("Y-m-d", strtotime($DATEDEFINE))."','".$HSERV."',
                        '','')";
                    }
                    $i_insert++;
            }
            $db_saraburi->exec($sql_insert);
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
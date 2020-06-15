<?php
    session_start();
    include ("../../../../PHPExcel/Classes/PHPExcel.php");
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_GET["year"];
    $month = $_GET["month"];
    $ampur = $_GET["ampur"];

    if($ampur != "0"){
        $sql_ampur = " AND da.AMP_CODE = '$ampur'";
    }
  
    $sqlData = "SELECT da.AMP_NAME, GROUP_CONCAT(dt.TUM_NAME)AS TUM_NAME
    ,(SELECT COUNT(dtb.TUM_CODE) AS result FROM dhf_tumbol dtb WHERE dtb.AMP_CODE = da.AMP_CODE) AS total_tumbol
    ,COUNT(dhici.TUM_CODE) AS now_tumbol
    ,GROUP_CONCAT(DISTINCT DAY(dhici.date_in_month) ORDER BY dhici.date_in_month ASC)AS date_in_month
    ,SUM(dhici.hi_survey) AS hi_survey
    ,SUM(dhici.hi_find) AS hi_find
    ,SUM(dhici.ci_religion_survey) AS ci_religion_survey
    ,SUM(dhici.ci_religion_find) AS ci_religion_find
    ,SUM(dhici.ci_school_survey) AS ci_school_survey
    ,SUM(dhici.ci_school_find) AS ci_school_find
    ,SUM(dhici.ci_hospital_survey) AS ci_hospital_survey
    ,SUM(dhici.ci_hospital_find) AS ci_hospital_find
    ,SUM(dhici.ci_hotel_survey) AS ci_hotel_survey
    ,SUM(dhici.ci_hotel_find) AS ci_hotel_find
    ,SUM(dhici.ci_factory_survey) AS ci_factory_survey
    ,SUM(dhici.ci_factory_find) AS ci_factory_find
    ,SUM(dhici.ci_official_survey) AS ci_official_survey
    ,SUM(dhici.ci_official_find) AS ci_official_find
    FROM dhf_ampur da 
    LEFT JOIN dhf_hi_ci dhici ON da.AMP_CODE = dhici.AMP_CODE AND dhici.year = '$year' AND dhici.month = '$month' 
    LEFT JOIN dhf_tumbol dt ON dt.TUM_CODE = dhici.TUM_CODE
    WHERE 1 $sql_ampur 
    GROUP BY da.AMP_CODE
    ORDER BY da.AMP_CODE ASC";
    $rsData = $db_saraburi->prepare($sqlData);
    $rsData->execute();
    $resultsData = $rsData->fetchAll();

    $sqlAvg = "SELECT SUM(dhici.hi_survey) AS hi_survey
    ,SUM(dhici.hi_find) AS hi_find
    ,SUM(dhici.ci_religion_survey) AS ci_religion_survey
    ,SUM(dhici.ci_religion_find) AS ci_religion_find
    ,SUM(dhici.ci_school_survey) AS ci_school_survey
    ,SUM(dhici.ci_school_find) AS ci_school_find
    ,SUM(dhici.ci_hospital_survey) AS ci_hospital_survey
    ,SUM(dhici.ci_hospital_find) AS ci_hospital_find
    ,SUM(dhici.ci_hotel_survey) AS ci_hotel_survey
    ,SUM(dhici.ci_hotel_find) AS ci_hotel_find
    ,SUM(dhici.ci_factory_survey) AS ci_factory_survey
    ,SUM(dhici.ci_factory_find) AS ci_factory_find
    ,SUM(dhici.ci_official_survey) AS ci_official_survey
    ,SUM(dhici.ci_official_find) AS ci_official_find
    FROM dhf_ampur da 
    LEFT JOIN dhf_hi_ci dhici ON da.AMP_CODE = dhici.AMP_CODE AND dhici.year = '$year' AND dhici.month = '$month' 
    WHERE 1 $sql_ampur ";
    $rsAvg = $db_saraburi->prepare($sqlAvg);
    $rsAvg->execute();
    $Avg = $rsAvg->fetchAll();

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Company Co., Ltd.");
    $objPHPExcel->getProperties()->setLastModifiedBy("Company Co., Ltd.");
    $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX ReportQuery Document");
    $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX ReportQuery Document");
    $objPHPExcel->getProperties()->setDescription("ReportQuery from Company Co., Ltd.");

    $sheet = $objPHPExcel->getActiveSheet();
    $pageMargins = $sheet->getPageMargins();

    // margin is set in inches (0.5cm)
    $margin = 0.5 / 2.54;
    $pageMargins->setTop($margin);
    $pageMargins->setBottom($margin);
    $pageMargins->setLeft($margin);
    $pageMargins->setRight(0);

    $styleHeader = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 12,
            'name'  => 'TH SarabunPSK'
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    );
    $styleFooter = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 12,
            'name'  => 'TH SarabunPSK'
        ),
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )           
    );
    $styleText = array(
        'font'  => array(
            'size'  => 11,
            'name'  => 'TH SarabunPSK'
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        ),
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    );

    $months = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
    $columnCharacter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
    'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "แบบฟอร์มรายงานผลการสำรวจลูกน้ำยุงลายจิตอาสากระทรวงสาธารณสุข");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Y1');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "ประจำเดือน ".$months[$month]." ".($year+543)." เขตสุขภาพที่ 4");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:Y2');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "จังหวัด");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:A4');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "อำเภอ");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B4');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "ตำบล");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "วันที่ดำเนินงาน");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D4');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "การสำรวจบ้าน/ชุมชน");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E3:G3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "การสำรวจศาสนสถาน");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:J3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "การสำรวจโรงเรียน");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K3:M3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "การสำรวจโรงพยาบาล");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N3:P3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "การสำรวจโรงแรม");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q3:S3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "การสำรวจโรงงาน");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T3:V3');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W3', "การสำรวจสถานที่ราชการ");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W3:Y3');
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "จำนวนบ้านที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "จำนวนบ้านที่พบลูกน้ำ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "HI (%) ในภาพรวม");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "CI (%)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "CI (%)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "CI (%)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4', "CI (%)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V4', "CI (%)");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W4',"จำนวนภาชนะที่สำรวจ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X4', "จำนวนภาชนะที่พบลูกน้ำ   ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y4', "CI (%)");
    $objPHPExcel->getActiveSheet()->getStyle('E4:Y4')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('A1:Y4')->applyFromArray($styleHeader);

    //Set Width
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(8);

    $rowCell=5;
    //A
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCell, "สระบุรี");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCell)->applyFromArray($styleText);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:A17');

    foreach($resultsData as $row) {
        //B
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCell, $row['AMP_NAME']);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCell)->applyFromArray($styleText);
        //C
        if($row['TUM_NAME'] != ""){
            if($row['total_tumbol'] == $row['now_tumbol']){
                $temp_tumbol_name = "ทุกตำบล";
            }else{
                $temp_tumbol_name = $row['TUM_NAME'];
            }
        }else{
            $temp_tumbol_name = "ไม่มีการบันทึก";
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCell, $temp_tumbol_name);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCell)->getAlignment()->setWrapText(true);
        //D
        if($row['date_in_month'] != ""){
            $temp_date_in_month = $row['date_in_month'];
        }else{
            $temp_date_in_month = "ไม่มีการบันทึก";
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCell, $temp_date_in_month);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCell)->getAlignment()->setWrapText(true);
        //-------------------------------------------------------------------------------------------------
        //E
        if($row['hi_survey'] != ""){ $temp_hi_survey = $row['hi_survey']; }else{ $temp_hi_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCell, $temp_hi_survey);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCell)->applyFromArray($styleText);
        //F
        if($row['hi_find'] != ""){ $temp_hi_find = $row['hi_find']; }else{ $temp_hi_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCell, $temp_hi_find);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCell)->applyFromArray($styleText);
        //G
        if($row['hi_survey'] != "" && $row['hi_find']){ $temp_hi_avg = round(($row['hi_find']/$row['hi_survey'])*100, 2); }else{ $temp_hi_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCell, $temp_hi_avg);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //H
        if($row['ci_religion_survey'] != ""){ $temp_ci_religion_survey = $row['ci_religion_survey']; }else{ $temp_ci_religion_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCell, $temp_ci_religion_survey);
        $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCell)->applyFromArray($styleText);
        //I
        if($row['ci_religion_find'] != ""){ $temp_ci_religion_find = $row['ci_religion_find']; }else{ $temp_ci_religion_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCell, $temp_ci_religion_find);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCell)->applyFromArray($styleText);
        //J
        if($row['ci_religion_survey'] != "" && $row['ci_religion_find']){ $temp_ci_religion_avg = round(($row['ci_religion_find']/$row['ci_religion_survey'])*100, 2); }else{ $temp_ci_religion_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCell, $temp_ci_religion_avg);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //K
        if($row['ci_school_survey'] != ""){ $temp_ci_school_survey = $row['ci_school_survey']; }else{ $temp_ci_school_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$rowCell, $temp_ci_school_survey);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCell)->applyFromArray($styleText);
        //L
        if($row['ci_school_find'] != ""){ $temp_ci_school_find = $row['ci_school_find']; }else{ $temp_ci_school_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$rowCell, $temp_ci_school_find);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCell)->applyFromArray($styleText);
        //M
        if($row['ci_school_survey'] != "" && $row['ci_school_find']){ $temp_ci_school_avg = round(($row['ci_school_find']/$row['ci_school_survey'])*100, 2); }else{ $temp_ci_school_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$rowCell, $temp_ci_school_avg);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //N
        if($row['ci_hospital_survey'] != ""){ $temp_ci_hospital_survey = $row['ci_hospital_survey']; }else{ $temp_ci_hospital_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$rowCell, $temp_ci_hospital_survey);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$rowCell)->applyFromArray($styleText);
        //O
        if($row['ci_hospital_find'] != ""){ $temp_ci_hospital_find = $row['ci_hospital_find']; }else{ $temp_ci_hospital_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$rowCell, $temp_ci_hospital_find);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCell)->applyFromArray($styleText);
        //P
        if($row['ci_hospital_survey'] != "" && $row['ci_hospital_find']){ $temp_ci_hospital_avg = round(($row['ci_hospital_find']/$row['ci_hospital_survey'])*100, 2); }else{ $temp_ci_hospital_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$rowCell, $temp_ci_hospital_avg);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //Q
        if($row['ci_hotel_survey'] != ""){ $temp_ci_hotel_survey = $row['ci_hotel_survey']; }else{ $temp_ci_hotel_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$rowCell, $temp_ci_hotel_survey);
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCell)->applyFromArray($styleText);
        //R
        if($row['ci_hotel_find'] != ""){ $temp_ci_hotel_find = $row['ci_hotel_find']; }else{ $temp_ci_hotel_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$rowCell, $temp_ci_hotel_find);
        $objPHPExcel->getActiveSheet()->getStyle('R'.$rowCell)->applyFromArray($styleText);
        //S
        if($row['ci_hotel_survey'] != "" && $row['ci_hotel_find']){ $temp_ci_hotel_avg = round(($row['ci_hotel_find']/$row['ci_hotel_survey'])*100, 2); }else{ $temp_ci_hotel_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$rowCell, $temp_ci_hotel_avg);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //T
        if($row['ci_factory_survey'] != ""){ $temp_ci_factory_survey = $row['ci_factory_survey']; }else{ $temp_ci_factory_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$rowCell, $temp_ci_factory_survey);
        $objPHPExcel->getActiveSheet()->getStyle('T'.$rowCell)->applyFromArray($styleText);
        //U
        if($row['ci_factory_find'] != ""){ $temp_ci_factory_find = $row['ci_factory_find']; }else{ $temp_ci_factory_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$rowCell, $temp_ci_factory_find);
        $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCell)->applyFromArray($styleText);
        //V
        if($row['ci_factory_survey'] != "" && $row['ci_factory_find']){ $temp_ci_factory_avg = round(($row['ci_factory_find']/$row['ci_factory_survey'])*100, 2); }else{ $temp_ci_factory_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$rowCell, $temp_ci_factory_avg);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('V'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------
        //W
        if($row['ci_official_survey'] != ""){ $temp_ci_official_survey = $row['ci_official_survey']; }else{ $temp_ci_official_survey = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$rowCell, $temp_ci_official_survey);
        $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCell)->applyFromArray($styleText);
        //X
        if($row['ci_official_find'] != ""){ $temp_ci_official_find = $row['ci_official_find']; }else{ $temp_ci_official_find = 0; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$rowCell, $temp_ci_official_find);
        $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCell)->applyFromArray($styleText);
        //Y
        if($row['ci_official_survey'] != "" && $row['ci_official_find']){ $temp_ci_official_avg = round(($row['ci_official_find']/$row['ci_official_survey'])*100, 2); }else{ $temp_ci_official_avg = 0.00; }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$rowCell, $temp_ci_official_avg);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCell)->applyFromArray($styleText);
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
        //-------------------------------------------------------------------------------------------------

        $rowCell++;
    }
    //A
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCell, "สรุป");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCell)->applyFromArray($styleHeader);
    //B
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCell, "");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCell)->applyFromArray($styleHeader);
    //C
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCell, "");
    $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCell)->applyFromArray($styleHeader);
    //D
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCell, "");
    $objPHPExcel->getActiveSheet()->getStyle('D'.$rowCell)->applyFromArray($styleHeader);
    //-------------------------------------------------------------------------------------------------
    //E
    if($Avg[0]['hi_survey'] != ""){ $temp_hi_survey = $Avg[0]['hi_survey']; }else{ $temp_hi_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCell, $temp_hi_survey);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$rowCell)->applyFromArray($styleHeader);
    //F
    if($Avg[0]['hi_find'] != ""){ $temp_hi_find = $Avg[0]['hi_find']; }else{ $temp_hi_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCell, $temp_hi_find);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCell)->applyFromArray($styleHeader);
    //G
    if($Avg[0]['hi_survey'] != "" && $Avg[0]['hi_find']){ $temp_hi_avg = round(($Avg[0]['hi_find']/$Avg[0]['hi_survey'])*100, 2); }else{ $temp_hi_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCell, $temp_hi_avg);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //H
    if($Avg[0]['ci_religion_survey'] != ""){ $temp_ci_religion_survey = $Avg[0]['ci_religion_survey']; }else{ $temp_ci_religion_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCell, $temp_ci_religion_survey);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$rowCell)->applyFromArray($styleHeader);
    //I
    if($Avg[0]['ci_religion_find'] != ""){ $temp_ci_religion_find = $Avg[0]['ci_religion_find']; }else{ $temp_ci_religion_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCell, $temp_ci_religion_find);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCell)->applyFromArray($styleHeader);
    //J
    if($Avg[0]['ci_religion_survey'] != "" && $Avg[0]['ci_religion_find']){ $temp_ci_religion_avg = round(($Avg[0]['ci_religion_find']/$Avg[0]['ci_religion_survey'])*100, 2); }else{ $temp_ci_religion_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCell, $temp_ci_religion_avg);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //K
    if($Avg[0]['ci_school_survey'] != ""){ $temp_ci_school_survey = $Avg[0]['ci_school_survey']; }else{ $temp_ci_school_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$rowCell, $temp_ci_school_survey);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$rowCell)->applyFromArray($styleHeader);
    //L
    if($Avg[0]['ci_school_find'] != ""){ $temp_ci_school_find = $Avg[0]['ci_school_find']; }else{ $temp_ci_school_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$rowCell, $temp_ci_school_find);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$rowCell)->applyFromArray($styleHeader);
    //M
    if($Avg[0]['ci_school_survey'] != "" && $Avg[0]['ci_school_find']){ $temp_ci_school_avg = round(($Avg[0]['ci_school_find']/$Avg[0]['ci_school_survey'])*100, 2); }else{ $temp_ci_school_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$rowCell, $temp_ci_school_avg);
    $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('M'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //N
    if($Avg[0]['ci_hospital_survey'] != ""){ $temp_ci_hospital_survey = $Avg[0]['ci_hospital_survey']; }else{ $temp_ci_hospital_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$rowCell, $temp_ci_hospital_survey);
    $objPHPExcel->getActiveSheet()->getStyle('N'.$rowCell)->applyFromArray($styleHeader);
    //O
    if($Avg[0]['ci_hospital_find'] != ""){ $temp_ci_hospital_find = $Avg[0]['ci_hospital_find']; }else{ $temp_ci_hospital_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$rowCell, $temp_ci_hospital_find);
    $objPHPExcel->getActiveSheet()->getStyle('O'.$rowCell)->applyFromArray($styleHeader);
    //P
    if($Avg[0]['ci_hospital_survey'] != "" && $Avg[0]['ci_hospital_find']){ $temp_ci_hospital_avg = round(($Avg[0]['ci_hospital_find']/$Avg[0]['ci_hospital_survey'])*100, 2); }else{ $temp_ci_hospital_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$rowCell, $temp_ci_hospital_avg);
    $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //Q
    if($Avg[0]['ci_hotel_survey'] != ""){ $temp_ci_hotel_survey = $Avg[0]['ci_hotel_survey']; }else{ $temp_ci_hotel_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$rowCell, $temp_ci_hotel_survey);
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$rowCell)->applyFromArray($styleHeader);
    //R
    if($Avg[0]['ci_hotel_find'] != ""){ $temp_ci_hotel_find = $Avg[0]['ci_hotel_find']; }else{ $temp_ci_hotel_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$rowCell, $temp_ci_hotel_find);
    $objPHPExcel->getActiveSheet()->getStyle('R'.$rowCell)->applyFromArray($styleHeader);
    //S
    if($Avg[0]['ci_hotel_survey'] != "" && $Avg[0]['ci_hotel_find']){ $temp_ci_hotel_avg = round(($Avg[0]['ci_hotel_find']/$Avg[0]['ci_hotel_survey'])*100, 2); }else{ $temp_ci_hotel_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$rowCell, $temp_ci_hotel_avg);
    $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('S'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //T
    if($Avg[0]['ci_factory_survey'] != ""){ $temp_ci_factory_survey = $Avg[0]['ci_factory_survey']; }else{ $temp_ci_factory_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$rowCell, $temp_ci_factory_survey);
    $objPHPExcel->getActiveSheet()->getStyle('T'.$rowCell)->applyFromArray($styleHeader);
    //U
    if($Avg[0]['ci_factory_find'] != ""){ $temp_ci_factory_find = $Avg[0]['ci_factory_find']; }else{ $temp_ci_factory_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$rowCell, $temp_ci_factory_find);
    $objPHPExcel->getActiveSheet()->getStyle('U'.$rowCell)->applyFromArray($styleHeader);
    //V
    if($Avg[0]['ci_factory_survey'] != "" && $Avg[0]['ci_factory_find']){ $temp_ci_factory_avg = round(($Avg[0]['ci_factory_find']/$Avg[0]['ci_factory_survey'])*100, 2); }else{ $temp_ci_factory_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$rowCell, $temp_ci_factory_avg);
    $objPHPExcel->getActiveSheet()->getStyle('V'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('V'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    //W
    if($Avg[0]['ci_official_survey'] != ""){ $temp_ci_official_survey = $Avg[0]['ci_official_survey']; }else{ $temp_ci_official_survey = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$rowCell, $temp_ci_official_survey);
    $objPHPExcel->getActiveSheet()->getStyle('W'.$rowCell)->applyFromArray($styleHeader);
    //X
    if($Avg[0]['ci_official_find'] != ""){ $temp_ci_official_find = $Avg[0]['ci_official_find']; }else{ $temp_ci_official_find = 0; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$rowCell, $temp_ci_official_find);
    $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCell)->applyFromArray($styleHeader);
    //Y
    if($Avg[0]['ci_official_survey'] != "" && $Avg[0]['ci_official_find']){ $temp_ci_official_avg = round(($Avg[0]['ci_official_find']/$Avg[0]['ci_official_survey'])*100, 2); }else{ $temp_ci_official_avg = 0.00; }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$rowCell, $temp_ci_official_avg);
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCell)->applyFromArray($styleHeader);
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$rowCell)->getNumberFormat()->setFormatCode('0.00'); 
    //-------------------------------------------------------------------------------------------------
    $rowCell++;
    //-------------------------------------------------------------------------------------------------
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCell, "ผู้รายงาน...............................................................................หมายเลขติดต่อ..................................................................................");
    $objPHPExcel->getActiveSheet()->getStyle('B'.$rowCell)->applyFromArray($styleFooter);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$rowCell.':M'.$rowCell);
    //-------------------------------------------------------------------------------------------------
    $rowCell++;
    //-------------------------------------------------------------------------------------------------
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCell, "หมายเหตุ : 1. กำหนดให้ดำเนินกิจกรรมตาม setting 7ร. ได้แก่ 1.โรงเรือน(บ้าน/ชุมชน)  2.โรงธรรม(ศาสนสถาน) 3.โรงเรียน 4.โรงพยาบาล 5.โรงแรม 6.โรงงาน 7.สถานที่ราชการ\n2. ตัดข้อมูลภายในวันที่ 30 ของทุกเดือน\n3. สสจ./สำนักอนามัย กทม. รวบรวมข้อมูลเป็น sheet เดียวของจังหวัด ส่งสำนักงานเขตสุขภาพ/สคร./สปคม. หลังเสร็จกิจกรรมฯ ภายในวันที่ 7 ของเดือนถัดไป \n4. สำนักงานเขตสุขภาพ/สคร./สปคม. รวบรวมข้อมูลส่งทาง email : jitarsa.moph@gmail.com");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCell)->applyFromArray($styleFooter);
    $objPHPExcel->getActiveSheet()->getRowDimension((string)$rowCell)->setRowHeight(60);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCell.':Y'.$rowCell)->getAlignment()->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowCell.':Y'.$rowCell);


    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('HI-CI-Report');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    //ตั้งชื่อไฟล์
    $file_name = "HI-CI-Report";
    // Save Excel 2007 file
    #echo date('H:i:s') . " Write to Excel2007 format\n";
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    // We'll be outputting an excel file
    header('Content-type: application/vnd.ms-excel');
    // It will be called file.xls
    header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
    $objWriter->save('php://output');	
    exit();

?>
<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $arrMonths = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');

    $year = $_POST["year"];
    $month = $_POST["month"];
    $ampur = $_POST["ampur"];

    if($ampur != "0"){
        $sql_ampur = " AND da.AMP_CODE = '$ampur'";
    }

    $sql = "SELECT da.*
    ,(SELECT (SUM(hici.hi_find)*100)/SUM(hici.hi_survey) FROM dhf_hi_ci hici WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = da.AMP_CODE) AS HI
    ,(SELECT ((SUM(hici.ci_religion_find)+SUM(hici.ci_school_find)+SUM(hici.ci_hospital_find)+SUM(hici.ci_hotel_find)+SUM(hici.ci_factory_find)+SUM(hici.ci_official_find))*100)/
        (SUM(hici.ci_religion_survey)+SUM(hici.ci_school_survey)+SUM(hici.ci_hospital_survey)+SUM(hici.ci_hotel_survey)+SUM(hici.ci_factory_survey)+SUM(hici.ci_official_survey)) 
        FROM dhf_hi_ci hici 
        WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = da.AMP_CODE) AS CI
    FROM dhf_ampur da
    WHERE 1 $sql_ampur 
    ORDER BY da.AMP_CODE ASC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">รหัสอำเภอ</th>
                        <th class="text-center p-2">อำเภอ</th>
                        <th class="text-center p-2">ปี</th>
                        <th class="text-center p-2">เดือน</th>
                        <th class="text-center p-2">HI</th>
                        <th class="text-center p-2">CI</th>
                        <th class="text-center p-2">จัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['year']; ?>">
                            <td class="text-center p-2"><?php echo $row['AMP_CODE']; ?></td>
                            <td class="text-center p-2"><?php echo "อ.".$row['AMP_NAME']; ?></td>
                            <td class="text-center p-2"><?php echo $year; ?></td>
                            <td class="text-center p-2"><?php echo $arrMonths[$month]; ?></td>
                            <td class="text-center p-2"><?php echo number_format($row['HI'],2); ?></td>
                            <td class="text-center p-2"><?php echo number_format($row['CI'],2); ?></td>
                            <td class="text-center p-2"><a href="manage_hici.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>&ampur=<?php echo $row['AMP_CODE']; ?>"><i class="fas fa-tasks text-warning"></i></a></td>
                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>


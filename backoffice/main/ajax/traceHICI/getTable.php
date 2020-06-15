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
    ,(SELECT COUNT(dft.TUM_CODE) FROM dhf_tumbol dft WHERE dft.AMP_CODE = da.AMP_CODE) AS CountAll
    ,(SELECT COUNT(hici.TUM_CODE) FROM dhf_hi_ci hici WHERE hici.year = '$year' AND hici.month = '$month' AND hici.AMP_CODE = da.AMP_CODE) AS CountAction
    FROM dhf_ampur da
    WHERE 1 $sql_ampur 
    ORDER BY da.AMP_CODE ASC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
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
                        <th class="text-center p-2">จำนวนตำบลทั้งหมด</th>
                        <th class="text-center p-2">จำนวนที่ลงข้อมูล</th>
                        <th class="text-center p-2">ร้อยละ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['year']; ?>">
                            <td class="text-center p-2"><?php echo $row['AMP_CODE']; ?></td>
                            <td class="text-center p-2"><?php echo "อ.".$row['AMP_NAME']; ?></td>
                            <td class="text-center p-2"><?php echo $year; ?></td>
                            <td class="text-center p-2"><?php echo $arrMonths[$month]; ?></td>
                            <td class="text-center p-2"><?php echo number_format($row['CountAll']); ?></td>
                            <td class="text-center p-2"><?php echo number_format($row['CountAction']); ?></td>
                            
                            <td class="text-center p-2"><?php echo($row['CountAction'] != 0 ? number_format(($row['CountAction']/$row['CountAll'])*100,2) : "0.00"); ?></td>
                        </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>


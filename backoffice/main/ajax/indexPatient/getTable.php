<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
    $ampur = $_POST["ampur"];

    if($ampur != "0"){
        $sql_ampur = " AND LEFT(dp.ADDRCODE,4) = '$ampur'";
    }
    
    $sql = "SELECT * FROM dhf_patient_r4 p4 INNER JOIN 
    gis_area_r4 gr4 on gr4.areacode= SUBSTRING(p4.ADDRCODE, 1, 2)
    order BY gr4.areacode DESC";     
    $rs = $db_r4->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">E1</th>
                        <th class="text-center p-2">วันที่เริ่มป่วย</th>
                        <th class="text-center p-2">โรค</th>
                        <th class="text-center p-2">ชื่อโรค</th>
                        <th class="text-center p-2">เชื้อชาติ</th>
                        <th class="text-center p-2">เพศ</th>
                        <th class="text-center p-2">จังหวัด</th>
                        <th class="text-center p-2">ที่อยู่</th>
                        <th class="text-center p-2">วันทีมา ร.พ.</th>
                        <!--<th class="text-center p-2">Lab</th>-->
                        <th class="text-center p-2">วันที่รับรายงาน</th>
                        <th class="text-center p-2">วันที่เสียชีวิต</th>
                        <th class="text-center p-2">รหัสสถานที่รักษา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['E1']; ?>-<?php echo $row['DATESICK']; ?>">
                            <td class="text-center p-2"><?php echo $row['E1']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATESICK']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DISEASE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['NDIS']; ?></td>
                            <td class="text-center p-2"><?php echo $row['RACE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['SEX']; ?></td>
                            <td class="text-center p-2"><?php echo $row['areaname']; ?></td>
                            <td class="text-center p-2"><?php echo $row['ADDRCODE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATEDEFINE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATEREACH']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATEDEATH']; ?></td>
                            <td class="text-center p-2"><?php echo $row['HSERV']; ?></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


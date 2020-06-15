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
    
    $sql = "SELECT dp.*, dfa.AMP_NAME
    FROM dhf_patient dp
    LEFT JOIN dhf_ampur dfa ON LEFT(dp.ADDRCODE,4) = dfa.AMP_CODE
    WHERE dp.DATESICK BETWEEN '$date_start' AND '$date_end' AND dp.DISEASE IN ($id_506) $sql_ampur
    ORDER BY dp.E0 DESC";     
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
                        <th class="text-center p-2">E0</th>
                        <th class="text-center p-2">E1</th>
                        <th class="text-center p-2">DISEASE</th>
                        <th class="text-center p-2">NDIS</th>
                        <th class="text-center p-2">ชื่อ - นามสกุล</th>
                        <th class="text-center p-2">วันที่ป่วย</th>
                        <th class="text-center p-2">วันที่วินิจฉัย</th>
                        <th class="text-center p-2">อำเภอ</th>
                        <!--<th class="text-center p-2">Lab</th>-->
                        <th class="text-center p-2">Follow</th>
                        <th class="text-center p-2">Map</th>
                        <th class="text-center p-2">รายละเอียด</th>
                        <th class="text-center p-2">แก้ไข</th>
                        <th class="text-center p-2">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['E0']; ?>-<?php echo $row['DATESICK']; ?>">
                            <td class="text-center p-2"><?php echo $row['E0']; ?></td>
                            <td class="text-center p-2"><?php echo $row['E1']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DISEASE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['NDIS']; ?></td>
                            <td class="text-left p-2"><?php echo $row['NAME']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATESICK']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATEDEFINE']; ?></td>
                            <td class="text-left p-2"><?php echo ($row['AMP_NAME'] != "" ? "อ.".$row['AMP_NAME'] : "ไม่สามารถระบุได้"); ?></td>
                            <!--<td class="text-center p-2"><i class="fas fa-vial"></i></td>-->
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="LoadPatientFollow('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-walking"></i></a></td>
                            <td class="text-center p-2">
                                <?php if($row["lat"] == "" || $row["lon"] == "" || $row["lat"] == "0" || $row["lon"] == "0"){ $temp_map = "text-danger"; }else{ $temp_map = "text-success"; } ?>
                                <a href="javascript:void(0);" onclick="MapManage('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-map-marked-alt <?php echo $temp_map; ?>"></i></a>
                            </td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DetailPatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-info-circle text-info"></a></i></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="EditPatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-edit text-warning"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DeletePatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-trash-alt text-danger"></i></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


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
     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">E0</th>
                        <th class="text-center p-2">DISEASE</th>
                        <th class="text-center p-2">NDIS</th>
                        <th class="text-center p-2">วันที่ป่วย</th>
                        <th class="text-center p-2">วันที่วินิจฉัย</th>
                     
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['E0']; ?>-<?php echo $row['DATESICK']; ?>">
                            <td class="text-center p-2"><?php echo $row['E0']; ?></td>
                            <!-- <td class="text-center p-2"><?php echo $row['E1']; ?></td> -->
                            <td class="text-center p-2"><?php echo $row['DISEASE']; ?></td>
                            <td class="text-center p-2"><?php echo $row['NDIS']; ?></td>
                            <!-- <td class="text-left p-2"><?php echo $row['NAME']; ?></td> -->
                            <td class="text-center p-2"><?php echo $row['DATESICK']; ?></td>
                            <td class="text-center p-2"><?php echo $row['DATEDEFINE']; ?></td>
                            <!-- <td class="text-left p-2"><?php echo ($row['AMP_NAME'] != "" ? "อ.".$row['AMP_NAME'] : "ไม่สามารถระบุได้"); ?></td> -->
                            <!--<td class="text-center p-2"><i class="fas fa-vial"></i></td>-->
                            <!-- <td class="text-center p-2"><a href="javascript:void(0);" onclick="LoadPatientFollow('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-walking"></i></a></td> -->

                            <!-- <td class="text-center p-2"><a href="javascript:void(0);" onclick="DetailPatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-info-circle text-info"></a></i></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="EditPatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-edit text-warning"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DeletePatient('<?php echo $row['E0']; ?>','<?php echo $row['DATESICK']; ?>')"><i class="fas fa-trash-alt text-danger"></i></a></td> -->
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


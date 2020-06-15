<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $E0 = $_POST["E0"];
    $DATESICK = $_POST["DATESICK"];
    //---------------------------------------------------------------------------------------
    $sql = "SELECT dp.* FROM dhf_patient dp WHERE dp.E0 = '$E0' AND dp.DATESICK = '$DATESICK'";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $row = $rs->fetchAll();
    //---------------------------------------------------------------------------------------
    $sql_follow = "SELECT pf.*
    FROM dhf_patient_follow pf
    WHERE pf.E0 = '$E0' AND pf.DATESICK = '$DATESICK' 
    ORDER BY pf.E0 DESC";     
    $rs_follow = $db_saraburi->prepare($sql_follow);
    $rs_follow->execute();
    $results_follow = $rs_follow->fetchAll();

/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">การติดตามข้อมูลผู้ป่วย : <?php echo $row[0]["NAME"]; ?> [<?php echo $row[0]["E0"];?>]</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-right">
                <button type="button" class="btn btn-sm btn-primary" onclick="AddPatientFollow('<?php echo $row[0]['E0'];?>','<?php echo $row[0]['DATESICK'];?>')"><i class="fas fa-plus mr-1"></i> เพิ่มข้อมูลการติดตาม</button>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTableFollow" style="width:100%">
                        <thead class="bg-table-in-page">
                            <tr>
                                <th class="text-center  p-2">รายละเอียด</th>
                                <th class="text-center p-2" style="width: 150px;"><span class="text-dark">วันที่ติดตาม</span><br><span class="text-info">วันที่ปรับปรุงล่าสุด</span></th>
                                <th class="text-center p-2" style="width: 120px;">ผู้บันทึก</th>
                                <th class="text-center p-2" style="width: 50px;">แก้ไข</th>
                                <th class="text-center p-2" style="width: 50px;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results_follow as $row_fw) { ?>
                                <tr id="tr_<?php echo $row_fw['follow_id']; ?>">
                                    <td class="text-left p-2"><?php echo $row_fw['follow_detail']; ?></td>
                                    <td class="text-center p-2"><?php echo date("d/m/Y", strtotime($row_fw['follow_date'])); ?><br><small class="text-info">(<?php echo ($row_fw['update_date'] != "" ? date("d/m/Y", strtotime($row_fw['update_date'])) : date("d/m/Y", strtotime($row_fw['follow_datetime']))); ?>)</small></td>
                                    <td class="text-center p-2"><?php echo $row_fw['create_user']; ?></td>
                                    <td class="text-center p-2"><a href="javascript:void(0);" onclick="EditPatientFollow('<?php echo $row_fw['follow_id']; ?>','<?php echo $row_fw['E0']; ?>','<?php echo $row_fw['DATESICK']; ?>')"><i class="fas fa-edit text-warning"></i></a></td>
                                    <td class="text-center p-2"><a href="javascript:void(0);" onclick="DeletePatientFollow('<?php echo $row_fw['follow_id']; ?>','<?php echo $row_fw['E0']; ?>','<?php echo $row_fw['DATESICK']; ?>')"><i class="fas fa-trash-alt text-danger"></i></a></td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
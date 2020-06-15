<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $E0 = $_POST["E0"];
    $DATESICK = $_POST["DATESICK"];
    $follow_id = $_POST["follow_id"];
    //---------------------------------------------------------------------------------------
    $sql = "SELECT dp.* FROM dhf_patient dp WHERE dp.E0 = '$E0'";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $row = $rs->fetchAll();
    //---------------------------------------------------------------------------------------
    $sql_flw = "SELECT dpf.* FROM dhf_patient_follow dpf WHERE dpf.E0 = '$E0' AND dpf.follow_id = '$follow_id'";     
    $rs_flw = $db_saraburi->prepare($sql_flw);
    $rs_flw->execute();
    $row_flw = $rs_flw->fetchAll();

/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">การติดตามข้อมูลผู้ป่วย : <?php echo $row[0]["NAME"]; ?> [<?php echo $row[0]["E0"];?>]</h4>
    </div>
    <div class="modal-body bg-secondary-gradient">
        <form id="EditPatientFollow" method="post" enctype="multipart/form-data">
            <input type="hidden" name="E0" id="E0" value="<?php echo $E0; ?>">
            <input type="hidden" name="follow_id" id="follow_id" value="<?php echo $follow_id; ?>">
            <input type="hidden" name="DATESICK" id="DATESICK" value="<?php echo $DATESICK; ?>">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="follow_date">วันที่ติดตาม <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker_follow" id="follow_date" name="follow_date" value="<?php echo $row_flw[0]["follow_date"]; ?>">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="follow_detail">รายละเอียดการติดตาม <span class="text-danger">*</span></label>
                        <textarea name="follow_detail" id="follow_detail" class="form-control" cols="30" rows="10"><?php echo $row_flw[0]["follow_detail"]; ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer" style="background-color: #EBEBEB;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="FollowEditSubmit">บันทึก</button>
    </div>
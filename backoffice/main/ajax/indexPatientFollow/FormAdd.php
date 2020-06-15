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


/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">การติดตามข้อมูลผู้ป่วย : <?php echo $row[0]["NAME"]; ?> [<?php echo $row[0]["E0"];?>]</h4>
    </div>
    <div class="modal-body bg-secondary-gradient">
        <form id="AddPatientFollow" method="post" enctype="multipart/form-data">
            <input type="hidden" name="E0" id="E0" value="<?php echo $E0; ?>">
            <input type="hidden" name="DATESICK" id="DATESICK" value="<?php echo $DATESICK; ?>">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="follow_date">วันที่ติดตาม <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker_follow" id="follow_date" name="follow_date" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="follow_detail">รายละเอียดการติดตาม <span class="text-danger">*</span></label>
                        <textarea name="follow_detail" id="follow_detail" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer" style="background-color: #EBEBEB;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="FollowAddSubmit">บันทึก</button>
    </div>
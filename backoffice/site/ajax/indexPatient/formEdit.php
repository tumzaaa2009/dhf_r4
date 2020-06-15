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
    $sql_ocp = "SELECT DISTINCT dp.OCCUPAT FROM dhf_patient dp ORDER BY dp.OCCUPAT ASC";     
    $rs_ocp = $db_saraburi->prepare($sql_ocp);
    $rs_ocp->execute();
    $results_ocp = $rs_ocp->fetchAll();
    //---------------------------------------------------------------------------------------
    $sql_nt = "SELECT DISTINCT dp.nation FROM dhf_patient dp ORDER BY dp.nation ASC";     
    $rs_nt = $db_saraburi->prepare($sql_nt);
    $rs_nt->execute();
    $results_nt = $rs_nt->fetchAll();


/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">แก้ไขข้อมูลผู้ป่วย : <?php echo $row[0]["NAME"]; ?> [<?php echo $row[0]["E0"];?>]</h4>
    </div>
    <div class="modal-body">
        <form id="EditPatient" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="E0">E0 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="E0" value="<?php echo $row[0]["E0"]; ?>" readonly>
                        <input type="hidden" name="E0" id="E0" value="<?php echo $E0; ?>">
                        <input type="hidden" name="DATESICK" id="DATESICK" value="<?php echo $DATESICK; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="E1">E1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="E1" value="<?php echo $row[0]["E1"]; ?>" readonly>
                        <input type="hidden" name="E1" id="E1" value="<?php echo $row[0]["E1"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="DISEASE">DISEASE <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="DISEASE" name="DISEASE" value="<?php echo $row[0]["DISEASE"]; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="NDIS">NDIS <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="NDIS" name="NDIS" value="<?php echo $row[0]["NDIS"]; ?>" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="NAME">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="NAME" name="NAME" value="<?php echo $row[0]["NAME"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="cid">เลขบัตรประจำตัวประชาชน</label>
                        <input type="text" class="form-control" id="cid" name="cid" value="<?php echo $row[0]["cid"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="gender">เพศ <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="ชาย" <?php if($row[0]["gender"] == "ชาย"){ echo "selected";} ?>>ชาย</option>
                            <option value="หญิง" <?php if($row[0]["gender"] == "หญิง"){ echo "selected";} ?>>หญิง</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="age">อายุ</label>
                        <input type="text" class="form-control" id="age" name="age" value="<?php echo $row[0]["age"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="OCCUPAT">เพศ <span class="text-danger">*</span></label>
                        <select class="form-control" id="OCCUPAT" name="OCCUPAT">
                        <?php foreach ($results_ocp as $row_ocp) { ?>
                            <option value="<?php echo $row_ocp["OCCUPAT"];?>" <?php if($row_ocp["OCCUPAT"] == $row[0]["OCCUPAT"]){ echo "selected";} ?>><?php echo $row_ocp["OCCUPAT"];?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="nation">สัญชาติ <span class="text-danger">*</span></label>
                        <select class="form-control" id="nation" name="nation">
                        <?php foreach ($results_nt as $row_nt) { ?>
                            <option value="<?php echo $row_nt["nation"];?>" <?php if($row_nt["nation"] == $row[0]["nation"]){ echo "selected";} ?>><?php echo $row_nt["nation"];?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="address_all">สัญชาติ <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address_all" id="address_all" cols="30" rows="3"><?php echo $row[0]["address_all"];?></textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="ADDRCODE">ADDRCODE <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ADDRCODE" name="ADDRCODE" value="<?php echo $row[0]["ADDRCODE"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="HSERV">HSERV <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="HSERV" name="HSERV" value="<?php echo $row[0]["HSERV"]; ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="DATESICK">DATESICK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="<?php echo $row[0]["DATESICK"];?>" readonly>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="DATEDEFINE">DATEDEFINE <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker_form" id="DATEDEFINE" name="DATEDEFINE" value="<?php echo $row[0]["DATEDEFINE"];?>">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="Rerx">ประเภทผู้ป่วย <span class="text-danger">*</span></label>
                        <select class="form-control" id="Rerx" name="Rerx">
                            <option value="IPD" <?php if($row[0]["Rerx"] == "IPD"){ echo "selected";} ?>>IPD</option>
                            <option value="OPD" <?php if($row[0]["Rerx"] == "OPD"){ echo "selected";} ?>>OPD</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="Typept">สถานะผู้ป่วย <span class="text-danger">*</span></label>
                        <select class="form-control" id="Typept" name="Typept">
                            <option value="ยังรักษาอยู่" <?php if($row[0]["Typept"] == "ยังรักษาอยู่"){ echo "selected";} ?>>ยังรักษาอยู่</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="PatientEditSubmit">บันทึก</button>
    </div>
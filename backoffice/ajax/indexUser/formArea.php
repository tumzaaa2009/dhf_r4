<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $level = $_POST["level"];

    $sql_code = "SELECT * FROM dhf_ampur ORDER BY AMP_CODE ASC";
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();
?>

<?php if($level == "1") { ?>
    <div class="row mt-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="dhf_admin" name="dhf_admin" value="1">
                    <label class="custom-control-label" for="dhf_admin">ตั้งเป็น Admin</label>
                </div>
            </div>
        </div>
    </div>
<?php }elseif($level == "2"){ ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="dhf_area">อำเภอ <span class="text-danger">*</span></label>
                <select class="form-control" id="dhf_area" name="dhf_area">
                    <option value="0">เลือก</option>
                    <?php foreach($results_code as $row_code){ ?> 
                        <option value="<?php echo $row_code['AMP_CODE'];?>"><?php echo $row_code['AMP_NAME'];?></option> 
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

<?php }elseif($level == "3"){ ?>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="dhf_ampur">อำเภอ <span class="text-danger">*</span></label>
                <select class="form-control" id="dhf_ampur" name="dhf_ampur" onchange="getTambonForm(this)">
                    <option value="0">เลือก</option>
                    <?php foreach($results_code as $row_code){ ?> 
                        <option value="<?php echo $row_code['AMP_CODE'];?>"><?php echo $row_code['AMP_NAME'];?></option> 
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="form-group">
                <label for="dhf_area">ตำบล <span class="text-danger">*</span></label>
                <select class="form-control" id="dhf_area" name="dhf_area" disabled>
                    <option value="0">เลือก</option>
                </select>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="text-center mt-3"><p>กรุณาเลือกระดับผู้ใช้งาน <span class="text-danger">*</span></p></div>
<?php } ?>
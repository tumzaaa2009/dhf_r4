    
<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $dhf_id = $_POST['dhf_id'];

    $sql = "SELECT u.*
    FROM dhf_user u
    WHERE u.dhf_id = '$dhf_id'";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $row = $rs->fetchAll();

    $sql_code = "SELECT * FROM dhf_ampur ORDER BY AMP_CODE ASC";
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();

    $sql_area = "SELECT * FROM dhf_tumbol WHERE AMP_CODE = '".substr($row[0]["dhf_area"],0,4)."'";
    $rs_area = $db_saraburi->prepare($sql_area);
    $rs_area->execute();
    $results_area = $rs_area->fetchAll();
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้งาน : <?php echo $row[0]["dhf_fullname"]; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form">
            <form enctype="multipart/form-data" id="form-edit">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_user">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dhf_user" name="dhf_user" placeholder="Username" value="<?php echo $row[0]["dhf_user"]; ?>" readonly>
                            <input type="hidden" id="dhf_id" name="dhf_id" value="<?php echo $dhf_id; ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_pass">Password <span class="text-danger">** กรอก เมื่อต้องการแก้ไขรหัสผ่าน</span></label>
                            <input type="password" class="form-control" id="dhf_pass" name="dhf_pass" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="dhf_fullname"> ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dhf_fullname" name="dhf_fullname" value="<?php echo $row[0]["dhf_fullname"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_phone">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="dhf_phone" name="dhf_phone" placeholder="Phone" value="<?php echo $row[0]["dhf_phone"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_email">อีเมล์</label>
                            <input type="email" class="form-control" id="dhf_email" name="dhf_email" placeholder="Email" value="<?php echo $row[0]["dhf_email"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_level">ระดับผู้ใช้งาน <span class="text-danger">*</span></label>
                            <select class="form-control" id="dhf_level" name="dhf_level" onchange="getArea(this)">
                                <option value="0" <?php if($row[0]["dhf_level"] == "0"){ echo "selected";} ?>>เลือก</option>
                                <option value="1" <?php if($row[0]["dhf_level"] == "1"){ echo "selected";} ?>>ระดับจังหวัด</option>
                                <option value="2" <?php if($row[0]["dhf_level"] == "2"){ echo "selected";} ?>>ระดับอำเภอ</option>
                                <option value="3" <?php if($row[0]["dhf_level"] == "3"){ echo "selected";} ?>>ระดับตำบล</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_status">สถานะ <span class="text-danger">*</span></label>
                            <select class="form-control" id="dhf_status" name="dhf_status">
                                <option value="1" <?php if($row[0]["dhf_status"] == "1"){ echo "selected";} ?>>ใช้งาน</option>
                                <option value="0" <?php if($row[0]["dhf_status"] == "0"){ echo "selected";} ?>>ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" id="ShowFormLevel">
                    <?php if($row[0]["dhf_level"] == "1") { ?>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="dhf_admin" name="dhf_admin" value="1" <?php if($row[0]["dhf_admin"] == "1"){ echo "checked";} ?>>
                                        <label class="custom-control-label" for="dhf_admin">ตั้งเป็น Admin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }elseif($row[0]["dhf_level"] == "2"){ ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="dhf_area">อำเภอ <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dhf_area" name="dhf_area">
                                        <option value="0">เลือก</option>
                                        <?php foreach($results_code as $row_code){ ?> 
                                            <option value="<?php echo $row_code['AMP_CODE'];?>" <?php if($row_code['AMP_CODE'] == substr($row[0]["dhf_area"],0,4)){ echo "selected";} ?>><?php echo $row_code['AMP_NAME'];?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <?php }elseif($row[0]["dhf_level"] == "3"){ ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="dhf_ampur">อำเภอ <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dhf_ampur" name="dhf_ampur" onchange="getTambonForm(this)">
                                        <option value="0">เลือก</option>
                                        <?php foreach($results_code as $row_code){ ?> 
                                            <option value="<?php echo $row_code['AMP_CODE'];?>" <?php if($row_code['AMP_CODE'] == substr($row[0]["dhf_area"],0,4)){ echo "selected";} ?>><?php echo $row_code['AMP_NAME'];?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="dhf_area">ตำบล <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dhf_area" name="dhf_area">
                                        <option value="0">เลือก</option>
                                        <?php foreach($results_area as $row_area){ ?> 
                                            <option value="<?php echo $row_area['TUM_CODE'];?>" <?php if($row_area['TUM_CODE'] == substr($row[0]["dhf_area"],0,6)){ echo "selected";} ?>><?php echo $row_area['TUM_NAME'];?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="text-center mt-3"><p>กรุณาเลือกระดับผู้ใช้งาน <span class="text-danger">*</span></p></div>
                    <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="UserEditSubmit">บันทึก</button>
    </div>
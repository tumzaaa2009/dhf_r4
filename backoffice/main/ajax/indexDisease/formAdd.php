<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $sql_code = "SELECT * FROM dhf_506 ORDER BY id_506 ASC";
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มกลุ่มโรค</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form">
            <form enctype="multipart/form-data" id="form-add">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="group_name">ชื่อกลุ่มโรค <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="group_name" name="group_name" placeholder="ชื่อกลุ่มโรค">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="id_506">รหัสโรค : 506 <span class="text-danger">*</span></label>
                            <select class="select2" id="id_506" name="id_506[]" multiple>
                                <?php foreach($results_code as $row_code){ ?> 
                                    <option value="<?php echo $row_code['id_506'];?>"><?php echo $row_code['name_thai_506']."[".$row_code['id_506']."]";?></option> 
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="DiseaseAddSubmit">บันทึก</button>
    </div>
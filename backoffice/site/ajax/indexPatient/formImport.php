<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">นำเข้าข้อมูล</h4>
    </div>
    <div class="modal-body">
        <form id="ImportFile" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <label for=""><strong> นำเข้าไฟล์ข้อมูล</strong><span class="text-danger">*</span> 
                    </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="fileImport" id="fileImport" onchange="readURL(this,value,'#blah');">
                        <label id="blah" for="fileImport" class="custom-file-label">เลือกไฟล์...</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="ImportSubmit">บันทึก</button>
    </div>
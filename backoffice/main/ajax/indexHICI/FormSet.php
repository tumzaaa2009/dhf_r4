<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $AMP_CODE_temp = $_POST["AMP_CODE_temp"];
    $year = $_POST["year"];

    $TUM_CODE_group = "";
    if(isset($_POST['TUM_CODE_group'])){
        foreach ($_POST['TUM_CODE_group'] as $key => $value) {
            $TUM_CODE_group .= "$value,";
        }
        $TUM_CODE_group = substr($TUM_CODE_group,0,-1);
    }
    if($TUM_CODE_group != ""){
        $sql_group = " AND TUM_CODE NOT IN ($TUM_CODE_group) ";
    }

    $sql = "SELECT * FROM dhf_tumbol WHERE AMP_CODE = '$AMP_CODE_temp' $sql_group ORDER BY TUM_CODE ASC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

?>
<div class="modal-header">
    <h4 class="modal-title">เลือกตำบล</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                <label for="TUM_CODE_SET">ตำบล <span class="text-danger">*</span></label>
                <select class="form-control" id="TUM_CODE_SET" name="TUM_CODE_SET">
                    <option value="0">เลือก</option>
                    <?php foreach ($results as $row) { ?>
                        <option value="<?php echo $row["TUM_CODE"];?>"><?php echo $row["TUM_NAME"];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="SetFormSubmit">ยืนยัน</button>
</div>
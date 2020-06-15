<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST['year'];

    $sql_amphur = "SELECT ap.*, (SELECT COUNT(*) FROM dhf_population_lvl3 dpl3 WHERE dpl3.year = '$year' AND ap.amp_code = dpl3.AMP_CODE) AS APMCode
    FROM dhf_ampur ap
    WHERE ap.PRO_CODE = '19'";
    $rs_amphur = $db_saraburi->query($sql_amphur);
    $rs_amphur->execute();
    $result_amphur = $rs_amphur->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มประชากรตำบลในจังหวัดสระบุรี : ปี <?php echo $year; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form enctype="multipart/form-data" id="form-add-tum">
            <div class="row border-bottom">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="ampur">เลือกอำเภอ</label>
                        <select class="form-control" id="ampur" name="ampur" onchange="LoadTumForm(this);">
                            <option value="0">โปรดเลือก</option>
                            <?php foreach ($result_amphur as $row_amphur) { ?>
                                <option value="<?php echo $row_amphur['AMP_CODE']; ?>" data-year="<?php echo $year; ?>" <?php if($row_amphur['APMCode'] > 0){ echo "style='color: #28A745;'"; }else{ echo "style='color: #DC3545;'"; } ?>>
                                <?php echo "อ." . $row_amphur['AMP_NAME']; ?> <?php if($row_amphur['APMCode'] > 0){ echo "(บันทึกแล้ว)"; }else{ echo "(ยังไม่มีการบันทึก)"; } ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="year" id="year" value="<?php echo $year; ?>">
            <div id="ShowTumTable" class="mt-3">
                <div class="text-center">- โปรดเลือกอำเภอ -</div>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="PopulationTUMAddSubmit">บันทึก</button>
    </div>
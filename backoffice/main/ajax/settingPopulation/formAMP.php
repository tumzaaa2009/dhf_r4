<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST['year'];

    $sql = "SELECT * FROM dhf_population_lvl2 WHERE year = '$year'";
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $cnt = $rs->rowCount();
    if ($cnt == 0) {
        $sql_lvl2 = "SELECT da.AMP_CODE AS ampur_code, da.AMP_NAME AS ampur_name, '0' AS population 
            FROM dhf_ampur da 
            ORDER BY da.AMP_CODE ASC";
        $rs_lvl2 = $db_saraburi->prepare($sql_lvl2);
        $rs_lvl2->execute();
        $results_lvl2 = $rs_lvl2->fetchAll();
    } else {
        $sql_lvl2 = "SELECT da.AMP_CODE AS ampur_code, da.AMP_NAME AS ampur_name, dpl2.population AS population 
        FROM dhf_ampur da 
        LEFT JOIN dhf_population_lvl2 dpl2 ON da.AMP_CODE = dpl2.amp_code
        WHERE dpl2.year = '$year' 
        ORDER BY da.AMP_CODE ASC";
        $rs_lvl2 = $db_saraburi->prepare($sql_lvl2);
        $rs_lvl2->execute();
        $results_lvl2 = $rs_lvl2->fetchAll();
    }

?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มประชากรอำเภอในจังหวัดสระบุรี : ปี <?php echo $year; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <form enctype="multipart/form-data" id="form-add-amp">
            <input type="hidden" name="year" id="year" value="<?php echo $year; ?>">
            <input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt; ?>">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTableLvl1" style="width:100%">
                    <thead class="bg-table-in-page">
                        <tr>
                            <th class="text-center p-2">รหัส</th>
                            <th class="text-center p-2">อำเภอ</th>
                            <th class="text-center p-2">จำนวนประชากร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results_lvl2 as $row) { ?>
                            <tr>
                                <td class="text-center p-2"><?php echo $row['ampur_code']; ?></td>
                                <td class="text-center p-2"><?php echo $row['ampur_name']; ?></td>
                                <td class="text-center p-2">
                                    <input type="hidden" class="form-control" id="ampur_code" name="ampur_code[]" value="<?php echo $row['ampur_code']; ?>">
                                    <input type="number" class="form-control text-right" min="0" id="population" name="population[]" value="<?php echo $row['population']; ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="PopulationAddSubmit">บันทึก</button>
    </div>
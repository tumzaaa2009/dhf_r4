<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];
    //---------------------------------------------------------------------------------------
    $sql_lvl1 = "SELECT dpl1.*
    FROM dhf_population_lvl1 dpl1 
    WHERE dpl1.year = '$year'";     
    $rs_lvl1 = $db_saraburi->prepare($sql_lvl1);
    $rs_lvl1->execute();
    $results_lvl1 = $rs_lvl1->fetchAll();
    //---------------------------------------------------------------------------------------
    $sql_lvl2 = "SELECT dpl2.*, da.AMP_NAME
    FROM dhf_population_lvl2 dpl2 
    LEFT JOIN dhf_ampur da ON da.AMP_CODE = dpl2.amp_code
    WHERE dpl2.year = '$year'";     
    $rs_lvl2 = $db_saraburi->prepare($sql_lvl2);
    $rs_lvl2->execute();
    $results_lvl2 = $rs_lvl2->fetchAll();
    //---------------------------------------------------------------------------------------
    $sql_lvl3 = "SELECT dpl3.*, da.AMP_NAME, dt.TUM_NAME
    FROM dhf_population_lvl3 dpl3 
    LEFT JOIN dhf_ampur da ON da.AMP_CODE = dpl3.amp_code
    LEFT JOIN dhf_tumbol dt ON dt.TUM_CODE = dpl3.tum_code
    WHERE dpl3.year = '$year'";     
    $rs_lvl3 = $db_saraburi->prepare($sql_lvl3);
    $rs_lvl3->execute();
    $results_lvl3 = $rs_lvl3->fetchAll();
/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดประชากรปี : <?php echo $year; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="lvl1-tab" data-toggle="tab" href="#lvl1" role="tab" aria-controls="lvl1" aria-selected="true">จังหวัด</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lvl2-tab" data-toggle="tab" href="#lvl2" role="tab" aria-controls="lvl2" aria-selected="false">อำเภอ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lvl3-tab" data-toggle="tab" href="#lvl3" role="tab" aria-controls="lvl3" aria-selected="false">ตำบล</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="lvl1" role="tabpanel" aria-labelledby="lvl1-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTableLvl1" style="width:100%">
                        <thead class="bg-table-in-page">
                            <tr>
                                <th class="text-center p-2">ปี</th>
                                <th class="text-center p-2">จังหวัด</th>
                                <th class="text-center p-2">จำนวนประชากรทั้งปี</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results_lvl1 as $row) { ?>
                                <tr id="tr_<?php echo $row['year']; ?>">
                                    <td class="text-center p-2"><?php echo $row['year']; ?></td>
                                    <td class="text-center p-2">จ.สระบุรี</td>
                                    <td class="text-center p-2"><?php echo $row['population']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="lvl2" role="tabpanel" aria-labelledby="lvl2-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTableLvl2" style="width:100%">
                        <thead class="bg-table-in-page">
                            <tr>
                                <th class="text-center p-2">ปี</th>
                                <th class="text-center p-2">อำเภอ</th>
                                <th class="text-center p-2">จำนวนประชากร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results_lvl2 as $row) { ?>
                                <tr id="tr_<?php echo $row['year']; ?>">
                                    <td class="text-center p-2"><?php echo $row['year']; ?></td>
                                    <td class="text-center p-2">อ.<?php echo $row['AMP_NAME']; ?></td>
                                    <td class="text-center p-2"><?php echo $row['population']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="lvl3" role="tabpanel" aria-labelledby="lvl3-tab">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTableLvl3" style="width:100%">
                        <thead class="bg-table-in-page">
                            <tr>
                                <th class="text-center p-2">ปี</th>
                                <th class="text-center p-2">อำเภอ</th>
                                <th class="text-center p-2">ตำบล</th>
                                <th class="text-center p-2">จำนวนประชากร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results_lvl3 as $row) { ?>
                                <tr id="tr_<?php echo $row['year']; ?>">
                                    <td class="text-center p-2"><?php echo $row['year']; ?></td>
                                    <td class="text-center p-2">อ.<?php echo $row['AMP_NAME']; ?></td>
                                    <td class="text-center p-2">ต.<?php echo $row['TUM_NAME']; ?></td>
                                    <td class="text-center p-2"><?php echo $row['population']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
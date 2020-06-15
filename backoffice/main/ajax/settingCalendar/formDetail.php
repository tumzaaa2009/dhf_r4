<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];

    $sql = "SELECT dcl2.*
    FROM dhf_calendar_lvl2 dcl2
    WHERE dcl2.year = '$year'
    ORDER BY dcl2.week ASC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดสัปดาห์</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">ปี</th>
                        <th class="text-center p-2">สัปดาห์ที่</th>
                        <th class="text-center p-2">วันที่เริ่ม</th>
                        <th class="text-center p-2">วันที่สิ้นสุด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['year']; ?>">
                            <td class="text-center p-2"><?php echo $row['year']; ?></td>
                            <td class="text-center p-2"><?php echo $row['week']; ?></td>
                            <td class="text-center p-2"><?php echo $row['start_date']; ?></td>
                            <td class="text-center p-2"><?php echo $row['end_date']; ?></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
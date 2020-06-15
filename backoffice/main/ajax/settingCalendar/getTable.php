<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];

    $sql = "SELECT dcl1.*,(SELECT MAX(dcl2.week) AS MaxWeek FROM dhf_calendar_lvl2 dcl2 WHERE dcl1.year = dcl2.year) AS MaxWeek 
    FROM dhf_calendar_lvl1 dcl1
    ORDER BY dcl1.year DESC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">ปี</th>
                        <th class="text-center p-2">ปี (พ.ศ.)</th>
                        <th class="text-center p-2">วันที่เริ่ม</th>
                        <th class="text-center p-2">วันที่สิ้นสุด</th>
                        <th class="text-center p-2">จำนวนสัปดาห์</th>
                        <th class="text-center p-2">รายละเอียด</th>
                        <th class="text-center p-2">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['year']; ?>">
                            <td class="text-center p-2"><?php echo $row['year']; ?></td>
                            <td class="text-center p-2"><?php echo $row['year_th']; ?></td>
                            <td class="text-center p-2"><?php echo $row['start_date']; ?></td>
                            <td class="text-center p-2"><?php echo $row['end_date']; ?></td>
                            <td class="text-center p-2"><?php echo $row['MaxWeek']; ?></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DetailCalendar('<?php echo $row['year']; ?>')"><i class="fas fa-info-circle text-info"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DeleteCalendar('<?php echo $row['year']; ?>')"><i class="fas fa-trash-alt text-danger"></i></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


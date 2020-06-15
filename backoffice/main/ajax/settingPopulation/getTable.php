<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $sql = "SELECT dpt1.*
    FROM dhf_population_lvl1 dpt1
    ORDER BY dpt1.year DESC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">ปี</th>
                        <th class="text-center p-2">จำนวนประชากรทั้งปี</th>
                        <th class="text-center p-2">เพิ่มประชากรอำเภอ</th>
                        <th class="text-center p-2">เพิ่มประชากรตำบล</th>
                        <th class="text-center p-2">รายละเอียด</th>
                        <th class="text-center p-2">แก้ไข</th>
                        <th class="text-center p-2">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['year']; ?>">
                            <td class="text-center p-2"><?php echo $row['year']; ?></td>
                            <td class="text-center p-2"><?php echo $row['population']; ?></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="AMPlPopulation('<?php echo $row['year']; ?>')"><i class="fas fa-users text-info"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="TUMPopulation('<?php echo $row['year']; ?>')"><i class="fas fa-users text-info"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DetailPopulation('<?php echo $row['year']; ?>')"><i class="fas fa-info-circle text-info"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="PopulationEdit('<?php echo $row['year']; ?>')"><i class="fas fa-edit text-warning"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DeletePopulation('<?php echo $row['year']; ?>')"><i class="fas fa-trash-alt text-danger"></i></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


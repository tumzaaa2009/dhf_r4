<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $sql = "SELECT g.*
    FROM dhf_group_506 g
    ORDER BY g.group_id DESC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">ลำดับ</th>
                        <th class="text-center p-2">ชื่อกลุ่มโรค</th>
                        <th class="text-center p-2">รายละเอียด</th>
                        <th class="text-center p-2">แก้ไข</th>
                        <th class="text-center p-2">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['group_id']; ?>">
                            <td class="text-center p-2"><?php echo $row['group_id']; ?></td>
                            <td class="text-center p-2"><?php echo $row['group_name']; ?></td>
                            <td class="text-center p-2">
                                <?php
                                    echo get_sql_data("SELECT GROUP_CONCAT(name_thai_506) AS cc FROM dhf_506 WHERE id_506 IN (".$row['group_id_506'].")");
                                ?>
                            </td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DiseaseEdit('<?php echo $row['group_id'];?>')"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="DiseaseDelete('<?php echo $row['group_id'];?>')"><i class="far fa-trash-alt text-danger"></i></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    $sql = "SELECT g.*
        FROM dhf_group_506 g
        ORDER BY g.group_id ASC";
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
?>
<div class="modal-header">
    <h5 class="modal-title">กรุณาเลือก กลุ่มโรค</h5>
</div>
<div class="modal-body">
    <div class="row">
        <?php foreach ($results as $row) { ?>
            <div class="col-md-6 col-sm-12">
                <button class="btn btn-primary btn-block" onclick="pick_disease('<?php echo $row['group_id']; ?>','<?php echo $row['group_name']; ?>','<?php echo $row['group_id_506']; ?>')">[<?php echo $row["group_id"]; ?>] <?php echo $row["group_name"]; ?></button>
                <div class="hr-line-dashed"></div>
            </div>
        <?php } ?>
    </div>
</div>
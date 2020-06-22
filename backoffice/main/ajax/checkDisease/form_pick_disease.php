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
    $rs = $db_r4->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
?>


  <!-- Modal Header -->
  <div class="modal-header " align="center">
          <h4 class="modal-title" >กลุ่มโรค</h4>

        </div>
<div class="modal-body">
    <div class="row">
        <?php foreach ($results as $row) { ?>
            <div class="col-md-6 col-sm-12">
                <button class="btn btn-primary " onclick="pick_disease('<?php echo $row['group_id']; ?>','<?php echo $row['group_name']; ?>','<?php echo $row['group_id_506']; ?>')">[<?php echo $row["group_id"]; ?>] <?php echo $row["group_name"]; ?></button>
                <div class="hr-line-dashed"></div>
            </div>
        <?php } ?>
    </div>
</div>



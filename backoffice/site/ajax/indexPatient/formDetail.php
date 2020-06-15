<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $E0 = $_POST["E0"];
    $DATESICK = $_POST["DATESICK"];
    //---------------------------------------------------------------------------------------
    $sql = "SELECT dp.*,LEFT(dp.ADDRCODE,2) AS CW_CODE, dfa.AMP_NAME, dft.TUM_NAME, dfm.VIL_NAME
    FROM dhf_patient dp 
    LEFT JOIN dhf_ampur dfa ON LEFT(dp.ADDRCODE,4) = dfa.AMP_CODE 
    LEFT JOIN dhf_tumbol dft ON LEFT(dp.ADDRCODE,6) = dft.TUM_CODE 
    LEFT JOIN dhf_mooban dfm ON LEFT(dp.ADDRCODE,8) = dfm.VIL_CODE 
    WHERE dp.E0 = '$E0' AND dp.DATESICK = '$DATESICK'";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $row = $rs->fetchAll();


/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">รายเอียดผู้ป่วย E0 : <?php echo $row[0]["E0"]; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <dl class="row">
            <dt class="col-sm-3">E0</dt>
            <dd class="col-sm-9"><?php echo $row[0]["E0"];?></dd>

            <dt class="col-sm-3">E1</dt>
            <dd class="col-sm-9"><?php echo $row[0]["E1"];?></dd>

            <dt class="col-sm-3">DISEASE</dt>
            <dd class="col-sm-9"><?php echo $row[0]["DISEASE"];?></dd>

            <dt class="col-sm-3">NDIS</dt>
            <dd class="col-sm-9"><?php echo $row[0]["NDIS"];?></dd>

            <dt class="col-sm-3">ชื่อ - สกุล</dt>
            <dd class="col-sm-9"><?php echo $row[0]['NAME'];?></dd>
            
            <dt class="col-sm-3">เลขบัตรประจำตัวประชาชน</dt>
            <dd class="col-sm-9"><?php echo ($row[0]['cid'] != "" ? $row[0]['cid'] : "-");?></dd>

            <dt class="col-sm-3">เพศ</dt>
            <dd class="col-sm-9">
                <?php 
                    if($row[0]['gender'] != ""){
                        echo $row[0]['gender'];
                    }else{
                        echo "ไม่ระบุ";
                    }
                ?>
            </dd>

            <dt class="col-sm-3">อายุ</dt>
            <dd class="col-sm-9"><?php echo $row[0]["age"];?></dd>

            <dt class="col-sm-3">อาชีพ</dt>
            <dd class="col-sm-9"><?php echo $row[0]["OCCUPAT"];?></dd>

            <dt class="col-sm-3">สัญชาติ</dt>
            <dd class="col-sm-9"><?php echo $row[0]["nation"];?></dd>

            <dt class="col-sm-3">บ้านเลขที่</dt>
            <dd class="col-sm-9"><?php echo $row[0]['ADDRESS'];?></dd>

            <dt class="col-sm-3">หมู่บ้าน</dt>
            <dd class="col-sm-9"><?php echo $row[0]['VIL_NAME'];?></dd>

            <dt class="col-sm-3">ตำบล</dt>
            <dd class="col-sm-9"><?php echo $row[0]["TUM_NAME"];?></dd>

            <dt class="col-sm-3">อำเภอ</dt>
            <dd class="col-sm-9"><?php echo $row[0]["AMP_NAME"];?></dd>

            <dt class="col-sm-3">จังหวัด</dt>
            <dd class="col-sm-9"><?php if($row[0]["CW_CODE"] == "19"){ echo $row[0]["CW_CODE"]; }else{ echo "จังหวัดอื่นๆ"; }?></dd>

            <dt class="col-sm-3">ที่อยู่</dt>
            <dd class="col-sm-9"><?php echo $row[0]['address_all'];?></dd>

            <dt class="col-sm-3">วันที่ป่วย</dt>
            <dd class="col-sm-9"><?php echo date("d/m/Y", strtotime($row[0]['DATESICK']));?></dd>

            <dt class="col-sm-3">วันที่วินิจฉัย</dt>
            <dd class="col-sm-9"><?php echo date("d/m/Y", strtotime($row[0]['DATEDEFINE']));?></dd>

            <dt class="col-sm-3">ประเภทผู้ป่วย</dt>
            <dd class="col-sm-9"><?php echo $row[0]['Typept'];?></dd>

            <dt class="col-sm-3">สถานะผู้ป่วย</dt>
            <dd class="col-sm-9"><?php echo $row[0]['Rerx'];?></dd>
        </dl>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
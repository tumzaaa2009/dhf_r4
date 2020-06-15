<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $lat = 14.65;
    $lon = 100.91667;
    $r = 0;

    $E0 = $_POST["E0"];

    $sql = "SELECT dp.*
    FROM dhf_patient dp
    WHERE dp.E0 = '$E0'";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $row = $rs->fetchAll();

    if($row[0]["lat"] == "" || $row[0]["lon"] == "" || $row[0]["lat"] == "0" || $row[0]["lon"] == "0"){
        $Latitude = $lat;
        $Longitude = $lon;
    }else{
        $Latitude = $row[0]["lat"];
        $Longitude = $row[0]["lon"];
    }

    if($row[0]["radius"] == "" || $row[0]["radius"] == "0"){
        $radius = $r;
    }else{
        $radius = $row[0]["radius"];
    }

/* -------------------------------------------------------------------------------------- */
?>
    <div class="modal-header">
        <h4 class="modal-title">กำหนดจุดพิกัดที่อยู่ผู้ป่วย : <?php echo $row[0]["NAME"]; ?> [<?php echo $row[0]["E0"];?>]</h4>
    </div>
    <div class="modal-body">
        <form id="MapManage" method="post" enctype="multipart/form-data">
            <input type="hidden" name="E0" id="E0" value="<?php echo $E0; ?>">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="lat">Latitude <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="<?php echo $Latitude; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="lon">Longitude <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lon" name="lon" placeholder="Longitude" value="<?php echo $Longitude; ?>">
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="form-group">
                        <label for="radius">รัศมีวงกลม <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="radius" name="radius" placeholder="Radius" value="<?php echo $radius; ?>">
                    </div>
                </div>  
                <div class="col-md-12 col-xs-12">
                    <div id="map" class="wow fadeIn"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" id="MapSubmit">บันทึก</button>
    </div>
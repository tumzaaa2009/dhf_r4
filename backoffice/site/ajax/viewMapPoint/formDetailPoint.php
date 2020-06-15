<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
    $j = 1;
    if(isset($_POST['ampur'])){
        foreach($_POST['ampur'] as $key => $value) {
            if($j == "1"){
                $ampur = $value;
            }else{
                $ampur = $ampur.",".$value;
            }
            $j++;
        }
    }
    if($ampur != ""){
        $sql_ampur = " AND da.AMP_CODE IN ($ampur) ";
    }

    $sql = "SELECT da.AMP_CODE,da.AMP_NAME
    ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND df.DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
    ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND df.DATESICK BETWEEN '$date_start' AND '$date_end' AND df.lat IS NOT NULL AND  df.lon IS NOT NULL) AS CountPoint
    FROM dhf_ampur da
    WHERE 1 $sql_ampur
    ORDER BY CountPatient DESC";
    
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();
    $i = 1;
    $SumPatient = 0;
    $SumPoint = 0;
?>
    <div class="modal-header">
        <h5 class="modal-title">รายละเอียดการลงพิกัด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="TablePoint" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ลำดับ</th>
                        <th class="text-center">อำเภอ</th>
                        <th class="text-center" style="width: 125px;">จำนวนผู้ป่วย</th>
                        <th class="text-center" style="width: 125px;">ลงพิกัดแล้ว</th>
                        <th class="text-center" style="width: 125px;">ร้อยละ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($results as $row) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i; ?></td>
                            <td class="text-left"><?php echo "อ.".$row["AMP_NAME"]; ?></td>
                            <td class="text-center"><?php echo number_format($row["CountPatient"]); $SumPatient = $SumPatient + $row["CountPatient"]; ?></td>
                            <td class="text-center"><?php echo number_format($row['CountPoint']); $SumPoint = $SumPoint + $row["CountPoint"]; ?></td>
                            <td class="text-center"><?php echo ($row["CountPoint"] != 0 && $row["CountPatient"] != 0 ? number_format(($row["CountPoint"]/$row["CountPatient"])*100,2) : "0.00"); ?></td>
                        </tr>
                    <?php $i++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="2"> รวม </td>
                        <td class="text-center"><? echo number_format($SumPatient);?></td>
                        <td class="text-center"><? echo number_format($SumPoint);?></td>
                        <td class="text-center"><? echo ($SumPoint != 0 && $SumPatient != 0 ? number_format(($SumPoint/$SumPatient)*100,2) : "0.00");?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
    </div>
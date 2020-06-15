<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $authorization = $_SESSION['JWT_Dengue_Fever'];
    $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');

    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
    $ampur = $_POST["ampur"];

    if($ampur != 0){
        $sql = "SELECT da.AMP_CODE,da.AMP_NAME,dt.TUM_NAME,dpl3.population AS Population
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND dt.TUM_CODE = LEFT(df.ADDRCODE,6) AND DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
        ,((SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND dt.TUM_CODE = LEFT(df.ADDRCODE,6) AND DATESICK BETWEEN '$date_start' AND '$date_end')*100000)/dpl3.population AS CountPatientPop
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND dt.TUM_CODE = LEFT(df.ADDRCODE,6) AND DATESICK BETWEEN '$date_start' AND '$date_end' AND Rerx = 'ตาย') AS CountDie
        FROM dhf_tumbol dt 
        INNER JOIN dhf_ampur da ON dt.AMP_CODE = da.AMP_CODE
        INNER JOIN dhf_population_lvl3 dpl3 ON dpl3.tum_code = dt.TUM_CODE
        WHERE dt.AMP_CODE = '$ampur'
        ORDER BY CountPatientPop DESC";
    }else{
        $sql = "SELECT da.AMP_CODE,da.AMP_NAME,dpl2.population AS Population
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '$date_start' AND '$date_end') AS CountPatient
        ,((SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '$date_start' AND '$date_end')*100000)/dpl2.population AS CountPatientPop
        ,(SELECT COUNT(df.E0) AS CountPatient FROM dhf_patient df WHERE df.DISEASE IN ($id_506) AND da.AMP_CODE = LEFT(df.ADDRCODE,4) AND DATESICK BETWEEN '$date_start' AND '$date_end' AND Rerx = 'ตาย') AS CountDie
        FROM dhf_ampur da 
        INNER JOIN dhf_population_lvl2 dpl2 ON dpl2.amp_code = da.AMP_CODE
        ORDER BY CountPatientPop DESC";
    }

    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $results = $rs->fetchAll();

    $i = 1;
?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">ลำดับ</th>
                    <th class="text-center">อำเภอ</th>
                    <?php if($ampur != 0) { ?>
                        <th class="text-center">ตำบล</th>
                    <?php } ?>
                    <th class="text-center" style="width: 100px;">จำนวนผู้ป่วย</th>
                    <th class="text-center" style="width: 100px;">อัตราต่อแสนประชากรผู้ป่วย</th>
                    <th class="text-center" style="width: 100px;">จำนวนผู้ป่วยเสียชีวิต</th>
                    <th class="text-center" style="width: 150px;">อัตราต่อแสนประชากรผู้ป่วยเสียชีวิต</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $row) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td class="text-left"><?php echo "อ.".$row["AMP_NAME"]; ?></td>
                        <?php if($ampur != 0) { ?>
                            <td class="text-left"><?php echo "ต.".$row["TUM_NAME"]; ?></td>
                        <?php } ?>
                        <td class="text-center"><?php echo number_format($row["CountPatient"]); ?></td>
                        <td class="text-center"><?php echo number_format(($row['CountPatient']*100000)/$row['Population'],2); ?></td>
                        <td class="text-center"><?php echo number_format($row["CountDie"]); ?></td>
                        <td class="text-center"><?php echo number_format(($row['CountDie']*100000)/$row['Population'],2); ?></td>
                    </tr>
                <?php $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
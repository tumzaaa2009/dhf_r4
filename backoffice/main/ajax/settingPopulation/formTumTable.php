<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST['year'];
    $AMP_CODE = $_POST['AMP_CODE'];

    $sql = "SELECT * FROM dhf_population_lvl3 WHERE year = '$year' AND amp_code = '$AMP_CODE'";
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $cnt = $rs->rowCount();
    
    if ($cnt == 0) {
        $sql_lvl3 = "SELECT tb.TUM_CODE AS tumbol_code, tb.TUM_NAME AS tumbol_name, '0' AS population 
                FROM dhf_tumbol tb
                WHERE tb.AMP_CODE = '$AMP_CODE'
                ORDER BY tb.TUM_CODE ASC";
        $rs_lvl3 = $db_saraburi->prepare($sql_lvl3);
        $rs_lvl3->execute();
        $results_lvl3 = $rs_lvl3->fetchAll();
    } else {
        $sql_lvl3 = "SELECT tb.TUM_CODE AS tumbol_code, tb.TUM_NAME AS tumbol_name, dpl3.population AS population 
            FROM dhf_tumbol tb 
            LEFT JOIN dhf_population_lvl3 dpl3 ON tb.TUM_CODE = dpl3.tum_code
            WHERE dpl3.year = '$year' AND dpl3.amp_code = '$AMP_CODE'
            ORDER BY tb.TUM_CODE ASC";
        $rs_lvl3 = $db_saraburi->prepare($sql_lvl3);
        $rs_lvl3->execute();
        $results_lvl3 = $rs_lvl3->fetchAll();
    }

?>

<input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt; ?>">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" style="width:100%">
        <thead class="bg-table-in-page">
            <tr>
                <th class="text-center p-2">รหัส</th>
                <th class="text-center p-2">ตำบล</th>
                <th class="text-center p-2">จำนวนประชากร</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results_lvl3 as $row) { ?>
                <tr>
                    <td class="text-center p-2"><?php echo $row['tumbol_code']; ?></td>
                    <td class="text-center p-2"><?php echo $row['tumbol_name']; ?></td>
                    <td class="text-center p-2">
                        <input type="hidden" class="form-control" id="tumbol_code" name="tumbol_code[]" value="<?php echo $row['tumbol_code']; ?>">
                        <input type="number" class="form-control text-right" min="0" id="population" name="population[]" value="<?php echo $row['population']; ?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
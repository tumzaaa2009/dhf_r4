<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $year = $_POST["year"];
    $month = $_POST["month"];
    $ampur = $_POST["ampur"];
    //---------------------------------------------------------------------------------------
    $sql_ampur_name = "SELECT AMP_NAME AS result FROM dhf_ampur WHERE AMP_CODE = '$ampur'";
    $ampur_name = GetSqlData($sql_ampur_name);

    $sql_ampur_count = "SELECT COUNT(*) AS result FROM dhf_tumbol WHERE AMP_CODE = '$ampur'";
    $ampur_count = GetSqlData($sql_ampur_count);
    //---------------------------------------------------------------------------------------
    $sql = "SELECT dhici.*, dtb.TUM_NAME
        FROM dhf_hi_ci dhici 
        LEFT JOIN dhf_tumbol dtb ON dtb.TUM_CODE = dhici.TUM_CODE
        WHERE dhici.year = '$year' AND dhici.month = '$month' AND dhici.AMP_CODE = '$ampur'
        ORDER BY list_order ASC";

    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    $cmt_ampur = $rs->rowCount();
    $results = $rs->fetchAll();
    $i = 1;
/* -------------------------------------------------------------------------------------- */
?>

    <div class="col-sm-12">
        <div class="text-center">
            <?php if ($ampur_count == $cmt_ampur) { ?>
                <p>จำนวนตำบลที่ลง HI CI <span class="text-success font-weight-bold"><?php echo $cmt_ampur; ?></span> ตำบล จากทั้งหมด <?php echo $ampur_count; ?> ตำบล</p>
            <?php } else { ?>
                <p>จำนวนตำบลที่ลง HI CI <span class="text-danger font-weight-bold"><?php echo $cmt_ampur; ?></span> ตำบล จากทั้งหมด <?php echo $ampur_count; ?> ตำบล</p>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-12 table-responsive">
        <table class="table table-hover" id="table_report" style="width: 1500px;">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">ลบ</th>
                    <th class="text-center" rowspan="2" style="width: 150px;">ตำบล</th>
                    <th class="text-center" rowspan="2" style="width: 135px;">วันที่ดำเนินการ</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจบ้าน/ชุมชน</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจศาสนสถาน</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจโรงเรียน</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจโรงพยาบาล</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจโรงแรม</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจโรงงาน</th>
                    <th class="text-center" colspan="2" style="width: 100px;">การสำรวจสถานที่ราชการ</th>
                </tr>
                <tr>
                    <th class="text-center">จำนวนบ้านที่สำรวจ</th>
                    <th class="text-center">จำนวนบ้านที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                    <th class="text-center">จำนวนภาชนะที่สำรวจ</th>
                    <th class="text-center">จำนวนภาชนะที่พบลูกน้ำ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) { ?>
                    <tr id="report_<?php echo $i; ?>">
                        <td class="text-center p-2"><button type="button" class="btn btn-danger" name="button" onclick="DeleteHTML('<?php echo $i; ?>')"> <i class="fas fa-close"></i></button></td>
                        <td class="p-2"><?php echo "ต.".$row['TUM_NAME']; ?></td>
                        <td class="text-center p-2">
                            <input type="hidden" id="year_<?php echo $i; ?>" name="year[]" value="<?php echo $row['year']; ?>">
                            <input type="hidden" id="month_<?php echo $i; ?>" name="month[]" value="<?php echo $row['month']; ?>">
                            <input type="hidden" id="AMP_CODE_<?php echo $i; ?>" name="AMP_CODE[]" value="<?php echo $row['AMP_CODE']; ?>">
                            <input type="hidden" id="TUM_CODE_<?php echo $i; ?>" name="TUM_CODE[]" value="<?php echo $row['TUM_CODE']; ?>">
                            <input type="text" class="form-control datepicker" id="date_in_month_<?php echo $i; ?>" name="date_in_month[]" value="<?php echo $row['date_in_month']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="hi_survey_<?php echo $i; ?>" name="hi_survey[]" value="<?php echo $row['hi_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="hi_find_<?php echo $i; ?>" name="hi_find[]" value="<?php echo $row['hi_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_religion_survey_<?php echo $i; ?>" name="ci_religion_survey[]" value="<?php echo $row['ci_religion_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_religion_find_<?php echo $i; ?>" name="ci_religion_find[]" value="<?php echo $row['ci_religion_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_school_survey_<?php echo $i; ?>" name="ci_school_survey[]" value="<?php echo $row['ci_school_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_school_find_<?php echo $i; ?>" name="ci_school_find[]" value="<?php echo $row['ci_school_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_hospital_survey_<?php echo $i; ?>" name="ci_hospital_survey[]" value="<?php echo $row['ci_hospital_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_hospital_find_<?php echo $i; ?>" name="ci_hospital_find[]" value="<?php echo $row['ci_hospital_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_hotel_survey_<?php echo $i; ?>" name="ci_hotel_survey[]" value="<?php echo $row['ci_hotel_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_hotel_find_<?php echo $i; ?>" name="ci_hotel_find[]" value="<?php echo $row['ci_hotel_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_factory_survey_<?php echo $i; ?>" name="ci_factory_survey[]" value="<?php echo $row['ci_factory_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_factory_find_<?php echo $i; ?>" name="ci_factory_find[]" value="<?php echo $row['ci_factory_find']; ?>">
                        </td>

                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_official_survey_<?php echo $i; ?>" name="ci_official_survey[]" value="<?php echo $row['ci_official_survey']; ?>">
                        </td>
                        <td class="text-center p-2">
                            <input type="text" class="form-control" id="ci_official_find_<?php echo $i; ?>" name="ci_official_find[]" value="<?php echo $row['ci_official_find']; ?>">
                        </td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 text-center mt-2">
        <input type="text" id="count_report" value="<?php echo $i; ?>" hidden>
        <button type="button" class="btn btn-sm btn-primary" name="button" onclick="SetAddRowReport();"> <i class="fa fa-plus"></i> เพิ่มข้อมูลตำบล </button>
    </div>
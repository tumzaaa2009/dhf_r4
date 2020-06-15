<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $i = $_POST['param'];
    $year_temp = $_POST['year_temp'];
    $month_temp = $_POST['month_temp'];
    $AMP_CODE_temp = $_POST['AMP_CODE_temp'];
    $TUM_CODE_SET = $_POST['TUM_CODE_SET'];

    $sql_tum_name = "SELECT TUM_NAME AS result FROM dhf_tumbol WHERE TUM_CODE = '$TUM_CODE_SET'";
    $tum_name = GetSqlData($sql_tum_name);
?>
<tr id="report_<?php echo $i; ?>">
    <td class="text-center p-2"><button type="button" class="btn btn-danger" name="button" onclick="DeleteHTML('<?php echo $i; ?>')"> <i class="fas fa-close"></i></button></td>
    <td class="p-2"><?php echo  "ต.".$tum_name; ?></td>
    <td class="text-center p-2">
        <input type="hidden" id="year_<?php echo $i; ?>" name="year[]" value="<?php echo $year_temp; ?>">
        <input type="hidden" id="month_<?php echo $i; ?>" name="month[]" value="<?php echo $month_temp; ?>">
        <input type="hidden" id="AMP_CODE_<?php echo $i; ?>" name="AMP_CODE[]" value="<?php echo $AMP_CODE_temp; ?>">
        <input type="hidden" id="TUM_CODE_<?php echo $i; ?>" name="TUM_CODE[]" value="<?php echo $TUM_CODE_SET; ?>">
        <input type="text" class="form-control datepicker" id="date_in_month_<?php $i; ?>" name="date_in_month[]" value="<?php echo date("Y-m-d", strtotime("$year_temp-$month_temp-01")); ?>">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="hi_survey_<?php echo $i; ?>" name="hi_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="hi_find_<?php echo $i; ?>" name="hi_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_religion_survey_<?php echo $i; ?>" name="ci_religion_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_religion_find_<?php echo $i; ?>" name="ci_religion_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_school_survey_<?php echo $i; ?>" name="ci_school_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_school_find_<?php echo $i; ?>" name="ci_school_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_hospital_survey_<?php echo $i; ?>" name="ci_hospital_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_hospital_find_<?php echo $i; ?>" name="ci_hospital_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_hotel_survey_<?php echo $i; ?>" name="ci_hotel_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_hotel_find_<?php echo $i; ?>" name="ci_hotel_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_factory_survey_<?php echo $i; ?>" name="ci_factory_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_factory_find_<?php echo $i; ?>" name="ci_factory_find[]" value="0">
    </td>

    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_official_survey_<?php echo $i; ?>" name="ci_official_survey[]" value="0">
    </td>
    <td class="text-center p-2">
        <input type="text" class="form-control" id="ci_official_find_<?php echo $i; ?>" name="ci_official_find[]" value="0">
    </td>
</tr>
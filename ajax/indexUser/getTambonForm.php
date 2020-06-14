<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $amphur = $_POST["amphur"];

    $sql_code = "SELECT * FROM dhf_tumbol WHERE AMP_CODE = '$amphur'";
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();
?>
        <option value="0">เลือก</option>
		<?php foreach($results_code as $row_code){ ?> 
			<option value="<?php echo $row_code['TUM_CODE'];?>"><?php echo $row_code['TUM_NAME'];?></option> 
		<?php } ?>
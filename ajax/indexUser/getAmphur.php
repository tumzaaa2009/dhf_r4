<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $sql_code = "SELECT * FROM dhf_ampur ORDER BY AMP_CODE ASC";
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();
?>
    <option value="0">ทั้งหมด</option>
	<?php foreach($results_code as $row_code){ ?> 
		<option value="<?php echo $row_code['AMP_CODE'];?>"><?php echo $row_code['AMP_NAME'];?></option> 
	<?php } ?>
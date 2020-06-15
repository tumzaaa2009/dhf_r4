<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $changwat = $_POST["changwat"];
    $amphur = $_POST["amphur"];
    $tumbon = $_POST["tumbon"];

    $sql_code = "SELECT * FROM cvillage_all WHERE changwatcode = '$changwat' AND ampurcode = '$changwat"."$amphur' AND tamboncode = '$changwat"."$amphur"."$tumbon'";
    echo $sql_code;
    $rs_code = $db_saraburi->prepare($sql_code);
    $rs_code->execute();
    $results_code = $rs_code->fetchAll();
?>
        <option value="0">- - - เลือก - - -</option>
		<?php foreach($results_code as $row_code){ ?> 
			<option value="<?php echo $row_code['villagecode'];?>"><?php echo $row_code['villagename'];?></option> 
		<?php } ?>
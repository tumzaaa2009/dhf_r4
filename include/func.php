<?php 
function stringInsert($str,$insertstr,$pos){
    $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
    return $str;
}  
//random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function ReturnUrl($request_uri) {
    $arr = array();
    $uri = $request_uri;
    $arr = explode("/", $uri);
    $url = $arr[0]."/".$arr[1];	
    return $url;
}


//encode user
function enc_create_u($fuser){ //enc u
$enc_u=strrev(strtoupper(md5(md5($fuser))));
return $enc_u;
}
//encode pwd
function enc_create_p($fpwd){ //enc p
$enc_p=strrev(strtoupper(md5(md5($fpwd))));
return $enc_p;
}
//end encode

//format for date 2005-09-10 to 10-09-2548
function FormatDate($date) {
    $data = explode("-", $date);
	$newdata=($data[2]."-".$data[1]."-".($data[0]+543));
    return $newdata;
}//end

//format for date  to 10-09-2548 to 2005-09-10
function FormatDate2($date) {
    $data = explode("-", $date);
	$newdata=(($data[2]-543)."-".$data[1]."-".$data[0]);
    return $newdata;
}//end
//format for date  to 2014-01-01  to 01/01/2557
function ConvertDate($date) {
	if($date==''){$newdata="";}else{
    $data = explode("-", $date);
	$newdata=substr($data[2],0,2)."/".$data[1]."/".($data[0]+543);
	}
    return $newdata;
}//end

//check ipaddress
function get_ip(){
$ip=$_SERVER['REMOTE_ADDR'];
//$ip = $HTTP_SERVER_VARS['REMOTE_ADDR']; 
 /*   if (getenv(HTTP_X_FORWARDED_FOR)){ 
        $ip_add=getenv(HTTP_X_FORWARDED_FOR); 
    }else{ 
     $ip_add=getenv(REMOTE_ADDR); 
   }
   */
return $ip;
}//end

//change 2005-10-11 to 11 ตุลาคม 2548
	function dateThai($date){
	$_month_name=array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
	$yy=substr($date,0,4); $mm=substr($date,5,2); $dd=substr($date,8,2); $time=substr($date,11,8);
	$yy+=543;
	if (intval($dd)==0){$dd="";}else{$dd=intval($dd);}
	$dateT=$dd." ".$_month_name[$mm]." ".$yy." ".$time;
	return $dateT;
}//end


function show_list($rstext){
$rsshow=explode(",",$rstext);
return $rsshow;
}//end

//end risk typelist2
function DateDiff($strDate1,$strDate2)
{
return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}

function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}

function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}



function FormatThaiDate($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		if ($strHour>0) 
		return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		else
		return "$strDay $strMonthThai $strYear";
	}



function DateThaiShort($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		if ($strHour>0) 
		return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
		else
		return "$strDay $strMonthThai $strYear";
	}

function colorlist()
{
    echo"<option class='b0' value=''>ไม่มีสี</option>";
    echo"<option class='b3' value='เขียว'>เขียว</option>";
    echo"<option class='b2' value='เหลือง'>เหลือง</option>";
    echo"<option class='b1' value='แดง'>แดง</option>";

}

function colorValue($rs) {
			$color="";
				if($rs=='แดง'){$color=' class="b1" ';	}else
				if($rs=='เหลือง'){$color=' class="b2" ';	}else
				if($rs=='เขียว'){	$color=' class="b3" ';}else
				if($rs=='ฟ้า'){$color=' class="b4"';}
return $color;
}


function monthlist()
{
    echo"<option value='01'>มกราคม</option>";
    echo"<option value='02'>กุมภาพันธ์</option>";
    echo"<option value='03'>มีนาคม</option>";
    echo"<option value='04'>เมษายน</option>";
    echo"<option value='05'>พฤษภาคม</option>";
    echo"<option value='06'>มิถุนายน</option>";
    echo"<option value='07'>กรกฎาคม</option>";
    echo"<option value='08'>สิงหาคม</option>";
    echo"<option value='09'>กันยายน</option>";
    echo"<option value='10'>ตุลาคม</option>";
    echo"<option value='11'>พฤศจิกายน</option>";
    echo"<option value='12'>ธันวาคม</option>";
	}

	function cutDistrict($district){
		if(strpos($district,"ตำบล") == true){
			$text = strstr($district,"ตำบล",true);
		}else{ 
			$text = $district;
		}
		return $text;
	}


function DateThaiShortNotime($strDate){
	if($strDate !='' && substr($strDate,0,10) !='0000-00-00'){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
}

/*--------------------------------------------------------------------------------------------------------------*/
function get_Gender($codeGender){
	if($codeGender == "M"){
		$gender = "ชาย";
	} elseif ($codeGender == "F"){
		$gender = "หญิง";
	} else {
		$gender = "ไม่ระบุ";
	}
	return $gender;
}
function get_Status($codeStatus){
	if($codeStatus == "01"){
		$status = "รักษา";
	} elseif ($codeStatus == "02"){
		$status = "หาย";
	} elseif ($codeStatus == "03"){
		$status = "เสียชีวิต";
	} else {
		$status = "ไม่ระบุ";
	}
	return $status;
}
function get_Timeing($codeTimeing){
	if($codeTimeing == "01"){
		$timeing = "7 วัน";
	} elseif ($codeTimeing == "02"){
		$timeing = "28 วัน";
	} elseif ($codeTimeing == "03"){
		$timeing = "1 เดือน";
	} else {
		$timeing = "ไม่ระบุ";
	}
	return $timeing;
}
function get_Diagnose($codeDiagnose){
	if($codeDiagnose == "01"){
		$diagnose = "IGM";
	} elseif ($codeDiagnose == "02"){
		$diagnose = "PCR";
	} elseif ($codeDiagnose == "03"){
		$diagnose = "การสอบสวน";
	} elseif ($codeDiagnose == "04"){
		$diagnose = "วินิจฉัยโดยแพทย์";
	} else {
		$diagnose = "ไม่ระบุ";
	}
	return $diagnose;
}
function get_Nation($codeNation){
	global $db_saraburi;
	$result = $db_saraburi->prepare("SELECT nationname_thai FROM cnation_aec WHERE nationgroup_aec='$codeNation'");
	$result->execute();
	$rs_name = $result->fetchAll(PDO::FETCH_ASSOC);
	$rs_name_return = $rs_name[0]["nationname_thai"];
	return $rs_name_return;
}
function get_Address($codeAddress){
	global $db_saraburi;
	$result_ampur = $db_saraburi->prepare("SELECT ampurname FROM campur WHERE changwatcode = '19' AND ampurcodefull = LEFT('$codeAddress',4)");
	$result_ampur->execute();
	$rs_ampur = $result_ampur->fetchAll(PDO::FETCH_ASSOC);
	$rs_ampur_name = $rs_ampur[0]["ampurname"];

	$result_tambon = $db_saraburi->prepare("SELECT tambonname FROM ctambon WHERE changwatcode = '19' AND tamboncodefull = LEFT('$codeAddress',6)");
	$result_tambon->execute();
	$rs_tambon = $result_tambon->fetchAll(PDO::FETCH_ASSOC);
	$rs_tambon_name = $rs_tambon[0]["tambonname"];

	$result_village = $db_saraburi->prepare("SELECT villagename FROM cvillage WHERE changwatcode = '19' AND villagecodefull = '$codeAddress'");
	$result_village->execute();
	$rs_village = $result_village->fetchAll(PDO::FETCH_ASSOC);
	$rs_village_name = $rs_village[0]["villagename"];

	return "บ.".$rs_village_name."  ต.".$rs_tambon_name."  อ.".$rs_ampur_name;
}
$dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
$monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
$monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
    global $dayTH,$monthTH;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    $thai_date_return.= " เวลา ".date("H:i:s",$time);
    return $thai_date_return;   
} 
function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
    global $dayTH,$monthTH_brev;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    $thai_date_return.= " ".date("H:i:s",$time);
    return $thai_date_return;   
} 
function thai_date_short($time){   // 19  ธ.ค. 2556a
    global $dayTH,$monthTH_brev;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    return $thai_date_return;   
} 
function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
    global $dayTH,$monthTH;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    return $thai_date_return;   
} 
function thai_date_short_number($time){   // 19-12-56
    global $dayTH,$monthTH;   
    $thai_date_return = date("d",$time);   
    $thai_date_return.="-".date("m",$time);   
    $thai_date_return.= "-".substr((date("Y",$time)+543),-2);   
    return $thai_date_return;   
} 
function get_sql_data($fsql){
	include("connect.php");
	$fresult = $db_saraburi->prepare($fsql);
	$fresult->execute();
	$frs = $fresult->fetchAll();
	return $frs[0]['cc'];

}
/*-------------------------------------*/
function GetSqlData($sql){
	include("connect.php");
	$rs = $db_saraburi->prepare($sql);
	$rs->execute();
	$row = $rs->fetchAll();
	return $row[0]['result'];
}
?>

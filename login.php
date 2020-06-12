<?php
session_start();
include("include/connect.php");
date_default_timezone_set("Asia/Bangkok");
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <!-- LOGN -->
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<!--===============================================================================================-->


        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS File -->
        <link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
         <!-- DataTables CSS -->
        <link href="assets/lib/datatables-plugins/integration/bootstrap/4/responsive.bootstrap4.min.css" rel="stylesheet">
        <link href="assets/lib/datatables-plugins/integration/bootstrap/4/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- toastr CSS -->
        <link href="assets/lib/toastr/build/toastr.min.css" rel="stylesheet">
        <!-- confirm -->
        <link rel="stylesheet" href="assets/lib/confirm/jquery-confirm.min.css">

        <!-- Libraries CSS Files -->
        <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
        <link href="assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="assets/stylesheet" href="assets/lib/fontawesome/css/all.min.css">
        <link href="assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
        <link href="assets/lib/magnific-popup/magnific-popup.css" rel="stylesheet">


</head>
<body >
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic ">
					<!-- หมุนติวๆ -->
				<!-- <div class="login100-pic js-tilt" data-tilt> --> 
					<img src="assets/images/bg-01.png" alt="IMG">
				</div>

				<div class="form">
                            <form method="post" role="form" class="contactForm">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="user" id="user" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" onclick="sendlogin()">Login</button>
					</div>

					<div class="text-center p-t-12">
						<!-- <span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a> -->
					</div>

					 <div class="text-center p-t-136">
						<!-- <a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a> -->
					</div> 
				</form>
</div>
			</div>
		</div>
	</div>
	
	
<!--=================================== JavaScript Libraries ====================================================-->	
	
	<script src="assets/lib/jquery/jquery-3.3.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/tilt/tilt.jquery.min.js"></script>
<!--===============================================================================================-->
		<script src="assets/lib/jquery/jquery-migrate.min.js"></script>
<!--===============================================================================================-->		
        <script src="assets/lib/popper.js/dist/umd/popper.min.js"></script>
<!--===============================================================================================-->
		<script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--===============================================================================================-->
		<script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->		
		<script src="assets/lib/easing/easing.min.js"></script>
<!--===============================================================================================-->		
		<script src="assets/lib/wow/wow.min.js"></script>
<!--===============================================================================================-->		
		<script src="assets/lib/superfish/hoverIntent.js"></script>
<!--===============================================================================================-->		
		<script src="assets/lib/superfish/superfish.min.js"></script>
<!--===============================================================================================-->		
        <script src="assets/lib/magnific-popup/magnific-popup.min.js"></script>
<!--===============================================================================================-->


   
        <!--toastr JavaScript -->
        <script src="assets/lib/toastr/build/toastr.min.js"></script>
        <!-- confirm -->
        <script src="assets/lib/confirm/jquery-confirm.min.js"></script>

 




	
<script>
$(document).ready(function () {
    toastr.options = {
        "closeButton": false,
        "debug": true,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
	

});
function sendlogin(){
	var user = $("#user").val();
        var pass = $("#pass").val();

        console.log(user);
        $.ajax({
            type: "POST",
            url: "login_check.php",
            data: {user:user, pass:pass},
            success: function (response) {
                //window.alert(response);
                if(response=='yes'){
					toastr.success('รหัสผ่านถูก้อง');
                    // window.location.assign("index.php");
                } else if(response=='empty') {
                    toastr.info('กรุณา! กรอก Username และ Password');
                } else if(response=='fail') {
                    toastr.warning('Username หรือ Password ไม่ถูกต้อง');
                } else if(response=='suspen'){
                    toastr.error('ถูกระงับการใช้งาน! Admin : จังหวัดสระบุรี');
                } else if(response=='error_update'){
                    toastr.error('เกิดข้อผิดพลาด! error(01)');
                } else if(response=='error_insert'){
                    toastr.error('เกิดข้อผิดพลาด! error(02)');
                }else {
                    toastr.error('เกิดข้อผิดพลาด! กรุณาลองใหม่อีกครั้ง');
                } 
            }
        });
        
    }



</script>


</body>
</html>
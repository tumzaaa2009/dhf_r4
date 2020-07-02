<!DOCTYPE html>
<html lang="en">
<head>
	<title>โรคติดต่อเขตสุขภาพที่ 4</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->



        <!-- Favicon -->
        <!-- <link rel="shortcut icon" href="../assets/media/image/favicon.png"/> -->

        <!-- Plugin styles -->
        <link rel="stylesheet" href="../vendors/bundle.css" type="text/css">

        <!-- App styles -->
        <link rel="stylesheet" href="../assets/css/app.min.css" type="text/css">

</head>
<body >
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic ">
					<!-- หมุนติวๆ -->
				<!-- <div class="login100-pic js-tilt" data-tilt> --> 
					<img src="../images/bg-01.png" alt="IMG">
				</div>

				<form >
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text"  placeholder="Username" id="user" name="user" autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password"  placeholder="Password" id="pass" name="pass" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button   type="button"  onclick="CheckLogin();" class="login100-form-btn">
							Login
						</button>
					</div>
					<div class="container-login100-form-btn">
				
					<button   type="button" id="freelogin"  value="User" onclick="user_sigin()"  class="login100-form-btn btn-primary">
							<h4 class="mt-2">เข้าสู่หน้าเว็บโรคระบาด</h4>
						</button>
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
	
	

	
<!--===============================================================================================-->	
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/tilt/tilt.jquery.min.js"></script>

<!--===============================================================================================-->
	<script src="../js/main.js"></script>
	<!-- BUNDLE.js -->
<script src="../vendors/bundle.js"></script>

<!-- App scripts -->
<script src="../assets/js/app.min.js"></script>


<script>
            $(document).ready(function () {
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
                $.fn.pressEnter = function(fn) {
                    return this.each(function() {
                        $(this).bind('enterPress', fn);
                        $(this).keyup(function(e){
                            if(e.keyCode == 13)
                            {
                            $(this).trigger("enterPress");
                            }
                        })
                    });
                };
                $('#user').pressEnter(function(){ CheckLogin(); });
                $('#pass').pressEnter(function(){ CheckLogin(); });
            });
            function CheckLogin() {
                var user = $("#user").val();
                var pass = $("#pass").val();

                if(user == "" || pass == ""){
                    toastr.info('กรุณา! กรอก Username และ Password');
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "authentication.php",
                    data: {user:user, pass:pass},
                    dataType: "json",
                    success: function (response) {
                        //window.alert(response);
                        if(response.result =='yes'){
                            if(response.level == "1"){
                                window.location.assign("main/index.php");
                            }else if(response.level == "2"){
                                window.location.assign("site/index.php");
                            }
                        } else if(response.result == 'fail1') {
                            toastr.warning('ไม่พบข้อมูลผู้ใช้งาน');
                        } else if(response.result == 'fail2'){
                            toastr.warning('Username หรือ Password ไม่ถูกต้อง');
                        } else if(response.result == 'error_update'){
                            toastr.error('เกิดข้อผิดพลาด! error(01)');
                        } else if(response.result == 'error_insert'){
                            toastr.error('เกิดข้อผิดพลาด! error(02)');
                        }else {
                            toastr.error('เกิดข้อผิดพลาด! กรุณาลองใหม่อีกครั้ง');
                        } 
                    }
                });
			}
	function user_sigin(){
	 let freelogin =$("#freelogin").val();
	 $.ajax({
                type: "POST",
                url: "authentication_userfree.php",
                data: {freelogin:freelogin},
                    dataType: "json",
					success: function (response) 
					{
						if(response.result =='yes')
						{
								if (response.level=="1") 
								{ 
									window.location.assign("main/index.php");	
								
								}           
                         } 
                    }
                });
	}		

        </script>


</body>
</html>
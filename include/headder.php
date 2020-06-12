<?php
session_start();
include("include/connect.php");
include ('include/func.php');

?>
<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ไข้เลือดออก</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">



  <!-- =======================================================
  * Template Name: Techie - v2.0.0
  * Template URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
    <body>
        <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-xl-10 d-flex align-items-center">
          <h3 class="logo mr-auto" align="center">
                      <a href="index.php">
                               โรคไข้เลือด
                           <p>ออกเขตสุขภาพที่ 4</p>
                      </a>
          </h3>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li class="active"><a href="index.html">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#services">Services</a></li>
              <li><a href="#portfolio">Portfolio</a></li>
              <li><a href="#team">Team</a></li>
              <?php if (isset($_SESSION['valid_dhf_user'])) {?>
              <li class="drop-down"><a href="">จัดการข้อมูล</a>
                <ul>
                  <li><a href="index_dhf.php">จัดการข้อมูลโรคไข้เลือดออก</a></li>
                  <li class="drop-down"><a href="#">Deep Drop Down</a>
                    <ul>
                      <li><a href="#">Deep Drop Down 1</a></li>
                      <li><a href="#">Deep Drop Down 2</a></li>
                      <li><a href="#">Deep Drop Down 3</a></li>
                      <li><a href="#">Deep Drop Down 4</a></li>
                      <li><a href="#">Deep Drop Down 5</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <?php } ?>
              <!-- <li><a href="#contact">Contact</a></li> -->

            </ul>
          </nav>
          <!-- .nav-menu -->
        <?php
        if(isset($_SESSION['valid_dhf_user'])){?>
          <a href="../dhf_r4/logout.php" class="get-started-btn scrollto">Logout</a>
        <?}else{?>
          <a href="../dhf_r4/login.php" class="get-started-btn scrollto">Login</a>
      <?  }  ?>

  
        </div>
      </div>

    </div>
  </header><!-- End Header -->

 <!-- ======= Hero Section ======= -->
 <section id="hero" class="d-flex align-items-center"  style="height:1000px;">
<div class="container-fluid" data-aos="fade-up">
  <div class="row justify-content-center">
    <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
      <h1> การเฝ้าระวังโรคไข้เลือดออกเขตสุขภาพที่ 4</h1>
      <!-- <h2>We are team of talanted designers making websites with Bootstrap</h2> -->
      <!-- <div><a href="#about" class="btn-get-started scrollto">Get Started</a></div> -->
    </div>
    
    <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
      <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
    </div>
  </div>
</div>

</section><!-- End Hero -->

  

  
    </body>
</html>



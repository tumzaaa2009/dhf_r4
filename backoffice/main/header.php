<?php
    session_start();
    include("../../config/connect.php");
    include("../../config/func.php");
    include("../../config/jwt.php");
    include("../../config/session_lvl_1.php");
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?=$token->group_name?>เขตสุขภาพที่4</title>
  <meta content="กลุ่มโรคเขตสุขภาพที่4" name="descriptison">
  <meta content="กลุ่มโรคเขต4" name="keywords">

  <!-- Favicons -->
  <link href="img/kisspng-mosquito-control-household-insect-repellents-primo-5ba2f629ec4636.4883996115374065059678.png" rel="icon">
  <link href="img/kisspng-mosquito-control-household-insect-repellents-primo-5ba2f629ec4636.4883996115374065059678.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../../assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">

<!-- DHF -->
 <!-- Main css -->
 <link rel="stylesheet" href="../../vendors/bundle.css" type="text/css">
    <!-- Slick -->
    <link rel="stylesheet" href="../../vendors/slick/slick.css" type="text/css">
    <link rel="stylesheet" href="../../vendors/slick/slick-theme.css" type="text/css">
    <!-- Daterangepicker -->
    <link rel="stylesheet" href="../../vendors/datepicker/daterangepicker.css" type="text/css">
    <!-- DataTable -->
    <link rel="stylesheet" href="../../vendors/dataTable/datatables.min.css" type="text/css">
    <!-- App css -->
    <!-- <link rel="stylesheet" href="../../css/web-style.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="../../assets/css/app.min.css" type="text/css"> -->
    <link rel="stylesheet" href="../../vendors/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../vendors/fontawesome/css/all.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="../../vendors/select2/css/select2.min.css" type="text/css">
    <!-- Datepicker -->
    <link rel="stylesheet" href="../../vendors/datepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../vendors/summernote/summernote-bs4.min.css">
<!-- Toastr -->
<link href="../../assets/lib/toastr/build/toastr.min.css" rel="stylesheet">

<!-- SELECT 2 -->
<link href="../../assets/lib/select2/select2.min.css" rel="stylesheet">
  <!-- =======================================================
  * Template Name: Techie - v2.0.0
  * Template URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

<!-- leaflet -->
  <link rel="stylesheet" href="../../vendors/leaflet/easy-button.css">
  <link rel="stylesheet" href="../../vendors/leaflet/leaflet.css">
  <link rel="stylesheet" href="../../vendors/leaflet/css/leaflet.extra-markers.min.css">


</head>

<body>

<!-- Layout wrapper -->
<div class="layout-wrapper">
    <?php
        $authorization = $_SESSION['JWT_Dengue_Fever'];
        $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');
    ?>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <div id="preloader"></div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-xl-9 d-flex align-items-center">
<a href="index.php" class=""><img class="img-fluid" width="100px" src="img/logo2.png" alt=""></a>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="../../assets/img/logo.png" alt="" class="img-fluid"></a>-->

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li class="active"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
              <li><a href="view_map_main.php"><i class="fa fa-map-signs" aria-hidden="true"></i> แสดงแผนที่อัตราแสน</a></li>
              <!-- <li><a href="#services">Services</a></li>
              <li><a href="#portfolio">Portfolio</a></li> -->
              <li><a href="index_patient.php" <?php if($now_page == "index_patient.php"){ echo "class='active'"; } ?>><i class="fa fa-users" aria-hidden="true"></i> จัดการผู้ป่วย</a></li>
              <li class="drop-down"><a href=""><i class="fa fa-cog" aria-hidden="true"></i> จัดการระบบ</a>
                <ul>
                  <li><a href="index_group.php">จัดการกลุ่มโรค</a></li>
                  <!-- <li class="drop-down"><a href="#">Deep Drop Down</a>
                    <ul>
                      <li><a href="#">Deep Drop Down 1</a></li>
                      <li><a href="#">Deep Drop Down 2</a></li>
                      <li><a href="#">Deep Drop Down 3</a></li>
                      <li><a href="#">Deep Drop Down 4</a></li>
                      <li><a href="#">Deep Drop Down 5</a></li>
                    </ul>
                  </li> -->
                  <li><a href="setting_calendar.php">จัดการปฏิทินโรคระบาด</a></li>
                  <li><a href="setting_population.php">จัดการจำนวนประชากร</a></li>
                  <!-- <li><a href="#">Drop Down 4</a></li> -->
                </ul>
              </li>
    
              <li class="drop-down"><a href=""><i class="fa fa-user" aria-hidden="true"></i> <?php echo $token->dhf_fullname; ?></a>
                <ul>
                  <li><a href="logout.php"">ออกจากระบบ</a></li>
                  <!-- <li><a href="#">Drop Down 2</a></li>
                  <li><a href="#">Drop Down 3</a></li>
                  <li><a href="#">Drop Down 4</a></li> -->
                </ul>
              </li>
              <li >
              <ul>
               <a onclick="retweet_disease();" class="nav-link text-white btn btn btn-info" title="Change" style="cursor: pointer;">
                                <i data-feather="repeat"></i> เปลี่ยนกลุ่มโรค <span id="name_disease_1">(<?php echo $token->group_name; ?>)</span>
                  </a>
              </ul>
          </li>
            </ul>
          </nav><!-- .nav-menu -->
              
         
        </div>
      </div>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center" style="height:600px;">

    <div class="container-fluid" data-aos="fade-up">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>เขตสุขภาพที่4</h1>
          <h2><?=$token->group_name?></h2>
          <div><a href="javascript:void(0);" class="btn-get-started scrollto" onclick="retweet_disease();">เปลี่ยนกลุ่มโรค</a></div>
        </div>
        <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
          <img src="img/kisspng-mosquito-control-household-insect-repellents-primo-5ba2f629ec4636.4883996115374065059678.png"  width="500"  class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

</body>

</html>
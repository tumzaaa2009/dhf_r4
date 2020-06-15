<?php
    session_start();
    include("../../config/connect.php");
    include("../../config/func.php");
    include("../../config/jwt.php");
    include("../../config/session_lvl_1.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/site.webmanifest">
    <link rel="mask-icon" href="../favicon/safari-pinned-tab.svg" color="#bc4677">
    <meta name="msapplication-TileColor" content="#da77a0">
    <meta name="theme-color" content="#bc4677">
    <title>Epidemic Saraburi</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../assets/media/image/favicon.png"/>
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
    <link rel="stylesheet" href="../../css/web-style.css" type="text/css">
    <link rel="stylesheet" href="../../assets/css/app.min.css" type="text/css">
    <link rel="stylesheet" href="../../vendors/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../vendors/fontawesome/css/all.min.css">
    <!-- leaflet -->
    <link rel="stylesheet" href="../../vendors/leaflet/easy-button.css">
    <link rel="stylesheet" href="../../vendors/leaflet/leaflet.css">
    <link rel="stylesheet" href="../../vendors/leaflet/css/leaflet.extra-markers.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../vendors/select2/css/select2.min.css" type="text/css">
    <!-- Datepicker -->
    <link rel="stylesheet" href="../../vendors/datepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../vendors/summernote/summernote-bs4.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body  class="horizontal-navigation" >
<!-- Preloader -->
<div class="preloader">
    <div class="preloader-icon"></div>
</div>
<!-- ./ Preloader -->


<!-- Layout wrapper -->
<div class="layout-wrapper">
    <?php
        $authorization = $_SESSION['JWT_Dengue_Fever'];
        $token = JWT::decode($authorization, 'Hdk21sTs47kjTad47DsMzz74Lof');
    ?>
    <!-- Header -->
    <div class="header d-print-none">
        <div class="header-container">
            <div class="header-left">
                <div class="navigation-toggler">
                    <a href="#" data-action="navigation-toggler">
                        <i data-feather="menu"></i>
                    </a>
                </div>
                <div class="header-logo">
                    <a href=index.php>
                        <h2 class="text-white">Epidemic Saraburi</h2>
                    </a>
                </div>
            </div>
            <div class="header-body">
                <div class="header-body-left">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="header-search-form">
                              
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="header-body-right">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link" title="Fullscreen" data-toggle="fullscreen">
                                <i class="maximize" data-feather="maximize"></i>
                                <i class="minimize" data-feather="minimize"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a onclick="retweet_disease();" class="nav-link" title="Change" style="cursor: pointer;">
                                <i data-feather="repeat"></i> เปลี่ยนกลุ่มโรค <span id="name_disease_1">(<?php echo $token->group_name; ?>)</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" title="User menu" data-toggle="dropdown">
                                <figure class="avatar avatar-sm">
                                    <img src="../../assets/media/image/user/man_avatar3.jpg" class="rounded-circle"
                                         alt="avatar">
                                </figure>
                                <span class="ml-2 d-sm-inline d-none"><?php echo $token->dhf_fullname; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-big">
                                <div class="text-center py-4" data-background-image="../../assets/media/image/image1.jpg">
                                    <figure class="avatar avatar-lg mb-3 border-0">
                                        <img src="../../assets/media/image/user/man_avatar3.jpg" class="rounded-circle" alt="image">
                                    </figure>
                                    <h5 class="mb-0"><?php echo $token->dhf_fullname; ?></h5>
                                </div>
                                <div class="list-group list-group-flush">
                                    <a href="index_profile.php" class="list-group-item">โปรไฟล์</a>
                                    <a href="logout.php" class="list-group-item text-danger">ออกจากระบบ</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item header-toggler">
                    <a href="#" class="nav-link">
                        <i data-feather="arrow-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- ./ Header -->
    <?php $now_page = basename($_SERVER['PHP_SELF']); ?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- begin::navigation -->
        <div class="navigation">
            <div class="navigation-menu-body">
                <ul>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="home"></i>
                            </span>
                            <span>หน้าแรก</span>
                        </a>
                        <ul>
                            <li>
                                <a href="index.php" <?php if($now_page == "index.php"){ echo "class='active'"; } ?>>หน้าแรก</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="bar-chart"></i>
                            </span>
                            <span>แผนภูมิ</span>
                        </a>
                        <ul>
                            <li>
                                <a href="view_chart_main.php" <?php if($now_page == "view_chart_main.php"){ echo "class='active'"; } ?>>แผนภูมิการเกิดโรค</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="map"></i>
                            </span>
                            <span>แผนที่</span>
                        </a>
                        <ul>
                            <li>
                                <a href="view_map_main.php" <?php if($now_page == "view_map_main.php"){ echo "class='active'"; } ?>>แผนที่แสดงการเกิดโรคอัตราต่อแสนประชากร</a>
                            </li>
                            <li>
                                <a href="view_map_point.php" <?php if($now_page == "view_map_point.php"){ echo "class='active'"; } ?>>แผนที่แสดงพิกัด</a>
                            </li>
                            <li>
                                <a href="index_map_dhf.php" <?php if($now_page == "index_map_dhf.php"){ echo "class='active'"; } ?>>แผนที่แสดงการเกิดโรครายสัปดาห์</a>
                            </li>
                            <?php if($token->group_id == "1") { ?>
                            <li>
                                <a href="view_map_hici.php" <?php if($now_page == "view_map_hici.php"){ echo "class='active'"; } ?>>แผนที่ HI CI</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="bar-chart-2"></i>
                            </span>
                            <span>ติดตาม</span>
                        </a>
                        <ul>
                            <li>
                                <a href="trace_map_point.php" <?php if($now_page == "trace_map_point.php"){ echo "class='active'"; } ?>>ติดตามการลงพิกัดแผนที่</a>
                            </li>
                            <?php if($token->group_id == "1") { ?>
                            <li>
                                <a href="trace_hici.php" <?php if($now_page == "trace_hici.php"){ echo "class='active'"; } ?>>ติดตามการลงข้อมูล HI CI</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if($token->dhf_admin == "1") { ?>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="user"></i>
                            </span>
                            <span>จัดการผู้ป่วย</span>
                        </a>
                        <ul>
                            <li>
                                <a href="index_patient.php" <?php if($now_page == "index_patient.php"){ echo "class='active'"; } ?>>จัดการผู้ป่วย</a>
                            </li>
                            <?php if($token->group_id == "1") { ?>
                            <li>
                                <a href="index_hi_ci.php" <?php if($now_page == "index_hi_ci.php"){ echo "class='active'"; } ?>>จัดการ HI CI</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                    <?php if($token->dhf_admin == "1") { ?>
                    <li>
                        <a href="#">
                            <span class="nav-link-icon">
                                <i data-feather="settings"></i>
                            </span>
                            <span>จัดการระบบ</span>
                        </a>
                        <ul>
                            <li>
                                <a href="index_user.php" <?php if($now_page == "index_user.php"){ echo "class='active'"; } ?>>จัดการผู้ใช้งาน</a>
                            </li>
                            <li>
                                <a href="index_group.php" <?php if($now_page == "index_group.php"){ echo "class='active'"; } ?>>จัดการกลุ่มโรค</a>
                            </li>
                            <li>
                                <a href="setting_calendar.php" <?php if($now_page == "setting_calendar.php"){ echo "class='active'"; } ?>>จัดการปฏิทินโรคระบาด</a>
                            </li>
                            <li>
                                <a href="setting_population.php" <?php if($now_page == "setting_population.php"){ echo "class='active'"; } ?>>จัดการประชากร</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- end::navigation -->
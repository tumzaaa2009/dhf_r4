
<?php 
include('header.php')
?>


<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Techie Bootstrap Template - Index</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <style>
 
 #map { width: 100%;height: 75%;}
 .mapboxgl-popup {
 max-width: 400px;
 font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
 }</style>
</head>

<body>

 
  <main id="main">

    <!-- ======= About Section ======= -->
          <!-- Content body -->
          <div class="container">  
            <div class="content-body ">
                <!-- Content -->
                <div class="content mt-5">
                    <div class="page-header">
                        <div>
                            <h3>แผนที่แสดงการเกิดโรคอัตราแสน</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        แผนที่แสดงการเกิดโรค
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <div class="btn bg-white">
                                <span><i class="fas fa-viruses"></i> <?php echo ($token->group_name != "" ? $token->group_name : "กรุณาเลือกกลุ่มโรค"); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="year">ปี </label>
                                                <select class="form-control" id="year" name="year" onchange="LoadMap();">
                                                    <?php
                                                        $months = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
                                                        $sql_year = "SELECT dcp1.* FROM dhf_population_lvl1 dcp1 ORDER BY dcp1.year DESC";
                                                        $rs_year = $db_r4->prepare($sql_year);
                                                        $rs_year->execute();
                                                        $results_year = $rs_year->fetchAll();
                                                    ?>
                                                    <?php foreach($results_year as $row_year){ ?> 
                                                        <option value="<?php echo $row_year['year'];?>" <?php if($row_year['year'] == date('Y')){ echo "selected"; } ?>><?php echo "ปี ".$row_year['year'] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_start">เดือนเริ่มต้น </label>
                                                <select class="form-control" id="date_start" name="date_start" onchange="LoadMap();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == 1){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">เดือนสิ้นสุด </label>
                                                <select class="form-control" id="date_end" name="date_end" onchange="LoadMap();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == date("m")){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadMap();">
                                                    <?php
                                                        $sql_code = "SELECT * FROM dhf_506 WHERE id_506 IN ($token->group_id_506)";
                                                        $rs_code = $db_r4->prepare($sql_code);
                                                        $rs_code->execute();
                                                        $results_code = $rs_code->fetchAll();
                                                    ?>
                                                    <option value="<?php echo $token->group_id_506; ?>" selected>ทั้งหมด</option>
                                                    <?php foreach($results_code as $row_code){ ?> 
                                                        <option value="<?php echo $row_code['id_506'];?>"><?php echo $row_code['name_thai_506']." [".$row_code['id_506']."]";?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>อัตราป่วย</label>
                                                <select class="form-control" id="scale_type" name="scale_type" onchange="LoadMap();">
                                                    <option value="0">0 > 5 > 10 > 20</option> 
                                                    <option value="1" selected>0 > 20 > 30 > 50</option> 
                                                    <option value="2">0 > 50 > 100 > 150</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>จังหวัด</label>
                                                <?php 
                                                 $select_provice = "SELECT * FROM dhf_province";
                                                 $rs_code_provice = $db_r4->prepare($select_provice);
                                                 $rs_code_provice->execute();
                                                 $results_code_provice = $rs_code_provice->fetchAll();?>
                            <select class="select2 form-control" name="ampur[]" id="ampur[]" multiple="multiple" onchange="LoadMap();" >                                             
                        <?php  foreach($results_code_provice as $row_code_province){ ?>
                                                     <option value='<?=$row_code_province['Province_CODE']?>'><?=$row_code_province['Province_NAME']?></option>
                                                     
                                                     <?php } ?>
                                                </select>
                                            </div>
                                        </div>                    


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row" >
                    <div class="col" style="width: 1000px;height: 1000px;">
                            <div id="map" ></div>
                    </div>
                   
                </div>
        
                  </div>
                </div>
    </div>  
 <!-- ./ Content -->

 <section id="summaryr4" class="container" style="margin-top:-15%">
<hr>
<div class="col mt-2" >

                       <div class="row ">
                         <div class="col-12">
                            <div id="table-report4"></div>
                        </div>
                       </div>
                    </div>



 </section>
    <!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <!-- <section id="counts" class="counts">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">232</span>
            <p>Clients</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">521</span>
            <p>Projects</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">1,463</span>
            <p>Hours Of Support</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">15</span>
            <p>Hard Workers</p>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Counts Section -->

    <!-- ======= Services Section ======= -->
    <!-- <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Services</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
                </svg>
                <i class="bx bxl-dribbble"></i>
              </div>
              <h4><a href="">Lorem Ipsum</a></h4>
              <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-orange ">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426"></path>
                </svg>
                <i class="bx bx-file"></i>
              </div>
              <h4><a href="">Sed Perspiciatis</a></h4>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-tachometer"></i>
              </div>
              <h4><a href="">Magni Dolores</a></h4>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-yellow">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,503.46388370962813C374.79870501325706,506.71871716319447,464.8034551963731,527.1746412648533,510.4981551193396,467.86667711651364C555.9287308511215,408.9015244558933,512.6030010748507,327.5744911775523,490.211057578863,256.5855673507754C471.097692560561,195.9906835881958,447.69079081568157,138.11976852964426,395.19560036434837,102.3242989838813C329.3053358748298,57.3949838291264,248.02791733380457,8.279543830951368,175.87071277845988,42.242879143198664C103.41431057327972,76.34704239035025,93.79494320519305,170.9812938413882,81.28167332365135,250.07896920659033C70.17666984294237,320.27484674793965,64.84698225790005,396.69656628748305,111.28512138212992,450.4950937839243C156.20124167950087,502.5303643271138,231.32542653798444,500.4755392045468,300,503.46388370962813"></path>
                </svg>
                <i class="bx bx-layer"></i>
              </div>
              <h4><a href="">Nemo Enim</a></h4>
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-red">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,532.3542879108572C369.38199826031484,532.3153073249985,429.10787420159085,491.63046689027357,474.5244479745417,439.17860296908856C522.8885846962883,383.3225815378663,569.1668002868075,314.3205725914397,550.7432151929288,242.7694973846089C532.6665558377875,172.5657663291529,456.2379748765914,142.6223662098291,390.3689995646985,112.34683881706744C326.66090330228417,83.06452184765237,258.84405631176094,53.51806209861945,193.32584062364296,78.48882559362697C121.61183558270385,105.82097193414197,62.805066853699245,167.19869350419734,48.57481801355237,242.6138429142374C34.843463184063346,315.3850353017275,76.69343916112496,383.4422959591041,125.22947124332185,439.3748458443577C170.7312796277747,491.8107796887764,230.57421082200815,532.3932930995766,300,532.3542879108572"></path>
                </svg>
                <i class="bx bx-slideshow"></i>
              </div>
              <h4><a href="">Dele Cardo</a></h4>
              <p>Quis consequatur saepe eligendi voluptatem consequatur dolor consequuntur</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-teal">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,566.797414625762C385.7384707136149,576.1784315230908,478.7894351017131,552.8928747891023,531.9192734346935,484.94944893311C584.6109503024035,417.5663521118492,582.489472248146,322.67544863468447,553.9536738515405,242.03673114598146C529.1557734026468,171.96086150256528,465.24506316201064,127.66468636344209,395.9583748389544,100.7403814666027C334.2173773831606,76.7482773500951,269.4350130405921,84.62216499799875,207.1952322260088,107.2889140133804C132.92018162631612,134.33871894543012,41.79353780512637,160.00259165414826,22.644507872594943,236.69541883565114C3.319112789854554,314.0945973066697,72.72355303640163,379.243833228382,124.04198916343866,440.3218312028393C172.9286146004772,498.5055451809895,224.45579914871206,558.5317968840102,300,566.797414625762"></path>
                </svg>
                <i class="bx bx-arch"></i>
              </div>
              <h4><a href="">Divera Don</a></h4>
              <p>Modi nostrum vel laborum. Porro fugit error sit minus sapiente sit aspernatur</p>
            </div>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Services Section -->

    <!-- ======= Features Section ======= -->
    <!-- <section id="features" class="features">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Features</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column align-items-lg-center">
            <div class="icon-box mt-5 mt-lg-0" data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-receipt"></i>
              <h4>Est labore ad</h4>
              <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
            </div>
            <div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-cube-alt"></i>
              <h4>Harum esse qui</h4>
              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
            </div>
            <div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-images"></i>
              <h4>Aut occaecati</h4>
              <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
            </div>
            <div class="icon-box mt-5" data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-shield"></i>
              <h4>Beatae veritatis</h4>
              <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
            </div>
          </div>
          <div class="image col-lg-6 order-1 order-lg-2 " data-aos="zoom-in" data-aos-delay="100">
            <img src="../../assets/img/features.svg" alt="" class="img-fluid">
          </div>
        </div>

      </div>
    </section> -->
    <!-- End Features Section -->

    <!-- ======= Testimonials Section ======= -->
    <!-- <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Testimonials</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="owl-carousel testimonials-carousel">

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="../../assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
            <h3>Saul Goodman</h3>
            <h4>Ceo &amp; Founder</h4>
          </div>

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="../../assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
            <h3>Sara Wilsson</h3>
            <h4>Designer</h4>
          </div>

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="../../assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
            <h3>Jena Karlis</h3>
            <h4>Store Owner</h4>
          </div>

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="../../assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
            <h3>Matt Brandon</h3>
            <h4>Freelancer</h4>
          </div>

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa.
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="../../assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
            <h3>John Larson</h3>
            <h4>Entrepreneur</h4>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Testimonials Section -->

    <!-- ======= Portfolio Section ======= -->
    <!-- <section id="portfolio" class="portfolio">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Portfolio</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 1</h4>
                <p>App</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-2.jpg" data-gall="portfolioGallery" class="venobox" title="Web 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 2</h4>
                <p>App</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery" class="venobox" title="App 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 2</h4>
                <p>Card</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-4.jpg" data-gall="portfolioGallery" class="venobox" title="Card 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 2</h4>
                <p>Web</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-5.jpg" data-gall="portfolioGallery" class="venobox" title="Web 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 3</h4>
                <p>App</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-6.jpg" data-gall="portfolioGallery" class="venobox" title="App 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 1</h4>
                <p>Card</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-7.jpg" data-gall="portfolioGallery" class="venobox" title="Card 1"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 3</h4>
                <p>Card</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-8.jpg" data-gall="portfolioGallery" class="venobox" title="Card 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="../../assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
              </div>
              <div class="portfolio-links">
                <a href="../../assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery" class="venobox" title="Web 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Portfolio Section -->

    <!-- ======= Pricing Section ======= -->
    <!-- <section id="pricing" class="pricing section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Pricing</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="box">
              <h3>Free</h3>
              <h4><sup>$</sup>0<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li class="na">Pharetra massa</li>
                <li class="na">Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="box featured">
              <h3>Business</h3>
              <h4><sup>$</sup>19<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li>Pharetra massa</li>
                <li class="na">Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <div class="box">
              <h3>Developer</h3>
              <h4><sup>$</sup>29<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li>Pharetra massa</li>
                <li>Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
            <div class="box">
              <span class="advanced">Advanced</span>
              <h3>Ultimate</h3>
              <h4><sup>$</sup>49<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li>Pharetra massa</li>
                <li>Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <!-- <section id="faq" class="faq">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="faq-list">
          <ul>
            <li data-aos="fade-up" data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#faq-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-parent=".faq-list">
                <p>
                  Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-parent=".faq-list">
                <p>
                  Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-3" class="collapse" data-parent=".faq-list">
                <p>
                  Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-4" class="collapse" data-parent=".faq-list">
                <p>
                  Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="500">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-5" class="collapse" data-parent=".faq-list">
                <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section> -->
    <!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <!-- <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>Our Address</h3>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p>contact@example.com</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p>+1 5589 55488 55</p>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-lg-6 ">
            <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Contact Section -->

  </main><!-- End #main -->
<?=include('footer.php')?>

        <!-- ./ Content wrapper -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div id="showModal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div id="showSubModal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="diseaseModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div id="diseaseShowModal"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./ Layout wrapper -->






  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="../../assets/vendor/counterup/counterup.min.js"></script>
  <script src="../../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/venobox/venobox.min.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
        <!-- Apex chart -->
        <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
        <script src="../../vendors/charts/apex/apexcharts.min.js"></script>
        <!-- Daterangepicker -->
        <script src="../../vendors/datepicker/daterangepicker.js"></script>
        <!-- DataTable -->
        <script src="../../vendors/dataTable/datatables.min.js"></script>
        <!-- Vamp -->
        <script src="../../vendors/vmap/jquery.vmap.min.js"></script>
        <script src="../../vendors/vmap/maps/jquery.vmap.usa.js"></script>
        <script src="../../assets/js/examples/vmap.js"></script>

        <!-- App scripts -->
        <!-- <script src="../../assets/js/app.min.js"></script> -->
        <script src="../../js/check_disease.js"></script>

        <!-- FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/fusioncharts.js"></script>
        <!-- jQuery-FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/integrations/jquery/js/jquery-fusioncharts.js"></script>
        <!-- Fusion Theme -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>
        <!-- leaflet -->
        <script src="../../vendors/leaflet/leaflet.js"></script>
        <script src="../../vendors/leaflet/easy-button.js"></script>
        <script src="../../vendors/leaflet/js/leaflet.extra-markers.min.js"></script> 
          <!-- SELECT 2 -->
          <script src="../../assets/lib/select2/select2.min.js" ></script>

        <script>
            $(document).ready(function () {
                check_disease();
                $('.select2').select2({placeholder:'เลือกทั้งหมด'});
//////////////////////////////////////////////////
                LoadMap(); 
                map_get_table();
});



            
function map_get_table(){
    let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();

                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapMain/report_table.php",
                   data: {year:year,date_start:date_start, date_end:date_end, year:year, id_506:id_506, scale_type:scale_type,ampur:ampur},
                    success: function (result) {
                        $("#table-report4").html(result);
                        $('#dataTable').DataTable({
                            searching: true,
                            paging: true,
                            info: true,
                            responsive: true,
                        } );
                    }
                });
            }
// start-map 
var geojson = "";
            var markerall = new Array();
            var markercount = 0;
            var info = L.control();
            var mymap = L.map('map');
            var legend = L.control({position: 'bottomright',right:'15px'});
            
function LoadMap(){
                
                let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();

                if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
                $.ajax({
                type: "POST",
                url: "ajax/viewMapMain/getMap.php",
                data: {year:year,date_start:date_start, date_end:date_end, year:year, id_506:id_506, scale_type:scale_type,ampur:ampur},
                dataType: "json",
                    success: function (result) {
        	// console.log( JSON.stringify(result, null, 2) );
            if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
    mymap.createPane('labels');

    // This pane is above markers but below popups
    mymap.getPane('labels').style.zIndex = 650;

    // Layers in this pane are non-interactive and do not obscure mouse/touch events
    mymap.getPane('labels').style.pointerEvents = 'none';

   
mymap.setView([ 14.778866120581371,100.77346801757812], 4);
     L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoidHVtemFhMjAwOSIsImEiOiJja2E3bDRyNnYwNDR6MnlvM2xmNXZzY2prIn0.VTjKIDTqhMnhWYI8LCD5iA', 
     {
                            maxZoom: 11,
                            minZoom: 9,
                            id: 'mapbox.streets',
                            accessToken: 'pk.eyJ1IjoidHVtemFhMjAwOSIsImEiOiJja2E3bDRyNnYwNDR6MnlvM2xmNXZzY2prIn0.VTjKIDTqhMnhWYI8LCD5iA'
                        }).addTo(mymap);

  ///function geo
   geojson = new L.GeoJSON(result, {
                            style:style, // stylesheet location
                            onEachFeature: onEachFeature,
                        }).addTo(mymap);
                        legend.addTo(mymap);
                    
                    }
                });
              }
function onEachFeature(feature, layer) {

// console.log("fuck",feature.properties.name);

                        layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                });
            }
 function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 4,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.5
                });
                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                    layer.bringToFront();
                }
                info.update(layer.feature.properties);
            }
            function resetHighlight(e) {
                geojson.resetStyle(e.target);
                info.update();
            }
            function style(feature) {
                return {
                    fillColor: feature.properties.color,
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.3
                };
            }
              
            info.onAdd = function (mymap) {
                this._div = L.DomUtil.create('div', 'info-leafletjs'); // create a div with a class "info"
                this.update();
                return this._div;
            };

            info.update = function (props) {
       
                    this._div.innerHTML = (props ?  "<div class='card card-body'><h4 class='text-dark font-weight-bold'>" + props.name + "<br></h4>"+"<br>"
                    +"จำนวนผู้ป่วย : <span class='text-dark font-weight-bold'>"+props.CountPatient+" คน </span><br>"
                    +"จำนวนประชากรในจังหวัด:<span class='text-dark font-weight-bold'> "+props.Population+" คน </span><br>"
                    +"คิดเป็น <span class='text-dark font-weight-bold'>"+props.RatePopulation+" ต่อแสนประชากร</span></div>"
                    : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                 
    
            };
            info.addTo(mymap);
            legend.onAdd = function (mymap) {
       
                let Scale = [
                    [0,5,10,20],
                    [0,20,30,50],
                    [0,50,100,150]
                ];
                let scale_type = $("#scale_type").val();
         
             text_legend = "<div class='card card-body'><h6><div class='mb-1 '><i class='fa fa-circle' aria-hidden='true' style='color: #fff'></i> อัตราป่วยต่อแสนประชากร : 0</div>"
                +"<div class='mb-1'><i class='fa fa-circle' style='color: #28A745' aria-hidden='true'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][0]+" - "+Scale[scale_type][1]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true' style='color: #ffff4d'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][1]+" - "+Scale[scale_type][2]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true' style='color: #FF7C2C'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][2]+" - "+Scale[scale_type][3]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true'style='color: #DC3545' ></i> อัตราป่วยต่อแสนประชากร : > "+Scale[scale_type][3]+"</div></h6></div>";

                var div = L.DomUtil.create('div', 'info-lg legend-lg');
                div.innerHTML = text_legend;
                                
                return div;
            };



   
        </script>
</body>

</html>
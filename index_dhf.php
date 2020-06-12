้<?php include "include/headder.php"; ?>
<body>

 

 

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <!-- <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="150">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div> -->
          <div class="col-12">
                <div id="report-table">
          </div>
          </div>
          
        </div>

      </div>
    </section><!-- End About Section -->

   

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
<script>
$( document ).ready(function() {
    map_get_table();
});
function map_get_table(){
                $.ajax({
                    type: "POST",
                    url: "ajax/manage/manage-table-dhf.php",
                    data: {btnReportMain:"01"},
                    success: function (result) {
                        $("#report-table").html(result);
                        // $('#dataTable').DataTable({
                        //     searching: true,
                        //     paging: true,
                        //     info: true,
                        //     responsive: true,
                        // });
                    }
                });
            }


</script>



</body>

</html>
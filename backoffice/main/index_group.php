<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body mt-5 container">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>จัดการกลุ่มโรค</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        จัดการกลุ่มโรค
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                    <span><?php echo ($token->group_name != "" ? $token->group_name : "กรุณาเลือกกลุ่มโรค"); ?></span>
                                    </li>
                                    <div>
                                </ol>
                            </nav>
                        </div>
              
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="DiseaseAdd()"><i class="fa fa-plus mr-1" aria-hidden="true"></i> เพิ่มกลุ่มโรค</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="showTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ Content -->
       
            </div>
            <!-- ./ Content body -->
        </div>
        
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

    <!-- Main scripts -->
    <script src="../../vendors/bundle.js"></script>
        <!-- To use theme colors with Javascript -->
        <div class="colors">
            <div class="bg-primary"></div>
            <div class="bg-primary-bright"></div>
            <div class="bg-secondary"></div>
            <div class="bg-secondary-bright"></div>
            <div class="bg-info"></div>
            <div class="bg-info-bright"></div>
            <div class="bg-success"></div>
            <div class="bg-success-bright"></div>
            <div class="bg-danger"></div>
            <div class="bg-danger-bright"></div>
            <div class="bg-warning"></div>
            <div class="bg-warning-bright"></div>
        </div>

             <!-- Footer -->
             <?php include("footer.php"); ?>
                <!-- ./ Footer -->    
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
        <script src="../../vendors/leaflet/leaflet.js"></script>
        <script src="../../vendors/leaflet/easy-button.js"></script>
        <script src="../../vendors/leaflet/js/leaflet.extra-markers.min.js"></script>
        <script src="../../js/check_disease.js"></script>

        <!-- FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/fusioncharts.js"></script>
        <!-- jQuery-FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/integrations/jquery/js/jquery-fusioncharts.js"></script>
        <!-- Fusion Theme -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>

        <script>
            $(document).ready(function () {
                check_disease();
                LoadDisease();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
            });
            function LoadDisease() {
                let ampur = $("#ampur").val();
                let tumbol = $("#tumbol").val();
                let level = $("#level").val();
                let status = $("#status").val();
                $('#showTable').load("ajax/indexDisease/getTable.php",{"ampur":ampur,"tumbol":tumbol,"level":level,"status":status},function(){
                    $('#dataTable').DataTable({
                        searching: true,
                        paging: true,
                        info: true,
                        responsive: true,
                        order: [[ 0, "desc" ]],
                        lengthMenu: [10, 25, 50, 100, 500,1000] ,
                    });
                });
            }
            function DiseaseAdd() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexDisease/formAdd.php",function(){
                    $('#id_506').select2({
                        placeholder: 'โปรดเลือกโรค'
                    });
                    $("#DiseaseAddSubmit").click(function() {
                        let group_name = $('#group_name').val();
                        let id_506 = $('#id_506').val();
                        if(group_name == "" || id_506 == ""){
                            toastr.info('กรุณากรอกข้อมูลให้ครบ!');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการเพิ่มข้อมูล ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('form-add');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexDisease/Add.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('เพิ่มข้อมูลสำเร็จ!');
                                            LoadDisease();
                                        }else if(result.result == "0"){
                                            toastr.warning('เพิ่มไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
                                        }else{
                                            toastr.error('ติดต่อเซิฟเวอร์ไม่สำเร็จ!');
                                        }
                                    }
                                });
                            }
                        });
                    });	
                });
            }
            function DiseaseEdit(group_id) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexDisease/formEdit.php",{"group_id":group_id},function(){
                    $('#id_506').select2({ placeholder: 'โปรดเลือกโรค' });
                    $("#DiseaseEditSubmit").click(function() {
                        let group_name = $('#group_name').val();
                        let id_506 = $('#id_506').val();
                        if(group_name == "" || id_506 == ""){
                            toastr.info('กรุณากรอกข้อมูลให้ครบ!');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการแก้ไขข้อมูล ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('form-edit');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexDisease/Edit.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('แก้ไขข้อมูลสำเร็จ!');
                                            LoadDisease();
                                            if(result.reload == "reload"){
                                                location.reload();
                                            }
                                        }else if(result.result == "2"){
                                            toastr.warning('ไม่มีการแก้ไขข้อมูล!');
                                        }else if(result.result == "0"){
                                            toastr.warning('แก้ไขไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
                                        }else{
                                            toastr.error('ติดต่อเซิฟเวอร์ไม่สำเร็จ!');
                                        }
                                    }
                                });
                            }
                        });
                    });	
                });
            }
            function DiseaseDelete(group_id) {
                swal({
                    title: "แจ้งเตือน",
                    text: "ยืนยันการลบข้อมูล ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((Confirm) => {
                    if (Confirm) {
                        $.ajax({
                            type: "POST",
                            url: "ajax/indexDisease/Delete.php",
                            data: {group_id:group_id},
                            dataType: "json",
                            success: function (result) {
                                if(result.result == "1"){
                                    toastr.success("แจ้งเตือน","ลบกลุ่มโรคลำดับที่ : "+group_id+" สำเร็จ!");
                                    $("#tr_" + group_id).fadeOut(1000);
                                } else if(result.result == "0"){
                                    toastr.warning('ลบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
                                } else {
                                    toastr.error('ติดต่อเซิฟเวอร์ไม่สำเร็จ!');
                                }
                            }
                        });
                    }
                });
            }
        </script>
    </body>
</html>

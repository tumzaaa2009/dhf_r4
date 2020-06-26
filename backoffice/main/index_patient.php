
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

 
</head>

<body>
<section class="main">
<div class="container">    
                <div class="content">
                                <div class="page-header"><div>
                                        <h3>จัดการผู้ป่วย</h3>
                    <nav class="navbar navbar-expand-md navbar-light bg-light">
                
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mr-auto">
                        <li class="breadcrumb-item"> <a href="index.php">หน้าแรก</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">จัดการผู้ป่วย </li> 
                        <li class="breadcrumb-item active" aria-current="page"> <?php echo ($token->group_name != "" ? $token->group_name : "กรุณาเลือกกลุ่มโรค"); ?>  </li> 
                        </ul>
                        <ul class="navbar-nav">
                        <li class="breadcrumb-item active" aria-current="page">
                        <button type="button" class="btn btn-sm btn-primary" onclick="ImportData()"><i class="fas fa-upload mr-1"></i> นำเข้าข้อมูล xlsx.</button>           
                        </ul>
                    </div>
                    </nav> 
                </div>
                <div>            
            </div> 

<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_start">วันที่เริ่ม <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_start" name="date_start" onchange="LoadPatient();" value="<?php echo date("Y-m-d", strtotime("01-01-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">วันที่สิ้นสุด <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_end" name="date_end" onchange="LoadPatient();" value="<?php echo date("Y-m-d", strtotime("31-12-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadPatient();">
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
                                                <label for="ampur">อำเภอ</label>
                                                <select class="form-control" id="ampur" name="ampur" onchange="LoadPatient();">
                                                    <?php
                                                        $sql_amphur = "SELECT * FROM dhf_ampur WHERE PRO_CODE = '19'";
                                                        $rs_amphur = $db_r4->query($sql_amphur);
                                                        $rs_amphur->execute();
                                                        $result_amphur = $rs_amphur->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <option value="0">ทั้งหมด</option> 
                                                    <?php foreach($result_amphur as $row_amphur){ ?> 
                                                        <option value="<?php echo $row_amphur['AMP_CODE'];?>"><?php echo "อ.".$row_amphur['AMP_NAME'];?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                   
                                <div class="card-body">
                                    <div class="loader" id="loader">Loading...</div>
                                    <div class="table-responsive" id="showTable" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

   </div>
      <!-- END - Container -->
 </div> 
<!-- modal-main -->
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
                                                    </section>



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
<?php

include('footer.php');


?>        
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
$(document).ready(function(){
    LoadPatient();
    $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: "YYYY-MM-DD",
                    }
                });
});
function ImportData() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexPatient/formImport.php",function(){
                    $("#ImportSubmit").click(function() {
                        var fileImport = $('#fileImport').val();
                        if(fileImport == ""){
                            toastr.info('กรุณาเลือกไฟล์อัปโหลด!');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการอัปโหลดไฟล์ ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('ImportFile');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    beforeSend: function(){
                                        $("#ImportSubmit").prop("disabled", true);
                                        $("#ImportSubmit").html("<span class='spinner-border spinner-border-sm mr-2' role='status' aria-hidden='true'></span>Loading...");
                                    },
                                    url: 'ajax/indexPatient/importData.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        $("#ImportSubmit").prop("disabled", false);
                                        $("#ImportSubmit").html("<i class='fas fa-upload mr-1'></i> นำเข้าข้อมูล");
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('นำเข้าข้อมูลสำเร็จ!');
                                            LoadPatient();
                                        }else if(result.result == "0"){
                                            toastr.warning('นำเข้าข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
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
            function ImportDataTxt() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexPatient/formImportTxt.php",function(){
                    $("#ImportSubmit").click(function() {
                        var fileImport = $('#fileImport').val();
                        if(fileImport == ""){
                            toastr.info('กรุณาเลือกไฟล์อัปโหลด!');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการอัปโหลดไฟล์ ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('ImportFile');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    beforeSend: function(){
                                        $("#ImportSubmit").prop("disabled", true);
                                        $("#ImportSubmit").html("<span class='spinner-border spinner-border-sm mr-2' role='status' aria-hidden='true'></span>Loading...");
                                    },
                                    url: 'ajax/indexPatient/importDataTxt.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        $("#ImportSubmit").prop("disabled", false);
                                        $("#ImportSubmit").html("<i class='fas fa-upload mr-1'></i> นำเข้าข้อมูล");
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('นำเข้าข้อมูลสำเร็จ!');
                                            LoadPatient();
                                        }else if(result.result == "0"){
                                            toastr.warning('นำเข้าข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
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
/*-------------------------------------------------------------------------------------------------------------------------------------------*/
function readURL(input,value,show_position) {
                var fty = ["xlsx", "xls"];
                var permiss = 0;
                var file_type = value.split('.');
                file_type = file_type[file_type.length-1];
                if (jQuery.inArray( file_type , fty ) !== -1) {
                    $(show_position).html(input.value);
                } else if (value == "") {
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                } else {
                    toastr.info('อัพโหลดได้เฉพาะไฟล์นามสกุล (.xlsx .xls) เท่านั้น!');
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                    return false;
                }
            }
            function readURLtxt(input,value,show_position) {
                var fty = ["txt"];
                var permiss = 0;
                var file_type = value.split('.');
                file_type = file_type[file_type.length-1];
                if (jQuery.inArray( file_type , fty ) !== -1) {
                    $(show_position).html(input.value);
                } else if (value == "") {
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                } else {
                    toastr.info('อัพโหลดได้เฉพาะไฟล์นามสกุล (.txt) เท่านั้น!');
                    $(show_position).html("เลือกไฟล์...");
                    $(input).val("");
                    return false;
                }
            }
// LOAD PATIENT 

        function LoadPatient() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("#ampur").val();
                $.ajax({
                    beforeSend: function(){
                        $("#loader").fadeIn();
                        $("#showTable").hide();
                    },
                    type: "POST",
                    url: "ajax/indexPatient/getTable.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        ampur:ampur},
                    dataType: "html",
                    success: function (response) {
                        $("#showTable").html(response);
                        $('#dataTable').DataTable({
                            searching: true,
                            paging: true,
                            info: true,
                            responsive: true,
                            order: [[ 0, "desc" ]],
                            pageLength: 25,
                            lengthMenu: [10, 25, 50, 100, 500, 1000] ,
                        });
                        $("#loader").hide();
                        $("#showTable").fadeIn();
                    }
                });
            }        function LoadPatient() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("#ampur").val();
                $.ajax({
                    beforeSend: function(){
                        $("#loader").fadeIn();
                        $("#showTable").hide();
                    },
                    type: "POST",
                    url: "ajax/indexPatient/getTable.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        ampur:ampur},
                    dataType: "html",
                    success: function (response) {
                        $("#showTable").html(response);
                        $('#dataTable').DataTable({
                            searching: true,
                            paging: true,
                            info: true,
                            responsive: true,
                            order: [[ 0, "desc" ]],
                            pageLength: 25,
                            lengthMenu: [10, 25, 50, 100, 500, 1000] ,
                        });
                        $("#loader").hide();
                        $("#showTable").fadeIn();
                    }
                });
            }


</script>
    
</body>

</html>
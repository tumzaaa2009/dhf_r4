<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>จัดการผู้ป่วย</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        จัดการผู้ป่วย
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
                                                        $rs_code = $db_saraburi->prepare($sql_code);
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
                                                        $sql_amphur = "SELECT * FROM dhf_ampur WHERE PRO_CODE = '19' AND AMP_CODE = '$token->dhf_area'";
                                                        $rs_amphur = $db_saraburi->query($sql_amphur);
                                                        $rs_amphur->execute();
                                                        $result_amphur = $rs_amphur->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <?php foreach($result_amphur as $row_amphur){ ?> 
                                                        <option value="<?php echo $row_amphur['AMP_CODE'];?>"><?php echo "อ.".$row_amphur['AMP_NAME'];?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        จัดการผู้ป่วย
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
                <!-- ./ Content -->
                <!-- Footer -->
                <?php include("footer.php"); ?>
                <!-- ./ Footer -->
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
        <div class="modal fade" id="diseaseModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div id="diseaseShowModal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="FollowModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1200px;">
                <div class="modal-content">
                    <div id="showFollowModal"></div>
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
        <!-- Dashboard scripts -->
        <script src="../../assets/js/examples/pages/ecommerce-dashboard.js"></script>
        <!-- Datepicker -->
        <script src="../../vendors/datepicker/daterangepicker.js"></script>
        <!-- summernote -->
        <script rel="stylesheet" href="../../vendors/summernote/summernote-bs4.min.js"></script>
        <!-- App scripts -->
        <script src="../../assets/js/app.min.js"></script>
        <script src="../../vendors/leaflet/leaflet.js"></script>
        <script src="../../vendors/leaflet/easy-button.js"></script>
        <script src="../../vendors/leaflet/js/leaflet.extra-markers.min.js"></script>
        <script src="../../js/check_disease.js"></script>
        <script>
            $(document).ready(function () {
                //----------------------------------------
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: "YYYY-MM-DD",
                    }
                });
                //----------------------------------------
                check_disease();
                LoadPatient();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
            });
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
            }
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
                                        $("#ImportSubmit").html("<i class='fas fa-upload mr-1'></i> นำเข้าข้อมูล D.H.F");
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
            var mymap;
            var geojson = "";
            function MapManage(E0) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexPatient/formMap.php",{"E0":E0},function(){
                    if (mymap != undefined) { mymap.remove(); }
                    mymap = L.map('map');
                    
                    if(geojson != ""){
                        if(geojson != ""){
                            mymap.removeLayer(geojson);
                        }
                    }
                    $.ajax({
                        type: "POST",
                        url: "ajax/indexPatient/getGeojson.php",
                        data: { btnGeojson: "01" },
                        dataType: "json",
                        success: function(result) {

                            mymap.setView([14.65, 100.91667], 10);
                            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2s5amx6OGowMDA1djNlczNvdTYwenQ0OCJ9.6S9AQ3BZS6zIt_eDLMhFfg', {
                                attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                id: 'mapbox.satellite',
                                accessToken: 'pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2p4eWJ2YzFyMDhvazNucGViczV0YzNhMSJ9.km2olU7scxqSE8GkIFTSZA',
                            }).addTo(mymap);;
                            geojson = new L.GeoJSON(result, {
                                style: style,
                            }).addTo(mymap);

                            var marker = L.marker(new L.LatLng($("#lat").val(),$("#lon").val()),{
                                draggable: true
                            }).addTo(mymap);
                            
                            var circle = L.circle(new L.LatLng($("#lat").val(),$("#lon").val()), {
                                color: "red",
                                fillColor: "#f03",
                                fillOpacity: 0.1,
                                radius: $("#radius").val()
                            }).addTo(mymap);

                            marker.on('dragend', function (e) {
                                mymap.panTo(new L.LatLng(marker.getLatLng().lat,marker.getLatLng().lng));
                                document.getElementById('lat').value = marker.getLatLng().lat;
                                document.getElementById('lon').value = marker.getLatLng().lng;
                                circle.setLatLng(new L.LatLng(marker.getLatLng().lat,marker.getLatLng().lng));
                            });

                            $("#radius").change(function () { 
                                circle.setRadius($(this).val());
                            });
                        }
                    });
                    /*--------------------------------------------------------*/
                    $("#MapSubmit").click(function() {
                        let lat = $('#lat').val();
                        let lon = $('#lon').val();
                        let radius = $('#radius').val();
                        if(lat == "" || lon == "" || lat == "0" || lon == "0"){
                            toastr.info('กรุณาเลือกพิกัด!');
                            return false;
                        }
                        if(radius == ""){
                            toastr.info('กรุณาใส่รัศมีอย่างน้อย 0');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการบันทึกพิกัด ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('MapManage');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexPatient/Map.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('บันทึกพิกัดข้อมูลสำเร็จ!');
                                            LoadPatient();
                                        }else if(result.result == "2"){
                                            toastr.warning('ไม่มีการแก้ไขข้อมูล!');
                                        }else if(result.result == "0"){
                                            toastr.warning('บันทึกพิกัดไม่ข้อมูลสำเร็จ กรุณาลองใหม่อีกครั้ง!');
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
            function style(feature) {
                return {
                    fillColor: '#fff',
                    weight: 2,
                    opacity: 1,
                    color: '#ED5455',
                    dashArray: '3',
                    fillOpacity: 0.01
                };
            }
            function EditPatient(E0,DATESICK) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexPatient/formEdit.php",{ "E0":E0, "DATESICK":DATESICK },function(){
                    $('.datepicker_form').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        drops: 'up',
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                    $("#PatientEditSubmit").click(function() {
                        let NAME = $('#NAME').val();
                        let gender = $('#gender').val();
                        let age = $('#age').val();
                        let OCCUPAT = $('#OCCUPAT').val();
                        let nation = $('#nation').val();
                        let address_all = $('#address_all').val();
                        let ADDRCODE = $('#ADDRCODE').val();
                        let HSERV = $('#HSERV').val();
                        let DATESICK = $('#DATESICK').val();
                        let DATEDEFINE = $('#DATEDEFINE').val();
                        let Rerx = $('#Rerx').val();
                        let Typept = $('#Typept').val();
                        if(NAME == "" || gender == "" || age == "" || OCCUPAT == "" || nation == "" || address_all == "" || ADDRCODE == "" || HSERV == "" || DATESICK == "" || DATEDEFINE == "" || Rerx == "" || Typept == ""){
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
                                let myForm = document.getElementById('EditPatient');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexPatient/Edit.php',
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
                                            LoadPatient();
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
            function DeletePatient(E0,DATESICK) {
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
                            url: "ajax/indexPatient/Delete.php",
                            data: {E0:E0,DATESICK:DATESICK},
                            dataType: "json",
                            success: function (result) {
                                if(result.result == "1"){
                                    toastr.success("แจ้งเตือน","ลบผู้ป่วย E0 ที่ : "+E0+" สำเร็จ!");
                                    $("#tr_" + E0 + "-" + DATESICK).fadeOut(1000);
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
            function DetailPatient(E0,DATESICK) {
                $('#myModal').modal('show');
                $("#showModal").load("ajax/indexPatient/formDetail.php",{"E0":E0, "DATESICK":DATESICK});
            }
            function getOption506() {
                $.ajax({
                    type: "POST",
                    url: "ajax/indexPatient/getOption506.php",
                    dataType: "html",
                    success: function (response) {
                        $("#id_506").html(response);
                    }
                });
            }
/*-------------------------------------------------------------------------------------------------------------------------------------------*/
            function LoadPatientFollow(E0,DATESICK) {
                $('#FollowModal').modal('show');
                $('#showFollowModal').load("ajax/indexPatientFollow/FormShowData.php",{"E0":E0,"DATESICK":DATESICK},function(){
                    $('#dataTableFollow').DataTable({
                        searching: true,
                        paging: true,
                        info: true,
                        responsive: true,
                        ordering: false,
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100, 500, 1000] ,
                    });
                });
            }
            function AddPatientFollow(E0,DATESICK) {
                $('#subModal').modal('show');
                $('#showSubModal').load("ajax/indexPatientFollow/FormAdd.php",{"E0":E0,"DATESICK":DATESICK},function(){
                    $('.datepicker_follow').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        drops: 'up',
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                    $("#FollowAddSubmit").click(function() {
                        var follow_date = $('#follow_date').val();
                        var follow_detail = $('#follow_detail').val();
                        if(follow_detail == "" || follow_date == ""){
                            toastr.info('กรุณากรอกข้อมูลให้ครบ!');
                            return false;
                        }
                        swal({
                            title: "แจ้งเตือน",
                            text: "ยืนยันการบันทึกข้อมูล ?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: false,
                        }).then((Confirm) => {
                            if (Confirm) {
                                let myForm = document.getElementById('AddPatientFollow');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexPatientFollow/Add.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#subModal').modal('hide');
                                            toastr.success('เพิ่มข้อมูลสำเร็จ!');
                                            LoadPatientFollow(E0,DATESICK);
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
            function EditPatientFollow(follow_id,E0,DATESICK) {
                $('#subModal').modal('show');
                $('#showSubModal').load("ajax/indexPatientFollow/FormEdit.php",{"E0":E0,"follow_id":follow_id,"DATESICK":DATESICK},function(){
                    $('.datepicker_follow').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        drops: 'up',
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                    $("#FollowEditSubmit").click(function() {
                        var follow_date = $('#follow_date').val();
                        var follow_detail = $('#follow_detail').val();
                        if(follow_detail == "" || follow_date == ""){
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
                                let myForm = document.getElementById('EditPatientFollow');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/indexPatientFollow/Edit.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#subModal').modal('hide');
                                            toastr.success('แก้ไขข้อมูลสำเร็จ!');
                                            LoadPatientFollow(E0,DATESICK);
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
            function DeletePatientFollow(follow_id,E0,DATESICK) {
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
                            url: "ajax/indexPatientFollow/Delete.php",
                            data: {E0:E0,follow_id:follow_id,DATESICK:DATESICK},
                            dataType: "json",
                            success: function (result) {
                                if(result.result == "1"){
                                    toastr.success("แจ้งเตือน","ลบการติดตามผู้ป่วยสำเร็จ!");
                                    $("#tr_" + follow_id).fadeOut(1000);
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
        </script>
    </body>
</html>

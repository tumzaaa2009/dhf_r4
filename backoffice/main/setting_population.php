<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>จัดการประชากร</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        จัดการประชากร
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
                                <div class="card-header">
                                    <div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="PopulationAdd()"><i class="fas fa-users fa-fa-1x mr-1"></i> เพิ่มประชากร</button>
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
        <!-- App scripts -->
        <script src="../../assets/js/app.min.js"></script>
        <script src="../../js/check_disease.js"></script>
        <script>
            $(document).ready(function () {
                check_disease();
                LoadPopulation();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
            });
            function LoadPopulation() {
                $('#showTable').load("ajax/settingPopulation/getTable.php",function(){
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
            function PopulationAdd() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/settingPopulation/formAdd.php",function(){
                    $("#PopulationAddSubmit").click(function() {
                        let year = $('#year').val();
                        let population = $('#population').val();
                        if(year == "" || population == ""){
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
                                    url: 'ajax/settingPopulation/Add.php',
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
                                            LoadPopulation();
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
            function PopulationEdit(year) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/settingPopulation/formEdit.php",{"year":year},function(){
                    $("#PopulationEditSubmit").click(function() {
                        let year = $('#year').val();
                        let population = $('#population').val();
                        if(year == "" || population == ""){
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
                                    url: 'ajax/settingPopulation/Edit.php',
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
                                            LoadPopulation();
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
            function DetailPopulation(year) {
                $('#myModal').modal('show');
                $("#showModal").load( "ajax/settingPopulation/formDetail.php",{"year":year},function(){
                    $('#dataTableLvl1').DataTable({
                        searching: true,
                        paging: false,
                        info: false,
                        responsive: true,
                        ordering: false,
                    });
                    $('#dataTableLvl2').DataTable({
                        searching: true,
                        paging: false,
                        info: false,
                        responsive: true,
                        ordering: false,
                    });
                    $('#dataTableLvl3').DataTable({
                        searching: true,
                        paging: true,
                        info: false,
                        responsive: true,
                    });
                });
            }
            function DeletePopulation(year) {
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
                            url: "ajax/settingPopulation/Delete.php",
                            data: {year:year},
                            dataType: "json",
                            success: function (result) {
                                if(result.result == "1"){
                                    toastr.success("แจ้งเตือน","ลบปี : "+year+" สำเร็จ!");
                                    $("#tr_" + year).fadeOut(1000);
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
            function AMPlPopulation(year) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/settingPopulation/formAMP.php",{"year":year},function(){
                    $("#PopulationAddSubmit").click(function() {
                        let year = $('#year').val();
                        if(year == ""){
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
                                let myForm = document.getElementById('form-add-amp');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/settingPopulation/AddAmp.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('บันทึกข้อมูลสำเร็จ!');
                                            LoadPopulation();
                                        }else if(result.result == "0"){
                                            toastr.warning('บันทึกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
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
            function TUMPopulation(year) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/settingPopulation/formTUM.php",{"year":year},function(){
                    $("#PopulationTUMAddSubmit").click(function() {
                        let year = $('#year').val();
                        if(year == ""){
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
                                let myForm = document.getElementById('form-add-tum');
                                let formData = new FormData(myForm);
                                $.ajax({
                                    url: 'ajax/settingPopulation/AddTum.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#myModal').modal('hide');
                                            toastr.success('บันทึกข้อมูลสำเร็จ!');
                                            LoadPopulation();
                                        }else if(result.result == "0"){
                                            toastr.warning('บันทึกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!');
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
            function LoadTumForm(value){
                let AMP_CODE = value.value;
                let year = $(value).find(':selected').attr('data-year');
                if(AMP_CODE != 0){
                    $.ajax({
                    type: "POST",
                    url: "ajax/settingPopulation/formTumTable.php",
                    data: {AMP_CODE:AMP_CODE, year:year},
                    dataType: "html",
                    success: function (result) {
                        $("#ShowTumTable").fadeIn();
                        $("#ShowTumTable").html(result);
                    }
                });
                }else{
                    $("#ShowTumTable").html('<div class="text-center">- โปรดเลือกอำเภอ -</div>'); 
                }
            }
        </script>
    </body>
</html>

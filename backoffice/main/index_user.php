<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>จัดการผู้ใช้งาน</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        จัดการผู้ใช้งาน
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
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>อำเภอ</label>
                                                    <select class="form-control" id="ampur" name="ampur" onchange="Call(this);">
                                                        <option value="0">ทั้งหมด</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>ตำบล</label>
                                                    <select class="form-control" id="tumbol" name="tumbol" onchange="LoadUser();" disabled>
                                                        <option value="0">ทั้งหมด</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>ระดับผู้ใช้งาน</label>
                                                    <select class="form-control" id="level" name="level" onchange="LoadUser();">
                                                        <option value="0">ทั้งหมด</option>
                                                        <option value="1">ระดับจังหวัด</option>
                                                        <option value="2">ระดับอำเภอ</option>
                                                        <option value="3">ระดับตำบล</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group">
                                                    <label>สถานะ</label>
                                                    <select class="form-control" id="status" name="status" onchange="LoadUser();">
                                                        <option value="1">ใช้งาน</option>
                                                        <option value="0">ยกเลิก</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="UserAdd()"><i class="fas fa-user fa-fa-1x mr-1"></i> เพิ่มผู้ใช้งาน</button>
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
                LoadUser();
                getAmphur();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
            });
            function LoadUser() {
                let ampur = $("#ampur").val();
                let tumbol = $("#tumbol").val();
                let level = $("#level").val();
                let status = $("#status").val();
                $('#showTable').load("ajax/indexUser/getTable.php",{"ampur":ampur,"tumbol":tumbol,"level":level,"status":status},function(){
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
            function Call(value) {
                LoadUser();
                getTambon(value);
            }
            function getAmphur() {
                $.ajax({
                    type: "POST",
                    url: "ajax/indexUser/getAmphur.php",
                    dataType: "html",
                    success: function (result) {
                        $("#ampur").html(result);
                    }
                });
            }
            function getTambon(value) {
                let amphur = value.value;
                if(amphur != "0"){
                    $("#tumbol").prop("disabled", false);
                }else{
                    $("#tumbol").prop("disabled", true);
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/indexUser/getTambon.php",
                    data: {amphur:amphur},
                    dataType: "html",
                    success: function (result) {
                        $("#tumbol").html(result);
                    }
                });
            }
            function getTambonForm(value) {
                let amphur = value.value;
                if(amphur != "0"){
                    $("#dhf_area").prop("disabled", false);
                }else{
                    $("#dhf_area").prop("disabled", true);
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/indexUser/getTambonForm.php",
                    data: {amphur:amphur},
                    dataType: "html",
                    success: function (result) {
                        $("#dhf_area").html(result);
                    }
                });
            }
            function UserAdd() {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexUser/formAdd.php",function(){
                    $("#dhf-user").focus();
                    $("#UserAddSubmit").click(function() {
                        let dhf_user = $('#dhf_user').val();
                        let dhf_pass = $('#dhf_pass').val();
                        let dhf_fullname = $('#dhf_fullname').val();
                        let dhf_level = $('#dhf_level').val();
                        let dhf_status = $('#dhf_status').val();
                        if(dhf_user == "" || dhf_pass == "" || dhf_fullname == "" || dhf_level == "0"|| dhf_status == ""){
                            toastr.info('กรุณากรอกข้อมูลให้ครบ!');
                            return false;
                        }
                        if(dhf_level == "2"){
                            let dhf_area = $("#dhf_area").val();
                            if(dhf_area == "0"){
                                toastr.info('กรุณาเลือกพื้นที่ระดับอำเภอ!');
                                return false;
                            }
                        }else if(dhf_level == "3"){
                            let dhf_ampur = $("#dhf_ampur").val();
                            let dhf_area = $("#dhf_area").val();
                            if(dhf_ampur == "0" || dhf_area == "0"){
                                toastr.info('กรุณาเลือกพื้นที่ระดับตำบล!');
                                return false;
                            }
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
                                    url: 'ajax/indexUser/Add.php',
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
                                            LoadUser();
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
            function UserEdit(dhf_id) {
                $('#myModal').modal('show');
                $('#showModal').load("ajax/indexUser/formEdit.php",{"dhf_id":dhf_id},function(){
                    $("#dhf-user").focus();
                    $("#UserEditSubmit").click(function() {
                        let dhf_user = $('#dhf_user').val();
                        let dhf_fullname = $('#dhf_fullname').val();
                        let dhf_level = $('#dhf_level').val();
                        let dhf_status = $('#dhf_status').val();
                        if(dhf_fullname == "" || dhf_level == "0"|| dhf_status == ""){
                            toastr.info('กรุณากรอกข้อมูลให้ครบ!');
                            return false;
                        }
                        if(dhf_level == "2"){
                            let dhf_area = $("#dhf_area").val();
                            if(dhf_area == "0"){
                                toastr.info('กรุณาเลือกพื้นที่ระดับอำเภอ!');
                                return false;
                            }
                        }else if(dhf_level == "3"){
                            let dhf_ampur = $("#dhf_ampur").val();
                            let dhf_area = $("#dhf_area").val();
                            if(dhf_ampur == "0" || dhf_area == "0"){
                                toastr.info('กรุณาเลือกพื้นที่ระดับตำบล!');
                                return false;
                            }
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
                                    url: 'ajax/indexUser/Edit.php',
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
                                            LoadUser();
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
            function UserDelete(dhf_id) {
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
                            url: "ajax/indexUser/Delete.php",
                            data: {dhf_id:dhf_id},
                            dataType: "json",
                            success: function (result) {
                                if(result.result == "1"){
                                    toastr.success("แจ้งเตือน","ลบผู้ใช้งานลำดับที่ : "+dhf_id+" สำเร็จ!");
                                    $("#tr_" + dhf_id).fadeOut(1000);
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
            function getArea(value) {
                let level = value.value;
                $.ajax({
                    type: "POST",
                    url: "ajax/indexUser/formArea.php",
                    data: {level:level},
                    dataType: "html",
                    success: function (result) {
                        $("#ShowFormLevel").html(result);
                    }
                });
            }
        </script>
    </body>
</html>

<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>จัดการ HI CI</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        จัดการ HI CI
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
                                                <select class="form-control" id="year" name="year" onchange="LoadHICI();">
                                                    <?php
                                                        $months = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
                                                        $sql_year = "SELECT dcl1.* FROM dhf_calendar_lvl1 dcl1 ORDER BY dcl1.year DESC";
                                                        $rs_year = $db_saraburi->prepare($sql_year);
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
                                                <label for="month">เดือน </label>
                                                <select class="form-control" id="month" name="month" onchange="LoadHICI();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == date('m')){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="ampur">อำเภอ</label>
                                                <select class="form-control" id="ampur" name="ampur" onchange="LoadHICI();">
                                                    <?php
                                                        $sql_amphur = "SELECT * FROM dhf_ampur WHERE PRO_CODE = '19'";
                                                        $rs_amphur = $db_saraburi->query($sql_amphur);
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
                        </div>
                        <div class="col-md-12"> 
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="ExportDataHICI()"><i class="fas fa-file-export mr-1"></i> ส่งออกข้อมูล HI CI</button>
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
        <div class="modal fade" id="HICIModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" style="max-width:1200 px; max-height: 800px;">
                <div class="modal-content">
                    <div id="showHICIModal"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="subModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
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
                LoadHICI();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
            });
            function LoadHICI() {
                let year = $("#year").val();
                let month = $("#month").val();
                let ampur = $("#ampur").val();
                $('#showTable').load("ajax/indexHICI/getTable.php",{year:year, month:month, ampur:ampur},function(){
                    $('#dataTable').DataTable({
                        searching: true,
                        paging: true,
                        info: true,
                        responsive: true,
                        order: [[ 0, "asc" ]],
                        lengthMenu: [15, 25, 50, 100, 500,1000] ,
                    });
                });
            }
            function ManageHICI(year,month,ampur) {
                $('#HICIModal').modal('show');
                $('#showHICIModal').load("ajax/indexHICI/FormManage.php",{"year":year,"month":month,"ampur":ampur},function(){
                    $('.datepicker').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        drops: 'up',
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                    $("#AddFormSubmit").click(function() {
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
                                    url: 'ajax/indexHICI/Add.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    data: formData,
                                    success : function (result) {
                                        if(result.result == "1"){
                                            $('#HICIModal').modal('hide');
                                            toastr.success('เพิ่มข้อมูลสำเร็จ!');
                                            LoadHICI();
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
            function SetAddRowReport(){
                let AMP_CODE_temp = $("#AMP_CODE_temp").val();
                let TUM_CODE_group = $("input[name='TUM_CODE[]']").map(function() { return $(this).val(); }).get();
                $('#subModal').modal('show');
                $('#showSubModal').load("ajax/indexHICI/FormSet.php",{"AMP_CODE_temp":AMP_CODE_temp,"TUM_CODE_group":TUM_CODE_group},function() {
                    $("#SetFormSubmit").click(function() {
                        let TUM_CODE_SET = $('#TUM_CODE_SET').val();
                        if (TUM_CODE_SET == "0") {
                            toastr.info('เพิ่มข้อมูลให้ครบ ตามที่กำหนด');
                            return false;
                        }
                        AddRowReport(TUM_CODE_SET);
                        $('#subModal').modal('hide');
                    });
                });
            }
            function AddRowReport(TUM_CODE_SET) {
                let year_temp = $("#year_temp").val();
                let month_temp = $("#month_temp").val();
                let AMP_CODE_temp = $("#AMP_CODE_temp").val();
                let count_report = parseFloat($("#count_report").val());
                let next_count = count_report + 1;
                $.ajax({
                    url: 'ajax/indexHICI/AddRowReport.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        param : count_report,
                        TUM_CODE_SET : TUM_CODE_SET,
                        year_temp : year_temp,
                        month_temp : month_temp,
                        AMP_CODE_temp : AMP_CODE_temp,
                    },
                success: function (data) {
                    $('#table_report tbody').append(data);
                    $("#count_report").val(next_count);
                    $('.datepicker').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        drops: 'up',
                        locale: {
                            format: "YYYY-MM-DD",
                        }
                    });
                }
                });
            }
            function ExportDataHICI() {
                let year = $("#year").val();
                let month = $("#month").val();
                let ampur = $("#ampur").val();
                window.open('ajax/indexHICI/ExportExcel.php?year='+year+'&month='+month+'&ampur='+ampur, '_blank');
            }
            function DeleteHTML(position) {
                $("#report_"+position).fadeOut(200, function() {
                    $("#report_"+position).remove();
                });
            }
        </script>
    </body>
</html>

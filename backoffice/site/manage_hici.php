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
                                    <li class="breadcrumb-item">
                                        <a href="index_hi_ci.php">จัดการ HI CI</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?php
                                            $months = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
                                            $sql_ampur_name = "SELECT AMP_NAME AS result FROM dhf_ampur WHERE AMP_CODE = '".$_GET["ampur"]."'";
                                            $ampur_name = GetSqlData($sql_ampur_name);
                                            echo $ampur_name." (ปี ".$_GET["year"]." เดือน ".$months[$_GET["month"]].")";
                                        ?>
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
                                        จัดการ HI CI : <?php echo $ampur_name." (ปี ".$_GET["year"]." เดือน ".$months[$_GET["month"]].")"?>
                                    </div>
                                </div>
                                <?php
                                    $year = $_GET["year"];
                                    $month = $_GET["month"];
                                    $ampur = $_GET["ampur"];
                                ?>
                                <div class="card-body">
                                    <form enctype="multipart/form-data" id="form-add">
                                        <input type="hidden" id="year_temp" name="year_temp" value="<?php echo $year; ?>">
                                        <input type="hidden" id="month_temp" name="month_temp" value="<?php echo $month; ?>">
                                        <input type="hidden" id="AMP_CODE_temp" name="AMP_CODE_temp" value="<?php echo $ampur; ?>">
                                        <div class="row" id="ShowData">
                                         
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="Back();">ปิด</button>
                                    <button type="button" class="btn btn-sm btn-primary" id="AddFormSubmit" onclick="AddHICI();">ยืนยัน</button>
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
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
                LoadHICI();
            });
            function LoadHICI() {
                let year = $("#year_temp").val();
                let month = $("#month_temp").val();
                let ampur = $("#AMP_CODE_temp").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/indexHICI/FormManage.php",
                    data: {
                        year:year,
                        month:month,
                        ampur:ampur,
                    },
                    dataType: "html",
                    success: function (response) {
                        $("#ShowData").html(response);
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
            function AddHICI() {
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
            function DeleteHTML(position) {
                $("#report_"+position).fadeOut(200, function() {
                    $("#report_"+position).remove();
                });
            }
            function Back() {
                location.assign("index_hi_ci.php");
            }
        </script>
    </body>
</html>

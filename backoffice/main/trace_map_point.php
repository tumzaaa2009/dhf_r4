<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>ติดตามการลงพิกัดแผนที่</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        ติดตามการลงพิกัดแผนที่
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
                                                <input type="text" class="form-control datepicker" id="date_start" name="date_start" onchange="LoadData();" value="<?php echo date("Y-m-d", strtotime("01-01-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">วันที่สิ้นสุด <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_end" name="date_end" onchange="LoadData();" value="<?php echo date("Y-m-d", strtotime("31-12-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadData();">
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
                                                <select class="select2" id="ampur" name="ampur[]" multiple onchange="LoadData();">
                                                    <?php
                                                        $sql_amphur = "SELECT * FROM dhf_ampur WHERE PRO_CODE = '19'";
                                                        $rs_amphur = $db_saraburi->query($sql_amphur);
                                                        $rs_amphur->execute();
                                                        $result_amphur = $rs_amphur->fetchAll(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <?php foreach($result_amphur as $row_amphur){ ?> 
                                                        <option value="<?php echo $row_amphur['AMP_CODE'];?>"><?php echo $row_amphur['AMP_NAME'];?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-main"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        ติดตามการลงพิกัดแผนที่
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
        <!-- Select2 -->
        <script src="../../vendors/select2/js/select2.min.js"></script>
        <!-- Datepicker -->
        <script src="../../vendors/datepicker/daterangepicker.js"></script>
        <!-- App scripts -->
        <script src="../../assets/js/app.min.js"></script>
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
                
                LoadData();
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: "YYYY-MM-DD",
                    }
                });
                $('#ampur').select2({ placeholder: 'เลือกทั้งหมด' });
            });
            function LoadData() {
                LoadPoint();
                getChartMainHeader();
            }
            function LoadPoint() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                $('#showTable').load("ajax/traceMapPoint/getTable.php",{"date_start":date_start, "date_end":date_end, "id_506":id_506, "ampur":ampur},function(){
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
            function getChartMainHeader(){
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                $.ajax({
                    type: "POST",
                    url: "ajax/traceMapPoint/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        ampur:ampur,
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: 'scrollstackedcolumn2d',
                            renderAt: 'chart-container',
                            width: '100%',
                            height: '400',
                            dataFormat: 'json',
                            dataSource: {
                                "chart": {
                                    "caption": "แสดงร้อยการลงข้อมูลพิกัดบนแผนที่",
                                    "numvisibleplot": "6",
                                    "showvalues": "1",
                                    "decimals": "1",
                                    "stack100percent": "1",
                                    "valuefontcolor": "#FFFFFF",
                                    "theme": "fusion"
                                },
                                "categories" : response.categories,
                                "dataset" : response.dataset
                            }   
                        }

                        $("#chart-container-main").insertFusionCharts(chartConfigs);
                    }
                });
            }
        </script>
    </body>
</html>

<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>ติดตามการลงข้อมูล HI CI</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        ติดตามการลงข้อมูล HI CI
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
                                                <select class="form-control" id="year" name="year" onchange="LoadData();">
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
                                                <select class="form-control" id="month" name="month" onchange="LoadData();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == date('m')){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="ampur">อำเภอ</label>
                                                <select class="form-control" id="ampur" name="ampur" onchange="LoadData();">
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
                                        จัดการ HI CI
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
            });
            function LoadData() {
                LoadHICI();
                getChartMainHeader();
            }
            function LoadHICI() {
                let year = $("#year").val();
                let month = $("#month").val();
                let ampur = $("#ampur").val();
                $('#showTable').load("ajax/traceHICI/getTable.php",{year:year, month:month, ampur:ampur},function(){
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
                let year = $("#year").val();
                let month = $("#month").val();
                let ampur = $("#ampur").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/traceHICI/GetChartMain.php",
                    data: { 
                        year:year,
                        month:month,
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
                                    "caption": "แสดงร้อยการลงข้อมูล HICI ประจำเดือน",
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

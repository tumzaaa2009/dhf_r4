<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>หน้าแรก</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active">
                                        <a href="index.php">หน้าแรก</a>
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
                    <?php
                        $sql_patient = "SELECT COUNT(*) AS result
                        FROM dhf_patient WHERE DATESICK BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31' AND DISEASE IN ($token->group_id_506)";
                        $CountPatient = GetSqlData($sql_patient);

                        $sql_die = "SELECT COUNT(*) AS result
                        FROM dhf_patient WHERE DATESICK BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31' AND DISEASE IN ($token->group_id_506) AND Rerx = 'ตาย'";
                        $CountDie = GetSqlData($sql_die);

                        $sql_population = "SELECT population AS result FROM dhf_population_lvl1 WHERE year = '".date('Y')."'";
                        $PopulationYear = GetSqlData($sql_population);
                    ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card bg-info">
                                <div class="card-body">
                                    <h6 class="card-title d-flex justify-content-between">
                                        จำนวนผู้ป่วย (ปี <?php echo date('Y'); ?>)
                                        <small class="opacity-7">จำนวนประชากร <?php echo ($PopulationYear != "" ? number_format($PopulationYear) : "0") ?> คน</small>
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="font-size-35"><?php echo ($CountPatient != "" ? number_format($CountPatient) : "0") ?></div>
                                        <div class="icon-block icon-block-xl icon-block-floating icon-block-outline-white opacity-7">
                                            <i class="fas fa-user-injured"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        คิดเป็น <?php echo ($CountPatient != "" && $PopulationYear != "" ? number_format(($CountPatient*100000)/$PopulationYear,2) : "0.00") ?> ต่อแสนประชากร
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card bg-danger">
                                <div class="card-body">
                                    <h6 class="card-title d-flex justify-content-between">
                                        จำนวนผู้ป่วยเสียชีวิต (ปี <?php echo date('Y'); ?>)
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="font-size-35"><?php echo ($CountDie != "" ? number_format($CountDie) : "0") ?></div>
                                        <div class="icon-block icon-block-xl icon-block-floating icon-block-outline-white opacity-7">
                                            <i class="far fa-dizzy"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        คิดเป็น <?php echo ($CountDie != "" && $PopulationYear != "" ? number_format(($CountDie*100000)/$PopulationYear,2) : "0.00") ?> ต่อแสนประชากร
                                    </p>
                                </div>
                            </div>
                        </div class=" text-primary">
                    </div>
                    <?php
                        $BgCode = array("1" => "bg-primary", "2" => "bg-info", "3" => "bg-secondary", "4" => "bg-success","5" => "bg-danger","6" => "bg-warning");
                        $TextCode = array("1" => "text-primary", "2" => "text-info", "3" => "text-secondary", "4" => "text-success","5" => "text-danger","6" => "text-warning");

                        $sql_group = "SELECT dp.NDIS,COUNT(dp.E0) AS CountGroup 
                        FROM dhf_patient dp 
                        WHERE dp.DISEASE IN ($token->group_id_506) AND dp.DATESICK BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-12-31'
                        GROUP BY dp.DISEASE
                        ORDER BY dp.DISEASE DESC";
                        $rs_group = $db_saraburi->prepare($sql_group);
                        $rs_group->execute();
                        $results_group = $rs_group->fetchAll();
                        $iBg = 1;
                        $iText = 1;
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="card-title">สัดส่วนกลุ่มโรค (ปี <?php echo date('Y'); ?>)</h6>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px">
                                        <?php foreach($results_group as $row_group){ ?> 
                                            <div class="progress-bar <?php echo $BgCode[$iBg]; ?>" role="progressbar" style='width: <?php echo ($CountPatient != "" && $row_group["CountGroup"] != "" ? number_format(($row_group["CountGroup"]/$CountPatient)*100,2)."%" : "0.00%") ?>'></div>  
                                        <?php $iBg++; } ?>
                                    </div>
                                    <div class="row">
                                    <?php foreach($results_group as $row_group){ ?> 
                                        <div class="col">
                                            <p class="mb-0">
                                                <span class="fa fa-circle <?php echo $TextCode[$iText]; ?> mr-1"></span>
                                                <?php echo $row_group["NDIS"]; ?>
                                            </p>
                                            <h5 class="mt-2 mb-0"><?php echo ($CountPatient != "" && $row_group["CountGroup"] != "" ? number_format(($row_group["CountGroup"]/$CountPatient)*100,2)."%" : "0.00%") ?></h5>
                                        </div>
                                    <?php $iText++; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-01">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-02">
                                    
                                    </div>
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

        <!-- FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/fusioncharts.js"></script>
        <!-- jQuery-FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/integrations/jquery/js/jquery-fusioncharts.js"></script>
        <!-- Fusion Theme -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>

        <script>
            $(document).ready(function () {
                check_disease();
                getChartMain01();
                getChartMain02();
            });
            function getChartMain01(){
                let btnChartMain = "01";
                $.ajax({
                    type: "POST",
                    url: "ajax/viewIndex/GetChartMain.php",
                    data: {btnChartMain:btnChartMain},
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "bar2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "จำนวนผู้ป่วยสะสม แยกรายกลุ่มอายุ",
                                    //"subCaption": "In MMbbl = One Million barrels",
                                    "xAxisName": "ช่วงอายุ",
                                    "yAxisName": "จำนวนผู้ป่วย สะสม",
                                    "slantLabel": "1",
                                    "showValues": "1",
                                    "labelDisplay": "rotate",
                                    "labelFontSize": "12",
                                    "exportEnabled": "1",
                                    "theme": "fusion",
                                },
                                "data": response
                            }
                        }

                        $("#chart-container-01").insertFusionCharts(chartConfigs);
                    }
                });
            }
            function getChartMain02(){
                let btnChartMain = "02";
                $.ajax({
                    type: "POST",
                    url: "ajax/viewIndex/GetChartMain.php",
                    data: {btnChartMain:btnChartMain},
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "column2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "จำนวนผู้ป่วยสะสม แยกรายอำเภอ",
                                    //"subCaption": "In MMbbl = One Million barrels",
                                    "xAxisName": "อำเภอ",
                                    "yAxisName": "จำนวนผู้ป่วย สะสม",
                                    "slantLabel": "1",
                                    "showValues": "1",
                                    "labelDisplay": "rotate",
                                    "labelFontSize": "12",
                                    "exportEnabled": "1",
                                    "theme": "fusion",
                                },
                                "data": response
                            }
                        }
                        $("#chart-container-02").insertFusionCharts(chartConfigs);
                    }
                });
            }
        </script>
    </body>
</html>

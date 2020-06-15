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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="date_start">วันที่เริ่ม <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_start" name="date_start" onchange="LoadFunction();" value="<?php echo date("Y-m-d", strtotime("01-01-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="date_end">วันที่สิ้นสุด <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_end" name="date_end" onchange="LoadFunction();" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadFunction();">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
   
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-main"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-01"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-02"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-03"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-04"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-container-week"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $sql_code = "SELECT * FROM dhf_ampur ORDER BY AMP_CODE ASC";
                        $rs_code = $db_saraburi->prepare($sql_code);
                        $rs_code->execute();
                        $results_code = $rs_code->fetchAll();
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                            <h5><i class="fas fa-table mb-3"></i> <b>ตารางรายละเอียดผู้ป่วย จำแนกรายอำเภอ</b></h5>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="ampur">อำเภอ <span class="text-danger">*</span></label>
                                                <select class="form-control" id="ampur" name="ampur" onchange="getTableMain()">
                                                    <option value="0">เลือก</option>
                                                    <?php foreach($results_code as $row_code){ ?> 
                                                        <option value="<?php echo $row_code['AMP_CODE'];?>"><?php echo $row_code['AMP_NAME'];?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div id="ShowMainTable">
                                                    
                                            </div>
                                        </div>
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
                LoadFunction();
                /*----------------------*/
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: "YYYY-MM-DD",
                    }
                });
            });
            function LoadFunction(){
                getChartMainHeader();
                getChartMain01();
                getChartMain02();
                getChartMain03();
                getChartMain04();
                getChartMainWeek();
                getTableMain();
            }
            function getChartMainHeader(){
                let btnChartMain = "Main";
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: 'mscombidy2d',
                            renderAt: 'chart-container',
                            width: '100%',
                            height: '400',
                            dataFormat: 'json',
                            dataSource: {
                                "chart": {
                                    "caption": "แสดงจำนวนผู้ป่วยจำแนกรายวัน และ สะสมตามวันเริ่มป่วย",
                                    //"subCaption": "For last year",
                                    "xAxisname": "วันที่",
                                    "pYAxisName": "จำนวนผู้ป่วย ต่อ วัน",
                                    "sYAxisName": "จำนวนผู้ป่วย สะสม",
                                    "slantLabel": "1",
                                    "showValues": "0",
                                    "labelDisplay": "rotate",
                                    "labelFontSize": "12",

                                    "exportEnabled": "1",
                                    "sYAxisMaxValue": "100",
                                    //Cosmetics
                                    "divlineAlpha": "100",
                                    "divlineColor": "#999999",
                                    "divlineThickness": "1",
                                    "divLineIsDashed": "1",
                                    "divLineDashLen": "1",
                                    "divLineGapLen": "1",
                                    "usePlotGradientColor": "0",
                                    "anchorRadius": "3",
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
            function getChartMain01(){
                let btnChartMain = "01";
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "column2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "อัตราต่อแสนประชากร แยกรายอำเภอ",
                                    //"subCaption": "In MMbbl = One Million barrels",
                                    "xAxisName": "อำเภอ",
                                    "yAxisName": "อัตราต่อแสนประชากร",
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
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
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
            function getChartMain03(){
                let btnChartMain = "03";
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "pie2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "ร้อยละของผู้ป่วย จำแนกตามโรค",
                                    "exportEnabled": "1",
                                    "theme": "fusion",
                                },
                                "data": response
                            }
                        }

                        $("#chart-container-03").insertFusionCharts(chartConfigs);
                    }
                });
            }
            function getChartMain04(){
                let btnChartMain = "04";
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "pie2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "ร้อยละของผู้ป่วย จำแนกตามเพศ",
                                    "exportEnabled": "1",
                                    "theme": "fusion",
                                },
                                "data": response
                            }
                        }

                        $("#chart-container-04").insertFusionCharts(chartConfigs);
                    }
                });
            }
            function getChartMainWeek(){
                let btnChartMain = "Week";
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetChartMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        btnChartMain:btnChartMain
                    },
                    dataType: "json",
                    success: function (response) {
                        const chartConfigs = {
                            type: "column2d",
                            width: "100%",
                            height: "400",
                            dataFormat: "json",
                            dataSource: {
                                "chart": {
                                    "caption": "จำนวนผู้ป่วย จำแนกตามสัปดาห์",
                                    "xAxisName": "สัปดาห์",
                                    "yAxisName": "จำผู้ป่วยต่อสัปดาห์",
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
                        $("#chart-container-week").insertFusionCharts(chartConfigs);
                    }
                });
            }
            function getTableMain(){
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("#ampur").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewChartMain/GetTableMain.php",
                    data: { 
                        date_start:date_start,
                        date_end:date_end,
                        id_506:id_506,
                        ampur:ampur,
                    },
                    dataType: "html",
                    success: function (result) {
                        $("#ShowMainTable").html(result);
                        if(ampur != 0){
                            $('#dataTable').DataTable({
                                searching: false,
                                paging: false,
                                info: false,
                                responsive: true,
                                "order": [[ 4, "desc" ]]
                            });
                        }else{
                            $('#dataTable').DataTable({
                                searching: false,
                                paging: false,
                                info: false,
                                responsive: true,
                                "order": [[ 3, "desc" ]]
                            });
                        }
                    }
                });
            }  
        </script>
    </body>
</html>

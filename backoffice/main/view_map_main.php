<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>แผนที่แสดงการเกิดโรค</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        แผนที่แสดงการเกิดโรค
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
                                                <select class="form-control" id="year" name="year" onchange="LoadMap();">
                                                    <?php
                                                        $months = array(1=>'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
                                                        $sql_year = "SELECT dcp1.* FROM dhf_population_lvl1 dcp1 ORDER BY dcp1.year DESC";
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
                                                <label for="date_start">เดือนเริ่มต้น </label>
                                                <select class="form-control" id="date_start" name="date_start" onchange="LoadMap();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == 1){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">เดือนสิ้นสุด </label>
                                                <select class="form-control" id="date_end" name="date_end" onchange="LoadMap();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == date("m")){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadMap();">
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
                                                <label>อัตราป่วย</label>
                                                <select class="form-control" id="scale_type" name="scale_type" onchange="LoadMap();">
                                                    <option value="0">0 > 5 > 10 > 20</option> 
                                                    <option value="1" selected>0 > 20 > 30 > 50</option> 
                                                    <option value="2">0 > 50 > 100 > 150</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="map_dhf"></div>
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
        <!-- Select2 -->
        <script src="../../vendors/select2/js/select2.min.js"></script>
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
                check_disease();
                LoadMap();
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
            var type_map = 1;
            var geojson_ampur = "";
            var geojson_tumbol = "";
            var info = L.control();
            var mymap = L.map('map_dhf');
            var legend = L.control({position: 'bottomright'});

            function LoadMap() {
                type_map = 1;
                let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();

                if(geojson_ampur != ""){
                    if(geojson_ampur != ""){
                        mymap.removeLayer(geojson_ampur);
                    }
                    if(geojson_tumbol != ""){
                        mymap.removeLayer(geojson_tumbol);
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapMain/getMap.php",
                    data: {date_start:date_start, date_end:date_end, year:year, id_506:id_506, type_map:type_map, scale_type:scale_type},
                    dataType: "json",
                    success: function(result) {
                        if(geojson_ampur != ""){
                            if(geojson_ampur != ""){
                                mymap.removeLayer(geojson_ampur);
                            }
                            if(geojson_tumbol != ""){
                                mymap.removeLayer(geojson_tumbol);
                            }
                        }
                        mymap.setView([14.65, 100.91667], 10);
                        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2s5amx6OGowMDA1djNlczNvdTYwenQ0OCJ9.6S9AQ3BZS6zIt_eDLMhFfg', {
                            attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 15,
                            minZoom: 9,
                            id: 'mapbox.streets',
                            accessToken: 'pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2p4eWJ2YzFyMDhvazNucGViczV0YzNhMSJ9.km2olU7scxqSE8GkIFTSZA'
                        }).addTo(mymap);

                        geojson_ampur = new L.GeoJSON(result, {
                            style: style,
                            onEachFeature: onEachFeature,
                        }).addTo(mymap);

                        legend.addTo(mymap);
                    }
                });
            }
            function style(feature) {
                return {
                    fillColor: feature.properties.color,
                    weight: 2,
                    opacity: 1,
                    color: '#222',
                    dashArray: '3',
                    fillOpacity: feature.properties.opacity,
                };
            }
            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature,
                });
            }
            function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 4,
                    color: '#DDD',
                    dashArray: '',
                    fillOpacity: 0.5
                });
                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                    layer.bringToFront();
                }
                info.update(layer.feature.properties);
            }
            function resetHighlight(e) {
                geojson_ampur.resetStyle(e.target);
                info.update();
            }
            //-----------------------------------------------------------------------------------------------
            function zoomToFeature(e) {
                type_map = 2;
                resetButton.enable();
                var layer = e.target;
                mymap.fitBounds(e.target.getBounds());
                mymap.removeLayer(geojson_ampur);
                let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapMain/getMap.php",
                    data: {date_start:date_start, date_end:date_end, year:year, id_506:id_506, type_map:type_map, ampur:layer.feature.properties.id, scale_type:scale_type},
                    dataType: "json",
                    success: function(response) {
                        geojson_tumbol = new L.GeoJSON(response, {
                            style: styleTumbol,
                            onEachFeature: onEachFeatureTumbol
                        }).addTo(mymap);
                    }
                });
            }
            function styleTumbol(feature) {
                return {
                    fillColor: feature.properties.color,
                    weight: 2,
                    opacity: 1,
                    color: '#222',
                    dashArray: '3',
                    fillOpacity: feature.properties.opacity,
                };
            }
            function onEachFeatureTumbol(feature, layer) {
                layer.on({
                    mouseover: highlightFeatureTumbol,
                    mouseout: resetHighlightTumbol,
                });
            }
            function highlightFeatureTumbol(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 4,
                    color: '#DDD',
                    dashArray: '',
                    fillOpacity: 0.5
                });
                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                    layer.bringToFront();
                }
                info.update(layer.feature.properties);
            }
            function resetHighlightTumbol(e) {
                geojson_ampur.resetStyle(e.target);
                info.update();
            }
            //-----------------------------------------------------------------------------------------------
            var resetButton = L.easyButton('fas fa-reply' ,function(btn, map){  
                type_map = 1;
                let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                var id = $("#id_report_"+map._container.dataset.tabreport).val(); 

                mymap.removeLayer(geojson_tumbol);

                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapMain/getMap.php",
                    data: {date_start:date_start,date_end:date_end, year:year, id_506:id_506,type_map:type_map,scale_type:scale_type},
                    dataType: "json",
                    success: function(result) {
    
                        geojson_ampur = new L.GeoJSON(result, {
                            style: style,
                            onEachFeature: onEachFeature,
                        }).addTo(mymap);

                    }
                });
                map.setView([14.65, 100.91667], 10);
                resetButton.disable();
            }).addTo(mymap);
            resetButton.disable();
            
            info.onAdd = function (mymap) {
                this._div = L.DomUtil.create('div', 'info-leafletjs'); // create a div with a class "info"
                this.update();
                return this._div;
            };
            info.update = function (props) {
                if(type_map == 1){
                    this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>อ." + props.name + "<br></h4>"+"<b> จ.สระบุรี</b><br><br>"
                    +"จำนวนผู้ป่วย : <span class='text-dark font-weight-bold'>"+props.CountPatient+" คน </span><br>"
                    +"จำนวนประชากรในอำเภอ :<span class='text-dark font-weight-bold'> "+props.Population+" คน </span><br>"
                    +"คิดเป็น <span class='text-dark font-weight-bold'>"+props.RatePopulation+" ต่อแสนประชากร</span>"
                    : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                }else{
                    this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>ต." + props.name + "<br></h4>"+"<b> อ." + props.ampur + " จ.สระบุรี</b><br><br>"
                    +"จำนวนผู้ป่วย : <span class='text-dark font-weight-bold'>"+props.CountPatient+" คน</span><br>"
                    +"จำนวนประชากรในตำบล : <span class='text-dark font-weight-bold'>"+props.Population+" คน</span><br>"
                    +"คิดเป็น <span class='text-dark font-weight-bold'>"+props.RatePopulation+" ต่อแสนประชากร</span>"
                    : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                }
            };
            info.addTo(mymap);
            legend.onAdd = function (mymap) {
                let Scale = [
                    [0,5,10,20],
                    [0,20,30,50],
                    [0,50,100,150]
                ];
                let scale_type = $("#scale_type").val();

                text_legend = "<div class='mb-1'><i style='background: #fff'></i> อัตราป่วยต่อแสนประชากร : 0</div>"
                +"<div class='mb-1'><i style='background: #28A745'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][0]+" - "+Scale[scale_type][1]+"</div>"
                +"<div class='mb-1'><i style='background: #ffff4d'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][1]+" - "+Scale[scale_type][2]+"</div>"
                +"<div class='mb-1'><i style='background: #FF7C2C'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][2]+" - "+Scale[scale_type][3]+"</div>"
                +"<div class='mb-1'><i style='background: #DC3545'></i> อัตราป่วยต่อแสนประชากร : > "+Scale[scale_type][3]+"</div>";

                var div = L.DomUtil.create('div', 'info-lg legend-lg');
                div.innerHTML = text_legend;
                                
                return div;
            };
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

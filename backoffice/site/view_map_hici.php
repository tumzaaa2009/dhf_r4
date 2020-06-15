<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>แผนที่ HI CI</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        แผนที่ HI CI
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
                                                <label for="month">เดือน </label>
                                                <select class="form-control" id="month" name="month" onchange="LoadMap();">
                                                    <?php for ($i=1; $i <= 12 ; $i++) { ?>
                                                        <option value="<?php echo $i;?>" <?php if($i == date('m')){ echo "selected"; } ?>><?php echo $months[$i] ;?></option> 
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">ชนิดแผนที่ </label>
                                                <select class="form-control" id="map_type" name="map_type" onchange="LoadMap();">
                                                    <option value="Amphur">อำเภอ</option>
                                                    <option value="Tumbon">ตำบล</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">HI & CI </label>
                                                <select class="form-control" id="HICI" name="HICI" onchange="LoadMap();">
                                                    <option value="HI">HI</option>
                                                    <option value="CI">CI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="ampur">อำเภอ</label>
                                                <select class="select2" id="ampur" name="ampur[]" multiple onchange="LoadMap();">
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
                $('#ampur').select2({ placeholder: 'เลือกทั้งหมด' });
            });
            var geojson = "";
            var info = L.control();
            var mymap = L.map('map_dhf');
            var legend = L.control({position: 'bottomright'});
            function LoadMap() {
                let year = $("#year").val();
                let month = $("#month").val();
                let map_type = $("#map_type").val();
                let HICI = $("#HICI").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/viewHICI/getMap.php",
                    data: { year: year, month: month, map_type:map_type,HICI:HICI , ampur:ampur},
                    dataType: "json",
                    success: function(result) {
                        if(geojson != ""){
                            if(geojson != ""){
                                mymap.removeLayer(geojson);
                            }
                        }
                        mymap.setView([14.65, 100.91667], 10);
                        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2s5amx6OGowMDA1djNlczNvdTYwenQ0OCJ9.6S9AQ3BZS6zIt_eDLMhFfg', {
                            attribution: 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            maxZoom: 11,
                            minZoom: 9,
                            id: 'mapbox.streets',
                            accessToken: 'pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2p4eWJ2YzFyMDhvazNucGViczV0YzNhMSJ9.km2olU7scxqSE8GkIFTSZA'
                        }).addTo(mymap);

                        geojson = new L.GeoJSON(result, {
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
                    fillOpacity: feature.properties.opacity
                };
            }
            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
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
                geojson.resetStyle(e.target);
                info.update();
            }
            info.onAdd = function (mymap) {
                this._div = L.DomUtil.create('div', 'info-leafletjs'); // create a div with a class "info"
                this.update();
                return this._div;
            };
            info.update = function (props) {
                let map_type = $("#map_type").val();
                let HICI = $("#HICI").val();
                if(map_type == "Amphur"){
                    if(HICI == "HI"){
                        this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>อ." + props.name + "<br></h4>"+"<b> จ.สระบุรี</b><br>"
                        +"ร้อยละของบ้านที่พบลูกน้ำยุงลาย : <span class='text-dark font-weight-bold'>"+(props.HICI != "" ? props.HICI : 'ไม่มีการบันทึก')+" </span><br>"
                        : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                    }else{
                        this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>อ." + props.name + "<br></h4>"+"<b> จ.สระบุรี</b><br>"
                        +"ร้อยละภาชนะที่พบลูกน้ำยุงลาย : <span class='text-dark font-weight-bold'>"+(props.HICI != "" ? props.HICI : 'ไม่มีการบันทึก')+" </span><br>"
                        : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                    }
                }else{
                    if(HICI == "HI"){
                        this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>ต." + props.name + "<br></h4>"+"<b> อ." + props.ampur + " จ.สระบุรี</b><br><br>"
                        +"ร้อยละของบ้านที่พบลูกน้ำยุงลาย : <span class='text-dark font-weight-bold'>"+(props.HICI != "" ? props.HICI : 'ไม่มีการบันทึก')+" </span>"
                        : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                    }else{
                        this._div.innerHTML = (props ?  "<h4 class='text-dark font-weight-bold'>ต." + props.name + "<br></h4>"+"<b> อ." + props.ampur + " จ.สระบุรี</b><br><br>"
                        +"ร้อยละภาชนะที่พบลูกน้ำยุงลาย : <span class='text-dark font-weight-bold'>"+(props.HICI != "" ? props.HICI : 'ไม่มีการบันทึก')+" </span>"
                        : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                    }
                }
            };
            info.addTo(mymap);
            legend.onAdd = function (mymap) {
      
                let HICI = $("#HICI").val();
                if(HICI == "HI"){
                    text_legend = "<div class='mb-1'><i style='background: #000'></i> ไม่มีการบันทึก</div>"
                    +"<div class='mb-1'><i style='background: #DC3545'></i> พบลูกน้ำยุงลายเกินร้อยละ 50</div>"
                    +"<div class='mb-1'><i style='background: #FF7C2C'></i> พบลูกน้ำยุงลายในช่วงร้อยละ 10 - 50</div>"
                    +"<div class='mb-1'><i style='background: #28A745'></i> พบลูกน้ำยุงลายในช่วงร้อยละ 0 - 10</div>";
                }else if(HICI == "CI"){
                    text_legend = "<div class='mb-1'><i style='background: #000'></i> ไม่มีการบันทึก</div>"
                    +"<div class='mb-1'><i style='background: #DC3545'></i> พบลูกน้ำยุงลายเกินร้อยละ 10</div>"
                    +"<div class='mb-1'><i style='background: #FF7C2C'></i> พบลูกน้ำยุงลายในช่วงร้อยละ 5 - 10</div>"
                    +"<div class='mb-1'><i style='background: #28A745'></i> พบลูกน้ำยุงลายในช่วงร้อยละ 0 - 5</div>";
                }

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

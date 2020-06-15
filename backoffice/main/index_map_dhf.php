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
                                        <div class="col-lg-2 col-md-6">
                                            <div class="form-group">
                                                <label for="year">ปี </label>
                                                <select class="form-control" id="year" name="year" onchange="LoadMap();">
                                                    <?php
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
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="week">สัปดาห์ </label>
                                                <select class="form-control" id="week" name="week" onchange="LoadMap();">
                                                    <?php
                                                        $sql_week = "SELECT dcl2.* FROM dhf_calendar_lvl2 dcl2 WHERE dcl2.year = '".date('Y')."' ORDER BY dcl2.week ASC";
                                                        $rs_week = $db_saraburi->prepare($sql_week);
                                                        $rs_week->execute();
                                                        $results_week = $rs_week->fetchAll();

                                                        $sql_check_week = "SELECT WEEK('".date('Y-m-d')."',2) AS week ";
                                                        $rs_check_week = $db_saraburi->prepare($sql_check_week);
                                                        $rs_check_week->execute();
                                                        $row_check = $rs_check_week->fetchAll();
                                                    ?>
                                                    <?php foreach($results_week as $row_week){ ?> 
                                                        <option value="<?php echo $row_week['week'];?>" data-start="<?php echo $row_week['start_date'];?>" data-end="<?php echo $row_week['end_date'];?>" <?php if($row_week['week'] ==  $row_check[0]['week']){ echo "selected"; }?>><?php echo "สัปดาห์ที่ ".$row_week['week']." (".thai_date_short(strtotime($row_week['start_date']))." - ".thai_date_short(strtotime($row_week['end_date'])).")" ;?></option> 
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
                let week = $("#week").val();
                let start_date = $("#week").find(':selected').attr('data-start');
                let end_date = $("#week").find(':selected').attr('data-end');
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapDhf/getMap.php",
                    data: { year: year, week: week, start_date:start_date,end_date:end_date ,id_506:id_506, ampur:ampur},
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
                            maxZoom: 15,
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
                this._div.innerHTML = (props ?  '<h4>ต.' + props.name + '<br></h4>'+'<b> อ.' + props.ampur + ' จ.สระบุรี</b><br><br>'
                +(props.Week1 != "" ? 'สัปดาห์ที่<b class="text-danger"> ' + props.Week1 + ','+ props.Year1 +'</b><span class="text-dark"> จำนวน : <b>' + props.CountPatient1 + '</b></span>,<span class="text-dark"> เสียชีวิต : <b>' + props.CountDead1 + '</b></span><br>' : "")
                +(props.Week2 != "" ? 'สัปดาห์ที่<b class="text-danger"> ' + props.Week2 + ','+ props.Year2 +'</b><span class="text-dark"> จำนวน : <b>' + props.CountPatient2 + '</b></span>,<span class="text-dark"> เสียชีวิต : <b>' + props.CountDead2 + '</b></span><br>' : "")
                +(props.Week3 != "" ? 'สัปดาห์ที่<b class="text-danger"> ' + props.Week3 + ','+ props.Year3 +'</b><span class="text-dark"> จำนวน : <b>' + props.CountPatient3 + '</b></span>,<span class="text-dark"> เสียชีวิต : <b>' + props.CountDead3 + '</b></span><br>' : "")
                +(props.Week4 != "" ? 'สัปดาห์ที่<b class="text-danger"> ' + props.Week4 + ','+ props.Year4 +'</b><span class="text-dark"> จำนวน : <b>' + props.CountPatient4 + '</b></span>,<span class="text-dark"> เสียชีวิต : <b>' + props.CountDead4 + '</b></span><br>' : "")
                +(props.Week5 != "" ? 'สัปดาห์ที่<b> ' + props.Week5 + ','+ props.Year5 +'</b><span class="text-dark"> จำนวน : <b>' + props.CountPatient5 + '</b></span>,<span class="text-dark"> เสียชีวิต : <b>' + props.CountDead5 + '</b></span><br>' : "")
                : 'เลื่อนเมาส์/Click บริเวณแผนที่');
            };
            info.addTo(mymap);
            legend.onAdd = function (mymap) {
      
                text_legend = "<div class='mb-1'><i style='background: #000'></i> พบผู้ป่วยเสียชีวิต</div>"
                +"<div class='mb-1'><i style='background: #DC3545'></i> พบผู้ป่วย 4 สัปดาห์ต่อเนื่อง</div>"
                +"<div class='mb-1'><i style='background: #FF7C2C'></i> พบผู้ป่วย 3 สัปดาห์</div>"
                +"<div class='mb-1'><i style='background: #F8DC00'></i> พบผู้ป่วย 2 สัปดาห์</div>"
                +"<div class='mb-1'><i style='background: #28A745'></i> พบผู้ป่วย 1 สัปดาห์</div>"
                +"<div class='mb-1'><i style='background: #fff'></i> ไม่พบผู้ป่วย 4 สัปดาห์</div>";

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

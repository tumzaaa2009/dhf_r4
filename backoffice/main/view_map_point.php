<?php include("header.php"); ?>
            <!-- Content body -->
            <div class="content-body">
                <!-- Content -->
                <div class="content">
                    <div class="page-header">
                        <div>
                            <h3>แผนที่แสดงพิกัด</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">หน้าแรก</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        แผนที่แสดงพิกัด
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
                                                <input type="text" class="form-control datepicker" id="date_start" name="date_start" onchange="LoadMapData();" value="<?php echo date("Y-m-d", strtotime("01-01-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label for="date_end">วันที่สิ้นสุด <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" id="date_end" name="date_end" onchange="LoadMapData();" value="<?php echo date("Y-m-d", strtotime("31-12-".date('Y'))); ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>โรค : 506</label>
                                                <select class="form-control" id="id_506" name="id_506" onchange="LoadMapData();">
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
                                                <select class="select2" id="ampur" name="ampur[]" multiple onchange="LoadMapData();">
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
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 mb-3 text-right">
                                            <button type="button" class="btn btn-sm btn-info" onclick="DetailPoint();"><i class="fas fa-info-circle mr-2"></i> รายละเอียดการลงพิกัด</button>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div id="map_dhf"></div>
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
                LoadMapData();
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
            function LoadMapData() {
                LoadMap();
                LoadMarker();
            }
            function DetailPoint() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                $('#myModal').modal('show');
                $("#showModal").load("ajax/viewMapPoint/formDetailPoint.php",{"date_start":date_start, "date_end":date_end, "id_506":id_506, "ampur":ampur});
            }
            var geojson = "";
            var marker = "";
            var circle = "";
            var info = L.control();
            var mymap = L.map('map_dhf');
            function LoadMap() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();
                if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapPoint/getMap.php",
                    data: {date_start:date_start,date_end:date_end ,id_506:id_506, ampur:ampur},
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
                            id: 'mapbox.satellite',
                            accessToken: 'pk.eyJ1IjoiZGV3cGF3YXQiLCJhIjoiY2p4eWJ2YzFyMDhvazNucGViczV0YzNhMSJ9.km2olU7scxqSE8GkIFTSZA'
                        }).addTo(mymap);

                        geojson = new L.GeoJSON(result, {
                            style: style,
                            onEachFeature: onEachFeature,
                        }).addTo(mymap);
                    }
                });
            }
            function style(feature) {
                return {
                    fillColor: '#fff',
                    weight: 2,
                    opacity: 1,
                    color: '#ED5455',
                    dashArray: '3',
                    fillOpacity: 0.01
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
                    fillOpacity: 0.01
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
                this._div.innerHTML = (props ?  '<h4>ต.' + props.name + '<br></h4>'+'<b> อ.' + props.ampur + ' จ.สระบุรี</b><br>' : 'เลื่อนเมาส์/Click บริเวณแผนที่');
            };
            info.addTo(mymap);
/*-------------------------------------------------------------------------------------------------------------------------------------------*/
            function LoadMarker() {
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();

                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapPoint/getMarker.php",
                    data: {date_start:date_start,date_end:date_end ,id_506:id_506, ampur:ampur},
                    dataType: "json",
                    success: function(result) {
                        if(marker != ""){
                            mymap.removeLayer(marker);
                        }
                        if(circle != ""){
                            mymap.removeLayer(circle);
                        }
                        marker = new L.GeoJSON(result, {
                            pointToLayer: pointToLayer,
                            onEachFeature: onEachFeatureMarker,
                        }).addTo(mymap);

                        circle = new L.GeoJSON(result, {
                            pointToLayer: pointToCircle,
                            onEachFeature: onEachFeatureMarker,
                        }).addTo(mymap);
                    }
                });
            }
            function pointToLayer(feature, latlng) {
                return L.marker(latlng, {
                    icon:L.ExtraMarkers.icon({
                        icon: 'fa-number',
                        number: feature.properties.order_list,
                        markerColor: 'cyan',
                        className: 'extra-marker-red',
                        radius: $("#radius").val()
                    })},
                    {draggable:true}
                );
            }
            function pointToCircle(feature, latlng) {
                return L.circle(latlng, {
                    color: "red",
                    fillColor: "#f03",
                    fillOpacity: 0.1,
                    radius: feature.properties.radius,
                });
            }
            function onEachFeatureMarker(feature, layer) {
                layer.bindPopup("<table><tbody>"+
                    "<tr><td class='text-danger' style='width:55px;'>ชื่อผู้ป่วย : </td><td>"+feature.properties.fullname+"</td></tr>"+
                    "<tr><td class='text-danger' style='width:55px;'>โรค : </td><td>"+feature.properties.NDIS+"</td></tr>"+
                    "<tr><td class='text-danger' style='width:55px;'>วันที่ป่วย : </td><td>"+feature.properties.DATESICK+"</td></tr>"+
                    "<tr><td class='text-danger' style='width:55px;'>ที่อยู่ : </td><td>"+feature.properties.address_all+"</td></tr>"+
                    "</tbody></table>");
                layer.on({
                    mouseover: highlightFeatureMarker,
                    mouseout: resetHighlightMarker,
                });
            }
            function highlightFeatureMarker(e) {
                var layer = e.target;
                info.update(layer.feature.properties);
            }
            function resetHighlightMarker(e) {
                geojson.resetStyle(e.target);
                info.update()
            }
        </script>
    </body>
</html>

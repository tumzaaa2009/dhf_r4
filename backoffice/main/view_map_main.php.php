<?php include("header.php"); ?>
<style>
 
#map { width: 100%;height: 75%;}
.mapboxgl-popup {
max-width: 400px;
font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
}
  </style>
            <!-- Content body -->
        <div class="container">  
            <div class="content-body ">
                <!-- Content -->
                <div class="content mt-3">
                    <div class="page-header">
                        <div>
                            <h3>แผนที่แสดงการเกิดโรคอัตราแสน</h3>
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
                                                        $rs_year = $db_r4->prepare($sql_year);
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
                                                        $rs_code = $db_r4->prepare($sql_code);
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
                                        <div class="col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label>จังหวัด</label>
                                                <?php 
                                                 $select_provice = "SELECT * FROM dhf_province";
                                                 $rs_code_provice = $db_r4->prepare($select_provice);
                                                 $rs_code_provice->execute();
                                                 $results_code_provice = $rs_code_provice->fetchAll();?>
                            <select class="select2 form-control" name="ampur[]" id="ampur[]" multiple="multiple" onchange="LoadMap();" >                                             
                        <?php  foreach($results_code_provice as $row_code_province){ ?>
                                                     <option value='<?=$row_code_province['Province_CODE']?>'><?=$row_code_province['Province_NAME']?></option>
                                                     
                                                     <?php } ?>
                                                </select>
                                            </div>
                                        </div>                    


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row" >
                    <div class="col" style="width: 1000px;height: 1000px;">
                            <div id="map" ></div>
                    </div>
                   
                </div>
        
                  </div>
                </div>
    </div>  
 <!-- ./ Content -->

 <section id="summaryr4" class="container" style="margin-top:-15%">
<hr>
<div class="col mt-2" >

                       <div class="row ">
                         <div class="col-12">
                            <div id="table-report4"></div>
                        </div>
                       </div>
                    </div>



 </section>

            </div>
                  <!-- Footer -->
                  <?php include("footer.php"); ?>
                <!-- ./ Footer -->          
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
      
  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="../../assets/vendor/counterup/counterup.min.js"></script>
  <script src="../../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/venobox/venobox.min.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
        <!-- Apex chart -->
        <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
        <script src="../../vendors/charts/apex/apexcharts.min.js"></script>
        <!-- Daterangepicker -->
        <script src="../../vendors/datepicker/daterangepicker.js"></script>
        <!-- DataTable -->
        <script src="../../vendors/dataTable/datatables.min.js"></script>
        <!-- Vamp -->
        <!-- <script src="../../vendors/vmap/jquery.vmap.min.js"></script>
        <script src="../../vendors/vmap/maps/jquery.vmap.usa.js"></script>
        <script src="../../assets/js/examples/vmap.js"></script> -->

            <!-- App scripts -->
            <!-- <script src="../../assets/js/app.min.js"></script> -->
        <!-- <script src="../../vendors/leaflet/leaflet.js"></script>
        <script src="../../vendors/leaflet/easy-button.js"></script>
        <script src="../../vendors/leaflet/js/leaflet.extra-markers.min.js"></script> -->


 
 <script src="../../vendors/leaflet/leaflet.js"></script>
  <script src="../../vendors/leaflet/easy-button.js"></script>
  <script src="../../vendors/leaflet/js/leaflet.extra-markers.min.js"></script> 









        <script src="../../js/check_disease.js"></script>

        <!-- FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/fusioncharts.js"></script>
        <!-- jQuery-FusionCharts -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/integrations/jquery/js/jquery-fusioncharts.js"></script>
        <!-- Fusion Theme -->
        <script type="text/javascript" src="../../vendors/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>

       <!-- SELECT 2 -->
          <script src="../../assets/lib/select2/select2.min.js" ></script>
        <script>
            $(document).ready(function () {
                check_disease();
                $('.select2').select2({placeholder:'เลือกทั้งหมด'});
//////////////////////////////////////////////////
                toastr.options = {
                    timeOut: 3000,
                    progressBar: true,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    showDuration: 200,
                    hideDuration: 200
                };
                LoadMap(); 
                map_get_table();
});



            
function map_get_table(){
    let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();

                $.ajax({
                    type: "POST",
                    url: "ajax/viewMapMain/report_table.php",
                   data: {year:year,date_start:date_start, date_end:date_end, year:year, id_506:id_506, scale_type:scale_type,ampur:ampur},
                    success: function (result) {
                        $("#table-report4").html(result);
                        $('#dataTable').DataTable({
                            searching: true,
                            paging: true,
                            info: true,
                            responsive: true,
                        } );
                    }
                });
            }
// start-map 
var geojson = "";
            var markerall = new Array();
            var markercount = 0;
            var info = L.control();
            var mymap = L.map('map');
            var legend = L.control({position: 'bottomright',right:'15px'});
            
function LoadMap(){
                
                let year = $("#year").val();
                let date_start = $("#date_start").val();
                let date_end = $("#date_end").val();
                let id_506 = $("#id_506").val();
                let scale_type = $("#scale_type").val();
                let ampur = $("select[name='ampur[]']").map(function() { return $(this).val(); }).get();

                if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
                $.ajax({
                type: "POST",
                url: "ajax/viewMapMain/getMap.php",
                data: {year:year,date_start:date_start, date_end:date_end, year:year, id_506:id_506, scale_type:scale_type,ampur:ampur},
                dataType: "json",
                    success: function (result) {
        	// console.log( JSON.stringify(result, null, 2) );
            if(geojson != ""){
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                    if(geojson != ""){
                        mymap.removeLayer(geojson);
                    }
                }
    mymap.createPane('labels');

    // This pane is above markers but below popups
    mymap.getPane('labels').style.zIndex = 650;

    // Layers in this pane are non-interactive and do not obscure mouse/touch events
    mymap.getPane('labels').style.pointerEvents = 'none';

   
mymap.setView([ 14.778866120581371,100.77346801757812], 4);
     L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoidHVtemFhMjAwOSIsImEiOiJja2E3bDRyNnYwNDR6MnlvM2xmNXZzY2prIn0.VTjKIDTqhMnhWYI8LCD5iA', 
     {
                            maxZoom: 11,
                            minZoom: 9,
                            id: 'mapbox.streets',
                            accessToken: 'pk.eyJ1IjoidHVtemFhMjAwOSIsImEiOiJja2E3bDRyNnYwNDR6MnlvM2xmNXZzY2prIn0.VTjKIDTqhMnhWYI8LCD5iA'
                        }).addTo(mymap);

  ///function geo
   geojson = new L.GeoJSON(result, {
                            style:style, // stylesheet location
                            onEachFeature: onEachFeature,
                        }).addTo(mymap);
                        legend.addTo(mymap);
                    
                    }
                });
              }
function onEachFeature(feature, layer) {

// console.log("fuck",feature.properties.name);

                        layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                });
            }
 function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 4,
                    color: '#666',
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
            function style(feature) {
                return {
                    fillColor: feature.properties.color,
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.3
                };
            }
              
            info.onAdd = function (mymap) {
                this._div = L.DomUtil.create('div', 'info-leafletjs'); // create a div with a class "info"
                this.update();
                return this._div;
            };

            info.update = function (props) {
       
                    this._div.innerHTML = (props ?  "<div class='card card-body'><h4 class='text-dark font-weight-bold'>" + props.name + "<br></h4>"+"<br>"
                    +"จำนวนผู้ป่วย : <span class='text-dark font-weight-bold'>"+props.CountPatient+" คน </span><br>"
                    +"จำนวนประชากรในจังหวัด:<span class='text-dark font-weight-bold'> "+props.Population+" คน </span><br>"
                    +"คิดเป็น <span class='text-dark font-weight-bold'>"+props.RatePopulation+" ต่อแสนประชากร</span></div>"
                    : 'เลื่อนเมาส์/Click บริเวณแผนที่');
                 
    
            };
            info.addTo(mymap);
            legend.onAdd = function (mymap) {
       
                let Scale = [
                    [0,5,10,20],
                    [0,20,30,50],
                    [0,50,100,150]
                ];
                let scale_type = $("#scale_type").val();
         
             text_legend = "<div class='card card-body'><h6><div class='mb-1 '><i class='fa fa-circle' aria-hidden='true' style='color: #fff'></i> อัตราป่วยต่อแสนประชากร : 0</div>"
                +"<div class='mb-1'><i class='fa fa-circle' style='color: #28A745' aria-hidden='true'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][0]+" - "+Scale[scale_type][1]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true' style='color: #ffff4d'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][1]+" - "+Scale[scale_type][2]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true' style='color: #FF7C2C'></i> อัตราป่วยต่อแสนประชากร : "+Scale[scale_type][2]+" - "+Scale[scale_type][3]+"</div>"
                +"<div class='mb-1'><i class='fa fa-circle' aria-hidden='true'style='color: #DC3545' ></i> อัตราป่วยต่อแสนประชากร : > "+Scale[scale_type][3]+"</div></h6></div>";

                var div = L.DomUtil.create('div', 'info-lg legend-lg');
                div.innerHTML = text_legend;
                                
                return div;
            };



   
        </script>
    </body>
</html>

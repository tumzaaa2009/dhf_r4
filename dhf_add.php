<?php
    include("include/session_check.php");
    include("include/headder.php");
    include("include/func.php");
?>
    <main id="main">
        <section id="features">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-lg-12 offset-lg-12">
                        <div class="section-header wow fadeIn" data-wow-duration="1s">
                            <h3 class="section-title"><i class="fas fa-table"></i> ตารางจัดแผนที่การระบาด</h3>
                            <span class="section-divider"></span>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 wow fadeIn">
                        <div id="map-add"></div>
                    </div>
                </div>
            </div>
        </section><!-- #features -->

    </main>

    <!--==========================
                Footer
            ============================-->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-lg-left text-center">
                    <div class="copyright">
                        Copyright 2019 @Saraburi Provincial Health Office
                    </div>
                    <div class="credits">
                        <!--
                            All the links in the footer should remain intact.
                            You can delete the links only if you purchased the pro version.
                            Licensing information: https://bootstrapmade.com/license/
                            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Avilon
                            -->
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery-3.3.1.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/popper.js/dist/umd/popper.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/superfish/hoverIntent.js"></script>
    <script src="lib/superfish/superfish.min.js"></script>
    <script src="lib/magnific-popup/magnific-popup.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="lib/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="lib/datatables-plugins/integration/bootstrap/4/dataTables.bootstrap4.min.js"></script>
    <script src="lib/datatables-plugins/integration/bootstrap/4/responsive.bootstrap4.min.js"></script>
    <!--toastr JavaScript -->
    <script src="lib/toastr/build/toastr.min.js"></script>
    <!-- confirm -->
    <script src="lib/confirm/jquery-confirm.min.js"></script>

    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            map_get_add();
        });
        toastr.options = {
            "closeButton": false,
            "debug": true,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        function map_get_add() {
            $.ajax({
                type: "POST",
                url: "ajax/manage/covid/manage-form-add-covid.php",
                dataType: "html",
                success: function(result) {
                    $("#map-add").html(result);
                    let row = parseFloat($("#SumRow").val());
                    let col = parseFloat($("#SumCol").val());
                    All_quantity = [...Array(col)].map(e => Array(row).fill(0));
                    Col_quantity = new Array(col).fill(0);
                    Row_quantity = new Array(row).fill(0);
                }
            });
        }

        function MapDataAdd() {
            $.confirm({
                title: 'แจ้งเตื่อน!',
                content: 'ยืนยันการบันทึกข้อมูล!',
                buttons: {
                    confirm: function () {
                        let myForm = document.getElementById('map_add');
                        let formData = new FormData(myForm);
                        $.ajax({
                            url: 'ajax/manage/covid/manage-add-covid.php',
                            type: 'POST',
                            contentType: false,
                            cache: false,
                            processData: false,
                            data: formData,
                            dataType: 'json',
                            success: function(data) {
                                // console.log(data.result);
                                if(data.result == 1){
                                    toastr.success('บันทึกข้อมูลสำเร็จ!');
                                    map_get_add();
                                }else{
                                    toastr.error('บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!!');
                                }
                            }
                        });
                    },
                    cancel: function () {},
                }
            });
        }
        function Back() {
            window.location.assign("index_covit.php");
        }
        function processQuantity(value) {
            let set_quantity = value.value;
            let set_row = Number($(value).attr('data-row'));
            let set_col = Number($(value).attr('data-col'));
            All_quantity[set_col][set_row] = Number(set_quantity);
            // console.log(All_quantity[set_col][set_row]);
            var SumAll = 0;
            Col_quantity = Col_quantity.fill(0);
            Row_quantity = Row_quantity.fill(0);
            var row = parseFloat($("#SumRow").val());
            var col = parseFloat($("#SumCol").val());
            for (var i = 0; i < col; i++) {
                for (var j = 0; j < row; j++) {
                    SumAll = SumAll + Number(All_quantity[i][j]);
                    Row_quantity[j] = Row_quantity[j] + Number(All_quantity[i][j]);
                    Col_quantity[i] = Col_quantity[i] + Number(All_quantity[i][j]);
                }
            }
            for (var i = 0; i < col; i++) {
                $("#SumCol" + i).val(number_format(Number(Col_quantity[i]), 0, '.', ','));
            }
            for (var j = 0; j < row; j++) {
                $("#SumRow" + j).val(number_format(Number(Row_quantity[j]), 0, '.', ','));
            }
            $("#SumAll").val(number_format(Number(SumAll), 0, '.', ','));
        }

        function checkCountEditDetail(col, row) {
            var SumAll = 0;
            Col_quantity = Col_quantity.fill(0);
            Row_quantity = Row_quantity.fill(0);
            for (var i = 0; i < col; i++) {
                for (var j = 0; j < row; j++) {
                    All_quantity[i][j] = Number($("#amount" + i + "-" + j).val());
                }
            }
            for (var i = 0; i < col; i++) {
                for (var j = 0; j < row; j++) {
                    SumAll = SumAll + Number(All_quantity[i][j]);
                    Row_quantity[j] = Row_quantity[j] + Number(All_quantity[i][j]);
                    Col_quantity[i] = Col_quantity[i] + Number(All_quantity[i][j]);
                }
            }
            for (var i = 0; i < col; i++) {
                $("#SumCol" + i).val(number_format(Number(Col_quantity[i]), 0, '.', ','));
            }
            for (var j = 0; j < row; j++) {
                $("#SumRow" + j).val(number_format(Number(Row_quantity[j]), 0, '.', ','));
            }
            $("#SumAll").val(number_format(Number(SumAll), 0, '.', ','));
        }

        function number_format(number, decimals, dec_point, thousands_point) {
            if (number == null || !isFinite(number)) {
                //throw new TypeError("number is not valid");
            }

            if (!decimals) {
                var len = number.toString().split('.').length;
                decimals = len > 1 ? len : 0;
            }

            if (!dec_point) {
                dec_point = '.';
            }

            if (!thousands_point) {
                thousands_point = ',';
            }

            number = parseFloat(number).toFixed(decimals);

            number = number.replace(".", dec_point);

            var splitNum = number.split(dec_point);
            splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
            number = splitNum.join(dec_point);

            return number;
        }
    </script>
</body>

</html>
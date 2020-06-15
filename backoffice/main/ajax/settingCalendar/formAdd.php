<?php 
    date_default_timezone_set("Asia/Bangkok");
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มปีปฏิทินโรคระบาด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form">
            <form enctype="multipart/form-data" id="form-add">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="year"> ปี (ค.ศ.)  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="year" name="year" placeholder="ตัวอย่าง : 2020">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="year_th"> ปี (พ.ศ.) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="year_th" name="year_th" placeholder="ตัวอย่าง : 2563">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="start_date"> วันเริ่มต้น <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="<?php echo date("Y-m-d", strtotime("01-01-".date('Y'))); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="end_date"> วันสิ้นสุด <span class="text-danger">*</span></label>
                            <input type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo date("Y-m-d", strtotime("31-12-".date('Y'))); ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="CalendarAddSubmit">บันทึก</button>
    </div>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลผู้ใช้งาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form">
            <form enctype="multipart/form-data" id="form-add">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_user">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dhf_user" name="dhf_user" placeholder="Username">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_pass">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="dhf_pass" name="dhf_pass" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="dhf_fullname"> ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dhf_fullname" name="dhf_fullname">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_phone">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="dhf_phone" name="dhf_phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_email">อีเมล์</label>
                            <input type="email" class="form-control" id="dhf_email" name="dhf_email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_level">ระดับผู้ใช้งาน <span class="text-danger">*</span></label>
                            <select class="form-control" id="dhf_level" name="dhf_level" onchange="getArea(this)">
                                <option value="0">เลือก</option>
                                <option value="1">ระดับจังหวัด</option>
                                <option value="2">ระดับอำเภอ</option>
                                <option value="3">ระดับตำบล</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="dhf_status">สถานะ <span class="text-danger">*</span></label>
                            <select class="form-control" id="dhf_status" name="dhf_status">
                                <option value="1" selected>ใช้งาน</option>
                                <option value="0">ยกเลิก</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12" id="ShowFormLevel">
                        <div class="text-center mt-3"><p>กรุณาเลือกระดับผู้ใช้งาน <span class="text-danger">*</span></p></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="UserAddSubmit">บันทึก</button>
    </div>
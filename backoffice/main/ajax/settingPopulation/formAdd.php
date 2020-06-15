<?php 
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");


    $sql_year = "SELECT dcl1.* FROM dhf_calendar_lvl1 dcl1 ORDER BY dcl1.year DESC";
    $rs_year = $db_saraburi->prepare($sql_year);
    $rs_year->execute();
    $results_year = $rs_year->fetchAll();
?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มประชากรจังหวัดสระบุรี</h5>
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
                            <select class="form-control" id="year" name="year">
                                <?php foreach($results_year as $row_year){ ?> 
                                    <option value="<?php echo $row_year['year'];?>" <?php if($row_year['year'] == date('Y')){ echo "selected"; } ?>><?php echo "ปี ".$row_year['year'] ;?></option> 
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="year_th"> จำนวนประชากร <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" min="0" id="population" name="population">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success" id="PopulationAddSubmit">บันทึก</button>
    </div>
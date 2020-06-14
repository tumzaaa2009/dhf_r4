<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");

    $ampur = $_POST['ampur'];
    $tumbol = $_POST['tumbol'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    
    if($level != "0"){
        if($level == "1"){
            $sql_level = " AND u.dhf_level = '$level'";
        }else{
            $sql_level = " AND u.dhf_level = '$level'";
            if($ampur != "0"){
                $sql_ampur = " AND LEFT(u.dhf_area,4) = '$ampur'";
            }
            if($tumbol != "0"){
                $sql_tumbol = " AND LEFT(u.dhf_area,6) = '$tumbol'";
            }
        }
    }else{
        if($ampur != "0"){
            $sql_ampur = " AND LEFT(u.dhf_area,4) = '$ampur'";
        }
        if($tumbol != "0"){
            $sql_tumbol = " AND LEFT(u.dhf_area,6) = '$tumbol'";
        }
    }

    $sql = "SELECT u.*, am.AMP_NAME, tb.TUM_NAME
    FROM dhf_user u
    LEFT JOIN dhf_ampur am ON LEFT(u.dhf_area,4) = am.AMP_CODE
    LEFT JOIN dhf_tumbol tb ON LEFT(u.dhf_area,6) = tb.TUM_CODE
    WHERE u.dhf_status = '$status' $sql_level $sql_ampur $sql_tumbol
    ORDER BY u.dhf_id DESC";     
    $rs = $db_saraburi->prepare($sql);
    $rs->execute();
    //echo $rs1->rowCount();
    $results = $rs->fetchAll();
    $i = 1;
?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" style="width:100%">
                <thead class="bg-table-in-page">
                    <tr>
                        <th class="text-center p-2">ลำดับ</th>
                        <th class="text-center p-2">ชื่อ - นามสกุล</th>
                        <th class="text-center p-2">Username</th>
                        <th class="text-center p-2">พื้นที่</th>
                        <th class="text-center p-2">ระดับผู้ใช้</th>
                        <th class="text-center p-2">สถานะ</th>
                        <th class="text-center p-2">แก้ไข</th>
                        <th class="text-center p-2">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) { ?>
                        <tr id="tr_<?php echo $row['dhf_id']; ?>">
                            <td class="text-center p-2"><?php echo $row['dhf_id']; ?></td>
                            <td class="text-center p-2"><?php echo $row['dhf_fullname']; ?></td>
                            <td class="text-center p-2"><?php echo $row['dhf_user']; ?></td>
                            <td class="text-center p-2">
                                <?php 
                                    if($row['dhf_area'] != "19"){
                                        echo ($row['AMP_NAME'] != "" ? "อ.".$row['AMP_NAME'] : "")." ".($row['TUM_NAME'] != "" ? "ต.".$row['TUM_NAME'] : "");
                                    }else{ 
                                        echo "จ.สระบุรี";
                                    }
                                ?>
                            </td>
                            <td class="text-center p-2">
                                <?php
                                    if($row['dhf_level'] == "1"){
                                        if($row['dhf_admin'] == "1"){
                                            echo "<span class='badge bg-secondary-bright text-dark mr-1'>ผู้ดูแลระบบ</span>";
                                        }
                                        echo "<span class='badge bg-secondary-bright text-dark'>ระดับจังหวัด</span>";
                                    }elseif($row['dhf_level'] == "2"){
                                        echo "<span class='badge bg-secondary-bright text-dark'>ระดับอำเภอ</span>";
                                    }elseif($row['dhf_level'] == "3"){
                                        echo "<span class='badge bg-secondary-bright text-dark'>ระดับตำบล</span>";
                                    }
                                ?>
                            </td>
                            <td class="text-center p-2">
                                <?php
                                    if($row['dhf_status'] == "1"){
                                        echo "<span class='badge bg-success-bright text-success'>ใช้งาน</span>";
                                    }elseif($row['dhf_status'] == "0"){
                                        echo "<span class='badge bg-danger-bright text-danger'>ยกเลิก</span>";
                                    }
                                ?>
                            </td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="UserEdit('<?php echo $row['dhf_id'];?>')"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center p-2"><a href="javascript:void(0);" onclick="UserDelete('<?php echo $row['dhf_id'];?>')"><i class="far fa-trash-alt text-danger"></i></a></td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>


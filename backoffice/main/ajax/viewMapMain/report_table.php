<?php
    session_start();
    include("../../../../config/connect.php");
    include("../../../../config/func.php");
    include("../../../../config/jwt.php");
    date_default_timezone_set("Asia/Bangkok");
    /*----------------------------------------------------------REPORT-MAIN.PHP------------------------------------------------------*/

 $year = $_POST["year"];
    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    $id_506 = $_POST["id_506"];
  $ampur = $_POST["ampur"];
    $scale_type = $_POST["scale_type"];  
   $date_start = date('Y-m-01', strtotime("$year-01-01"));
   $date_end = date('Y-m-t', strtotime("$year-12-01"));
$convert_date =  $year+543;

?>



         <div class="col-12" style="border:solid">
         <div><h5 align="center">สรุปภาพรวมอัตราแสนเขตสุขภาพที่ 4 ปี <?=$convert_date?></h5></div>
            <div class="table-responsive-sm">
                <!-- Header Table-->
                <table class="table table-striped table-bordered table-hover" id="dataTable" align="center" style="width:100%">
                    <thead class="bg-table-in-page">
						<tr>	
                            <th class="text-center">จังหวัด</th>
                            <th class="text-center">ผู้ป่วย</th>
                            <th class="text-center">จำนวนประชากรทั้งหมด</th>
                            <th class="text-center">ร้อยละ</th>
						</tr>
					</thead>
                    <tbody>
                   <?php 
                           $sql = "SELECT *
                           ,(SELECT COUNT(patien.E1) FROM dhf_patient_r4 patien
                           WHERE 
                            patien.DATESICK BETWEEN '$date_start' AND '$date_end'
                           AND
                           patien.DISEASE IN ($id_506)
                           AND
                           SUBSTRING(patien.ADDRCODE, 1, 2)=g4.areacode ) AS CountPatient
                           ,((SELECT COUNT(dp.E1) FROM dhf_patient_r4 dp 
                            WHERE 
                            dp.DATESICK BETWEEN '$date_start' AND '$date_end'
                           AND
                           SUBSTRING(dp.ADDRCODE, 1, 2)=g4.areacode
                           AND 
                           dp.DISEASE IN ($id_506))*100000)/dhflvl2.population AS RatePopulation
                           FROM gis_area_r4  g4
                           INNER JOIN dhf_province dh_pro ON dh_pro.Pro_CODE=g4.areacode
                           INNER JOIN dhf_population_lvl2 AS dhflvl2 ON dhflvl2.amp_code=dh_pro.Province_CODE
                           ".$sql_ampur."
                           Where dhflvl2.year=".$year."
                           GROUP BY g4.areacode
                           ORDER BY dh_pro.Province_CODE ASC";
                           $rs = $db_r4->prepare($sql);
                           $rs->execute();
                           $results = $rs->fetchAll();
                           $count=0; 
                           $sum_CountPatient=0;
                           $sum_population = 0;
                           foreach($results as $row) { ?> 
                   <tr align ="center">
                   <td><?=$row['Province_NAME']?></td>
                   <td><?=number_format($row['CountPatient'])?></td>
                   <td><?=number_format($row['population'])?></td>
                   <td><?=number_format($row['RatePopulation'],2)?></td>
            
                   </tr>

                           <?php
                            $sum_CountPatient= $sum_CountPatient+$row['CountPatient'];    
                        $sum_population = $sum_population+$row['population'];
                        
                        
                        }?>
                    </tbody>
                    <tfoot>
    <tr align="center">
      <td>ผลรวมทั้งหมด</td>
      <td><?=number_format($sum_CountPatient) ?></td>
      <td><?=number_format($sum_population) ?></td>
      <td><?=number_format(($sum_CountPatient*100000)/$sum_population,2) ?></td>
    </tr>
  </tfoot>
                </table>
            </div>
        </div>
        <?php

  
?>
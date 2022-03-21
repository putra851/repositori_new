<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap Presensi Kelas " . $namaKelas['class_name'] . "Bulan " . $namaBulan . " " . $namaTahun . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 190mm;'>
<tr valign='top'>
	<td colspan="8" valign='middle'>
		<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value'] ?>
		</div>
		<span style='font-size: 8pt;'><?php echo $setting_address['setting_value'] ?>, Telp. <?php echo $setting_phone['setting_value'] ?></span>
	</td>
</tr>
</table>
<br>
<table border="1">
    <thead>
	<tr>
		<th width='5' rowspan='2'><center>No.</center></th> 
		<th rowspan='2'><center>NIS</center></th> 
		<th rowspan='2'><center>Nama</center></th>
		<th colspan='<?php echo $interval->format("%a")?>'><center><?php echo $namaBulan . ' ' . $namaTahun ?></center></th>
	</tr>
	<tr>
	    
    <?php
        foreach ($daterange as $dt) {
            echo '<th>'.$dt->format("d").'</th>';
        }
    ?>
	</tr>
	</thead>
	<tbody>
	<?php 
	    $no = 1;
	    foreach ($student as $row) :
    ?>
    <tr>
					<td><?php echo $no++ ?></td>
					<td><?php echo $row['student_nis']?></td> 
					<td><?php echo $row['student_full_name']?></td>
        <?php
            foreach ($daterange as $dt) {
                $date = $dt->format("Y-m-d");
                $period_id = $q['p'];
                $month_id = $q['m'];
                $class_id = $q['c'];
                $student_id = $row['student_id'];
                
                $presensi = $this->db->query("SELECT presensi_harian_status FROM presensi_harian WHERE presensi_harian_date = '$date' AND presensi_harian_period_id = '$period_id' AND presensi_harian_month_id = '$month_id' AND presensi_harian_class_id = '$class_id' AND presensi_harian_student_id = '$student_id'")->row_array();
                echo (isset($presensi['presensi_harian_status'])) ? '<td>'.$presensi['presensi_harian_status'].'</td>' : '<td>-</td>';
            }
        ?>
				</tr>
	<?php endforeach ?>
    </tbody>
</table>
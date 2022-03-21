<!DOCTYPE html>
<html>
<head>
	<title><?php echo 'Data Pegawai NIP '.$employee['employee_nip'].' Nama '.$employee['employee_name'] ?></title>
</head>
<body>
    
    <table cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 45mm; padding: 1px 0px 1px 0px;'></td>
			<td align='center' style='font-size: 12pt; width: 100mm; padding: 1px 0px 1px 0px;'><b>RIWAYAT HIDUP</b></td>
			<td align='center' style='font-size: 10pt; width: 45mm; padding: 1px 0px 1px 0px;'></td>
		</tr>
	</table>
	<br>
	<br>
    <table cellpadding='0' border='1' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>I. BIODATA PEGAWAI</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>No. Induk Pegawai</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_nip'] ?></td>
			<td rowspan='12' align='right' style='font-size: 10pt; width: 65mm; padding: 1px 0px 1px 0px;'>
									<?php if (!empty($employee['employee_photo'])) { ?>
									<img src="<?php echo upload_url('employee/'.$employee['employee_photo']) ?>" width="151.181" height="226.772">
									<?php } else { ?>
									<img src="<?php echo media_url('img/user.png') ?>" width="151.181" height="226.772">
									<?php } ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Nama Pegawai</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_name'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Jenis Kelamin</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php if($employee['employee_gender']=='L'){ echo 'Laki-laki'; } else if($employee['employee_gender']=='P'){ echo 'Perempuan'; } else {echo '-'; } ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Tempat, Tanggal Lahir</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_born_place'].', '.pretty_date($employee['employee_born_date'],'d F Y',false) ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Pendidikan Terakhir</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_strata'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Alamat</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_address'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Unit Sekolah</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo ($employee['position_majors_id'] != '99')?$employee['majors_name']:'Lainnya'; ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Jabatan</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['position_name'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Status Kepegawaian</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'>
			<?php 
			    if($employee['employee_category']=='1') {
					echo 'Pegawai Tetap';
				} else if( $employee['employee_category']=='2') {
				    echo 'Pegawai Tidak Tetap';
				} else {
				    echo '-';
				}
			?>
			</td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>No. HP/Telpon</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_phone'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Email</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php echo $employee['employee_email'] ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Masa Kerja</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php
												    $start = date_create($employee['employee_start']);
												    if($employee['employee_end']!='0000-00-00'){
												        $end = date_create($employee['employee_end']); }else{
												        $end = date_create();
												    }
												    
												    $interval = date_diff($start, $end);
												    echo $interval->y.' tahun '.$interval->m.' bulan '.$interval->d.' hari ';
												    ?></td>
		</tr>
		<tr>
			<td align='left' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'>Status</td>
			<td align='center' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'> : </td>
			<td align='left' style='font-size: 10pt; width: 80mm; padding: 1px 0px 1px 0px;'><?php 
												if
												($employee['employee_status']=='1')
												{
												    echo 'Aktif';
												}
												else{
												    echo 'Tidak Aktif';
												}
												?></td>
		</tr>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>II. RIWAYAT PENDIDIKAN</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php
	        $no = 1;
	        foreach($education as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 90mm; padding: 1px 0px 1px 0px;'><?php echo $row['education_name'].' '.$row['education_location'] ?></td>
			<td align='center' style='font-size: 10pt; width: 40mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 55mm; padding: 1px 0px 1px 0px;'><?php echo '('.$row['education_start'].' - '.$row['education_end'].')' ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>III. RIWAYAT SEMINAR DAN PELATIHAN</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php 
	        $no = 1;
	        foreach($workshop as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 90mm; padding: 1px 0px 1px 0px;'><?php echo $row['workshop_organizer'].' '.$row['workshop_location'] ?></td>
			<td align='center' style='font-size: 10pt; width: 25mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 70mm; padding: 1px 0px 1px 0px;'><?php echo '('.pretty_date($row['workshop_start'], 'd F Y', false).' - '.pretty_date($row['workshop_end'], 'd F Y', false).')' ?></td>
		</tr>
		<?php 
		    } 
	    ?>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>IV. DATA KELUARGA</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php 
	        $no = 1;
	        foreach($family as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 60mm; padding: 1px 0px 1px 0px;'><?php echo $row['fam_name']?></td>
			<td align='left' style='font-size: 10pt; width: 50mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 75mm; padding: 1px 0px 1px 0px;'>(<?php 
				                if($row['fam_desc'] == '1'){
				                    echo 'Istri';
				                } else if($row['fam_desc'] == '2'){
				                    echo 'Suami';
				                    
				                } else if($row['fam_desc'] == '3'){
				                    echo 'Anak';
				                } else if($row['fam_desc'] == '4'){
				                    echo 'Ayah';
				                    
				                } else if($row['fam_desc'] == '5'){
				                    echo 'Ibu';
				                } else {
				                    echo 'Lainnya';
				                }
				            ?>)</td>
		</tr>
		<?php 
		    } 
	    ?>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>V. RIWAYAT JABATAN</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php
	        $no = 1;
	        foreach($position as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 90mm; padding: 1px 0px 1px 0px;'><?php echo $row['poshistory_desc'] ?></td>
			<td align='center' style='font-size: 10pt; width: 25mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 70mm; padding: 1px 0px 1px 0px;'><?php echo '('.pretty_date($row['poshistory_start'], 'd F Y', false).' - '.pretty_date($row['poshistory_end'], 'd F Y', false).')' ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>VI. RIWAYAT MENGAJAR</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php 
	        $no = 1;
	        foreach($teaching as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 90mm; padding: 1px 0px 1px 0px;'><?php echo $row['teaching_lesson'].' '.$row['teaching_desc'] ?></td>
			<td align='center' style='font-size: 10pt; width: 25mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 70mm; padding: 1px 0px 1px 0px;'><?php echo '('.pretty_date($row['teaching_start'], 'd F Y', false).' - '.pretty_date($row['teaching_end'], 'd F Y', false).')' ?></td>
		</tr>
		<?php } ?>
	</table>
	<br>
    <table border='1' cellpadding='0' cellspacing='0' style='width: 190mm;'>
		<tr>
			<td align='center' style='font-size: 10pt; width: 190mm; padding: 1px 0px 1px 0px;'><b>VII. DAFTAR PENGHARGAAN</b></td>
		</tr>
	</table>
	<br>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <?php 
	        $no = 1;
	        foreach($achievement as $row){ 
	    ?>
		<tr>
		    <td align='left' style='font-size: 10pt; width: 5mm; padding: 1px 0px 1px 0px;'><?php echo $no++.'.' ?></td>
			<td align='left' style='font-size: 10pt; width: 60mm; padding: 1px 0px 1px 0px;'><?php echo $row['achievement_name']?></td>
			<td align='left' style='font-size: 10pt; width: 50mm; padding: 1px 0px 1px 0px;'></td>
			<td align='right' style='font-size: 10pt; width: 75mm; padding: 1px 0px 1px 0px;'>(<?php echo $row['achievement_year']
				            ?>)</td>
		</tr>
		<?php } ?>
	</table>
</body>
</html>
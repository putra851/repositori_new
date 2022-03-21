<?php

    $filename = 'Template_Update_No_WhatsApp_Ortu_'.$majors['majors_short_name'].'_Kelas_'.$kelas['class_name'];    

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename = ".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
	<table cellpadding='0' cellspacing='0'>
		<tr>
			<th align='center' style='font-size: 8pt; width: 25mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>NIS</b></th>
			<th align='center' style='font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Nama Lengkap</b></th>
			<th align='center' style='font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Unit</b></th>
			<th align='center' style='font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Kelas</b></th>
			<th align='center' style='font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Kamar</b></th>
			<th align='center' style='font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Alamat</b></th>
			<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Nama Ayah</b></th>
			<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>Nama Ibu</b></th>
			<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border: 1px solid #000000; background-color:#4188e0;'><b>No. Whatsapp Ortu</b></th>
			<tr>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:red;'><b>Jangan Diubah</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:red;'><b>Jangan Diubah</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:red;'><b>Jangan Diubah</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:red;'><b>Jangan Diubah</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:red;'><b>Masukkan ID Kamar</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:yellow;'><b>Tidak Wajib Diisi</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:yellow;'><b>Tidak Wajib Diisi</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:yellow;'><b>Tidak Wajib Diisi</b></td>
				<td style='text-align: center; padding: 1px; font-size: 8pt; border: 1px solid #000000; background-color:yellow;'><b>Wajib Diisi</b></td>
			</tr>
		</tr>
		    <?php
			    foreach ($student as $row) {
			?>
				<tr valign='top'>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo "'" . $row['student_nis'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['student_full_name'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['majors_short_name'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['class_name'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['madin_name'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['student_address'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['student_name_of_father'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo $row['student_name_of_mother'] ?></td>
					<td style='padding: 1px; font-size: 8pt; border: 1px solid #000000;'><?php echo "'" . $row['student_parent_phone'] ?></td>
				</tr>
			<?php } ?>
	</table>
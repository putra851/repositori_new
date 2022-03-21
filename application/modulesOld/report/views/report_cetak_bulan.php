<!DOCTYPE html>
<html>
<head>
	<title><?php 
	if($dataKelas->class_name != ''){
	    $kelas = $dataKelas->class_name;
	} else {
	    $kelas = 'Semua Kelas';  
	}
	
	echo 'Laporan_Pembayaran_'.$dataHead->pos_name.'_TA'.$dataHead->period_start.'-'.$dataHead->period_end.'_Kelas_'.$kelas.'_'.pretty_date(date('Y-m-d'),'d F Y',false) ?></title>
</head>
<body>
    <table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 277mm;'>
        	<tr valign='top'>
        		<td style='width: 274mm;' valign='middle'>
        			<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value']; ?>
        			</div>
        			<span style='font-size: 8pt;'><?php echo $setting_address['setting_value']; ?>, Telp. 
        	<?php echo $setting_phone['setting_value']; ?></span>
        		</td>
        	</tr>
        </table>
		<br>
		<table style='width: 277mm;'>
			<tr>
			    <td style='width: 92mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td style='width: 93mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Laporan Pembayaran '.$dataHead->pos_name; ?></b></td>
				<td style='width: 92mm; font-size: 8pt;' align='right'></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 277mm;'>
			<tr>
				<td style='width: 35mm; font-size: 8pt;'>Tahun Ajaran</td>
				<td style='width: 5mm; font-size: 8pt;'>:</td>
				<td style='width: 150mm; font-size: 8pt;'><?php echo $dataHead->period_start.'/'.$dataHead->period_end; ?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Kelas</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $kelas ?></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 277mm;'>
			<tr>
				<th align='center' style='font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>No.</th>
				<th align='center' style='font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>NIS</th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Nama Siswa</th>
				<?php
			    foreach ($dataMonth as $bln) {  
				echo "<th align='center' style='font-size: 8pt; width: 18mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>".substr($bln->month_name,0,3)."</th>";
			    }  ?>
			</tr>
    		<?php
    			$i =1;
			    $sumBulan = 0;
    			foreach ($dataBulan as $row) {
    			 ?>
					<tr valign='top'>
						<td style='padding: 1px; font-size: 8pt; '><?php echo $i++ ?></td>
						<td style='padding: 1px; font-size: 8pt; '><?php echo $row->student_nis ?></td>
						<td style='padding: 1px; font-size: 8pt; '><?php echo $row->student_full_name ?></td>
			<?php
			    foreach($bayarBulan as $key){       
		          if ($key->student_student_id==$row->student_student_id) {
		    ?>
						<td style='padding: 1px; font-size: 8pt; ' align='center'>
			<?php			
			       if($key->bulan_status==1) {
					    echo "Rp ".number_format($key->bulan_bill, 0, ",", ".");
					   echo "<br>";
					   echo date_format(date_create($key->bulan_date_pay),"d/m/Y");
					   $sumBulan += $key->bulan_bill; 
			           
			       } 
					  else { 
					      echo "-";
					      $sumBulan += 0;
					  }
			?>
					 </td>
			<?php	
		            } 
			     }
			?>
					</tr>
		<?php } ?>
		    <tr>
				<td colspan='10' align='right' style='font-size: 8pt; padding: 1px; border-top: 1px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 1px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 1px solid #999999; border-bottom: 0px solid #999999;'> <br><br></td>
			</tr>
			<tr>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><b>Total Pembayaran</b></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><b>Rp <?php echo number_format($sumBulan,0,",",".") ?></b></td>
				<td colspan='10' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
			</tr>
			<tr>
				<td colspan='12' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php echo $setting_city['setting_value']; ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false); ?></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
			</tr>
			<tr>
				<td colspan='10' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
			</tr>
			<tr>
				<td colspan='10' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
			</tr>
			<tr>
				<td colspan='12' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php 
				        echo ucfirst($setting_nama_bendahara['setting_value']);?></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
			</tr>
			<tr>
				<td colspan='12' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php 
				        echo 'NIP. '.ucfirst($setting_nip_bendahara['setting_value']);?></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
			</tr>
		</table>
</body>
</html>
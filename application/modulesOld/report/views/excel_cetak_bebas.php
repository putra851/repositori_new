<?php
if($this->uri->segment('8')!=0){
    $kelas = $dataKelas->class_name;
} else {
    $kelas = 'Semua Kelas';
}
    
$kls = str_replace(" ","-", $kelas);
$pos = str_replace(" ","-", $dataHead->pos_name);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Laporan_Pembayaran_".$pos."_TA_".$dataHead->period_start."-".$dataHead->period_end."_Kelas_".$kls."_".date('d-m-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
    <table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 277mm;'>
        	<tr valign='top'>
        		<td colspan="5" style='width: 55mm;' valign='middle'>
        			<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value']; ?>
        			</div>
        			<span style='font-size: 8pt;'><?php echo $setting_address['setting_value']; ?>, Telp. 
        	<?php echo $setting_phone['setting_value']; ?></span>
        		</td>
        		<td colspan="2" style='width: 219mm;'>
        		    <?php echo " ";?>
        		</td>
        	</tr>
        </table>
		<br>
		<table style='width: 277mm;'>
			<tr>
			    <td colspan="2" style='width: 92mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td colspan="3" style='width: 93mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Laporan Pembayaran '.$dataHead->pos_name; ?></b></td>
				<td colspan="2" style='width: 92mm; font-size: 8pt;' align='right'></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 277mm;'>
			<tr>
				<td style='width: 25mm; font-size: 8pt;'>Tahun Ajaran</td>
				<td colspan='2' style='width: 45mm; font-size: 8pt;'> : <?php echo $dataHead->period_start.'/'.$dataHead->period_end; ?></td>
				<td colspan="4" style='width: 120mm; font-size: 8pt;'> </td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Kelas</td>
				<td colspan="2" style='font-size: 8pt;'> : <?php echo $kelas?></td>
				<td colspan="4" style='font-size: 8pt;'> </td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<th align='center' style='font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>No.</th>
				<th align='center' style='font-size: 8pt; width: 25mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>NIS</th>
				<th align='center' style='font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Nama Siswa</th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Tagihan</th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Sudah Dibayar</th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Kekurangan</th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Keterangan</th>
			</tr>
    		<?php
    			$i =1;
    			$sumBebas = 0;
    			foreach ($dataBebas as $row) {
    			 ?>
					<tr valign='top'>
						<td align='center' style='padding: 1px; font-size: 8pt; '><?php echo $i++ ?></td>
						<td align='center' style='padding: 1px; font-size: 8pt; '><?php echo $row->student_nis ?></td>
						<td style='padding: 1px; font-size: 8pt; '><?php echo $row->student_full_name ?></td>
		                <td style='padding: 1px; font-size: 8pt; '>Rp 
		                    <?php echo number_format($row->bebas_bill, 0, ",", ".") ?>
		                </td>
		                <td style='padding: 1px; font-size: 8pt; '>Rp 
		                    <?php echo number_format($row->bebas_total_pay, 0, ",", ".") ?>
		                </td>
		                <td style='padding: 1px; font-size: 8pt; '>Rp 
		                    <?php echo number_format($row->kekurangan, 0, ",", ".") ?>
		                </td>
		                <td align='center' style='padding: 1px; font-size: 8pt; '>
		                <?php
    					    if ($row->kekurangan<1){ 
    					        echo 'LUNAS';
    					    } else{ 
    					        echo 'BELUM LUNAS';
    					    }
    					?>
		                </td>
					</tr>
					<?php $sumBebas += $row->bebas_total_pay ?>
		    <?php } ?>
		    <tr style="background-color: #F0F0F0;">
	            <td colspan="4" style="padding: 1px; font-size: 8pt;">
	                <b>Total Pembayaran Siswa</b>
	            </td>
	            <td style="padding: 1px; font-size: 8pt;">
	                <b><?php echo 'Rp '.number_format($sumBebas,0,",",".") ?></b>
	            </td>
	            <td colspan="2" style="padding: 1px; font-size: 8pt;">
	            </td>
	        </tr>
		    <tr>
				<td colspan='3' align='right' style='font-size: 8pt; padding: 1px; border-top: 1px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 1px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
			</tr>
			<tr>
				<td colspan='5' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
			</tr>
			<tr>
				<td colspan='3' align='right' style='font-size: 8pt; padding: 1px; bordr-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
			</tr>
			<tr>
				<td colspan='3' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
			</tr>
			<tr>
				<td colspan='5' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php 
				        echo ucfirst($setting_nama_bendahara['setting_value']).'<p></p>NIP. '.ucfirst($setting_nip_bendahara['setting_value']);?></td>
			</tr>
		</table>
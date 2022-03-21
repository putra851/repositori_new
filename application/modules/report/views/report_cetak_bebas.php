<!DOCTYPE html>
<html>
<head>
    <?php
        if($this->uri->segment('8')!=0){
            $kelas = $dataKelas->class_name;
        } else {
            $kelas = 'Semua Kelas';
        }
    ?>
	<title><?php echo 'Laporan_Pembayaran_'.$dataHead->pos_name.'_TA'.$dataHead->period_start.'-'.$dataHead->period_end.'_Kelas_'.$kelas.'_'.pretty_date(date('Y-m-d'),'d F Y',false) ?></title>
</head>
<body>
    <table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 190mm;'>
        	<tr valign='top'>
        		<td style='width: 187mm;' valign='middle'>
        			<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value'] ?>
        			</div>
        			<span style='font-size: 8pt;'><?php echo $setting_address['setting_value'] ?>, Telp. 
        	<?php echo $setting_phone['setting_value'] ?></span>
        		</td>
        	</tr>
        </table>
		<br>
		<table style='width: 190mm;'>
			<tr>
			    <td style='width: 63mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td style='width: 64mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Laporan Pembayaran '.$dataHead->pos_name ?></b></td>
				<td style='width: 63mm; font-size: 8pt;' align='right'></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<td style='width: 35mm; font-size: 8pt;'>Tahun Ajaran</td>
				<td style='width: 5mm; font-size: 8pt;'>:</td>
				<td style='width: 150mm; font-size: 8pt;'><?php echo $dataHead->period_start.'/'.$dataHead->period_end; ?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Kelas</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $kelas?></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<th align='center' style='font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>No.</th>
				<th align='center' style='font-size: 8pt; width: 25mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>NIS</th>
				<th align='center' style='font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Nama Siswa</th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Tagihan</th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Sudah Dibayar</th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;'>Kekurangan</th>
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
				        echo ucfirst($setting_nama_bendahara['setting_value']);?></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
			</tr>
			<tr>
				<td colspan='5' align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php 
				        echo 'NIP. '.ucfirst($setting_nip_bendahara['setting_value']);?></td>
				<td align='right' style='font-size: 8pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
			</tr>
		</table>
</body>
</html>
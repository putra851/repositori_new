<!DOCTYPE html>
<html>
<head> 
	<title><?php echo 'Tagihan Pembayaran '.$student['student_full_name'].' Kelas '.$student['class_name'] ?></title>
</head>
<body>
    <table style='border-bottom: 2px solid black; padding-bottom: 10px; width: 190mm;'>
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
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
		    <tr>
				<td style='width: 35mm; font-size: 8pt;'></td>
				<td style='width: 5mm; font-size: 8pt;'></td>
				<td style='width: 150mm; font-size: 8pt;'></td>
			</tr>
		    <tr>
				<td colspan='3' style='font-size: 8pt;'>Hal : Pemberitahuan Pembayaran Uang Pembelajaran<br><br></td>
			</tr>
		    <tr>
				<td colspan='3' style='font-size: 8pt;'>Kepada Yth. <br> bapak/ibu Orang Tua/Wali Ananda : <br><br></td>
			</tr>
			<tr>
				<td style='font-size: 8pt;'>Nama</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $student['student_full_name']?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>NIS</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $student['student_nis']?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Kelas</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $student['class_name']?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Tahun Ajaran</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $period['period_start'].'/'.$period['period_end']; ?></td>
			</tr>
		    <tr>
				<td colspan='3' style='font-size: 8pt;'><br> </td>
			</tr>
		    <tr>
				<td colspan='3' style='font-size: 8pt;'>Dengan ini kami memberitahukan bahwa bapak/ibu dari ananda tersebut diatas masih memiliki tunggakan dengan rincian sebagai berikut : </td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<th align='center' style='font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px;'></th>
				<th align='center' style='font-size: 8pt; width: 110mm; padding: 1px 0px 1px 0px; border-top: 2px solid black; border-bottom: 2px solid black;'>Nama Tunggakan</th>
				<th align='center' style='font-size: 8pt; width: 10mm; padding: 1px 0px 1px 0px; border-top: 2px solid black; border-bottom: 2px solid black;'></th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px; border-top: 2px solid black; border-bottom: 2px solid black;'>Nominal</th>
				<th align='center' style='font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px;'></th>
			</tr>
    		<?php
			    $billBulan = 0;
			    $billBebas = 0;
    			foreach ($bulan as $row) {
    			 ?>
					<tr valign='top'>
						<td align='center' style='padding: 1px; font-size: 8pt; '></td>
						<td align='left' style='padding: 1px; font-size: 8pt; '><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'].'-'.$row['month_name'] ?>
						</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '>Rp</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '>
						    <?php echo number_format($row['bulan_bill'],0,",",".") ?>
						</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '></td>
					</tr>
					<?php $billBulan += $row['bulan_bill']; ?>
		    <?php 
    			};
		    foreach($bebas as $row) { 
		    ?>
					<tr valign='top'>
						<td align='center' style='padding: 1px; font-size: 8pt; '></td>
						<td align='left' style='padding: 1px; font-size: 8pt; '><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'] ?>
						</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '>Rp</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '>
						    <?php echo number_format($row['bebas_bill']-$row['bebas_total_pay'],0,",",".") ?>
						</td>
						<td align='right' style='padding: 1px; font-size: 8pt; '></td>
					</tr>
                    <?php $billBebas += $row['bebas_bill']-$row['bebas_total_pay']; ?>
			<?php } ?>
		    <tr>
				<td align='right' style='padding: 1px; font-size: 8pt; '></td>
	            <td align="left" style="border-top: 2px solid black; background-color: #F0F0F0; padding: 1px; font-size: 8pt;">
	                <b>Total Tagihan Siswa</b>
	            </td>
						<td align='right' style='border-top: 2px solid black; background-color: #F0F0F0; padding: 1px; font-size: 8pt; '>Rp</td>
	            <td align="right" style="border-top: 2px solid black; background-color: #F0F0F0; padding: 1px; font-size: 8pt;">
	                <b><?php echo number_format($billBulan+$billBebas,0,",",".") ?></b>
	            </td>
				<td align='right' style='padding: 1px; font-size: 8pt; '></td>
	        </tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
		    <tr>
				<td align='left' style='font-size: 8pt; padding: 1px;'>
				    Demikian surat pemberitahuan ini kami sampaikan atas perhatian dan kerjasamanya kami ucapkan terima kasih. Apabila ada kekeliruan dengan surat pemberitahuan ini. Kami mohon bapak/ibu melakukan konfirmasi ke bagian keuangan dengan membawa tanda bukti.<br><br>
				</td>
			</tr>
		    <tr>
				<td align='left' style='font-size: 8pt; padding: 1px;'>
				    Atas perhatian dan partisipasinya kami ucapkan terima kasih. <br><br>
				</td>
			</tr>
	    </table>
	    <br>
	    <table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<th align='center' style='font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px;'></th>
				<th align='center' style='font-size: 8pt; width: 25mm; padding: 1px 0px 1px 0px;'></th>
				<th align='center' style='font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px;'></th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px;'></th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px;'></th>
				<th align='left' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px;'></th>
				<th align='center' style='font-size: 8pt; width: 30mm; padding: 1px 0px 1px 0px;'></th>
			</tr>
			<tr>
				<td colspan='5' align='right' style='font-size: 8pt; padding: 1px;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px;' align='center'><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
			</tr>
			<tr>
				<td colspan='3' align='right' style='font-size: 8pt; padding: 1px; bordr-top: 0px solid black; border-bottom: 0px solid black;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px;'><br><br></td>
			</tr>
			<tr>
				<td colspan='3' align='right' style='font-size: 8pt; padding: 1px;'><br><br></td>
				<td colspan='4' style='font-size: 8pt; padding: 1px;' align='right'><br><br></td>
				<td align='right' style='font-size: 8pt; padding: 1px;'><br><br></td>
			</tr>
			<tr>
				<td colspan='5' align='right' style='font-size: 8pt; padding: 1px;'></td>
				<td colspan='2' style='font-size: 8pt; padding: 1px;' align='center'><?php 
				        echo ucfirst($setting_nama_bendahara['setting_value']);?><br><?php 
				        echo 'NIP. '.$setting_nip_bendahara['setting_value'];?></td>
				<td align='right' style='font-size: 8pt; padding: 1px;'></td>
			</tr>
		</table>
</body>
</html>
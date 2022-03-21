<?php 
    $ds         = $this->uri->segment('4');
	$de         = $this->uri->segment('5');
	$period_id  = $this->uri->segment('6');
	$majors_id  = $this->uri->segment('7');
	
	
	
	if($majors_id=="all"){
	    $unit = "Semua Unit";
	} else {
	    $q  = $this->db->query("SELECT majors_short_name FROM majors WHERE majors_id='$majors_id'")->row_array();
	    $unit = $q['majors_short_name'];
	    
	}
	
	header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=Rekap-Laporan-Kas-Bank-per-Tanggal-".pretty_date($ds, 'd/m/Y', FALSE)."-Sampai-".pretty_date($de, 'd/m/Y', FALSE).".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
?>
<table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 190mm;'>
    	<tr valign='top'>
    		<td colspan='7' valign='middle'>
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
			<td style='width: 24mm; font-size: 8pt; text-align: left'>Unit Sekolah : </td>
			<td style='font-size: 8pt; text-align: left'><?php echo $unit ?></td>
			<td colspan='5' style='font-size: 8pt; text-align: left'></td>
		</tr>
	</table>
	<br>
	<table style='width: 190mm;'>
		<tr>
		    <td colspan='1' style='font-size: 8pt; text-align: center' valign='center'></td>
			<td colspan='5' style='font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Rekap Laporan (Kas Bank) per Tanggal '.pretty_date($ds, 'd F Y', FALSE).' Sampai '.pretty_date($de, 'd F Y', FALSE) ?></b></td>
			<td colspan='1' style='font-size: 8pt;' align='right'></td>
		</tr>
		<tr>
		    <td colspan='1' style='width: 20mm; font-size: 8pt; text-align: center' valign='center'></td>
			<td colspan='5' style='width: 150mm; font-size: 8pt; text-align: center' valign='top' align='center'>Tahun Ajaran <?php echo $dataPeriod['period_start'].'/'.$dataPeriod['period_end'] ?></td>
			<td colspan='1' style='width: 20mm; font-size: 8pt;' align='right'></td>
		</tr>
	</table>
	<br>
	<?php
	    $sumBulanLast = 0;
		foreach($bulanLast as $row){
		    $sumBulanLast += $row['total_bulan_bill'];
		}
		$sumFreeLast = 0;
		foreach($freeLast as $row){
		    $sumFreeLast += $row['total_bebas_pay_bill'];
		}
		$sumKreditLast = 0;
		foreach($kreditLast as $row){
		    $sumKreditLast += $row['total_kredit_value'];
		}
		$sumGajiLast = 0;
		foreach($gajiLast as $row){
		    $sumGajiLast += $row['total_kredit_value'];
		}
		$sumDebitLast = 0;
		foreach($debitLast as $row){
		    $sumDebitLast += $row['total_debit_value'];
		}
	?>
	
	<?php 
	    echo '<b><font size="10px">Penerimaan</font></b> 
	          <table cellpadding="0" cellspacing="0" style="width: 190mm;">
				<tr>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">No.</th>
					<th style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Kode Akun</th>
					<th style="font-size: 8pt; width: 60mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Keterangan</th>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center"></th>
				    <th style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Debit</th>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center"></th>
				    <th style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Kredit</th>
			    </tr>';
			$no       = 1;
			$sumBulan = 0;
		    foreach ($bulan as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['account_code'].'</td>
	                <td style="padding: 1px; font-size: 8pt;">'.wordwrap($row['account_description'],30,"<br>\n").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['total_bulan_bill'], 0, ",", ".").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.' - '.'</td>
			    </tr>';
			    $sumBulan += $row['total_bulan_bill'];
		    } 
		    $sumFree = 0;
		    foreach ($free as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['account_code'].'</td>
	                <td style="padding: 1px; font-size: 8pt;">'.wordwrap($row['account_description'],30,"<br>\n").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['total_bebas_pay_bill'],0,",",".").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.' - '.'</td>
			    </tr>';
			    $sumFree += $row['total_bebas_pay_bill'];
		    }
		    $sumDebit = 0;
		    foreach ($debit as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['account_code'].'</td>
	                <td style="padding: 1px; font-size: 8pt;">'.wordwrap($row['account_description'],30,"<br>\n").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['total_debit_value'],0,",",".").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.' - '.'</td>
			    </tr>';
			    $sumDebit += $row['total_debit_value'];
		    }
		    echo '<tr style="background-color: #d6d4d4">
	                <td colspan="3" style="padding: 1px; font-size: 8pt; text-align: left"><b>Jumlah </b> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"><b>Rp</b></td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'<b>'.number_format($sumBulan+$sumFree+$sumDebit, 0, ",", ".").'</b></td>
	                <td colspan="2" style="padding: 1px; font-size: 8pt; text-align: right"> </td>
			    </tr>';
	echo '</table><br>';
	?>
	<?php 
	    echo '<b><font size="10px">Pengeluaran</font></b>
	          <table cellpadding="0" cellspacing="0" style="width: 190mm;">
				<tr>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">No.</th>
					<th style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Kode Akun</th>
					<th style="font-size: 8pt; width: 60mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Keterangan</th>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center"></th>
				    <th style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Debit</th>
				    <th style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center"></th>
				    <th style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999; text-align: center">Kredit</th>
			    </tr>';
			$no       = 1;
			$sumKredit = 0;
		    foreach ($kredit as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['account_code'].'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: left">'.wordwrap($row['account_description'],30,"<br>\n").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> - </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['total_kredit_value'],0,",",".").'</td>
			    </tr>';
			    $sumKredit += $row['total_kredit_value'];
		    }
			$sumGaji = 0;
		    foreach ($gaji as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['account_code'].'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: left">'.wordwrap($row['account_description'],30,"<br>\n").'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"> - </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['total_kredit_value'],0,",",".").'</td>
			    </tr>';
			    $sumGaji += $row['total_kredit_value'];
		    }
		    echo '<tr style="background-color: #d6d4d4">
	                <td colspan="5" style="padding: 1px; font-size: 8pt; text-align: left"><b>Jumlah </b> </td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"><b>Rp</b></td>
	                <td style="padding: 1px; font-size: 8pt; text-align: center"><b>'.number_format($sumKredit+$sumGaji, 0, ",", ".").'</b></td>
			    </tr>';
	echo '</table><br>';
	?>
	<?php
	    $sumA = $sumBulan + $sumFree + $sumDebit;
	    $sumB = $sumKredit + $sumGaji;
	    $sumLastA = $sumBulanLast + $sumFreeLast + $sumDebitLast;
	    $sumLastB = $sumKreditLast + $sumGajiLast;
	?>
	<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
	    <tr>
			<td style='width: 67mm; font-size: 8pt;'></td>
			<td style='width: 25mm; font-size: 8pt;'></td>
			<td style='width: 1mm; font-size: 8pt;'></td>
			<td style='width: 5mm; font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'></td>
			<td style='width: 40mm; font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'><b>Debit</b></td>
			<td style='width: 5mm; font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'></td>
			<td style='width: 40mm; font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'><b>Kredit</b></td>
		</tr>
		<tr>
			<td style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Sub Total</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumA, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumB, 0, ",", ".") ?></td>
		</tr>
		<tr>
			<td style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Saldo Awal</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($saldoAwal['nominal']+$sumLastA-$sumLastB, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'> </td>
			<td style='font-size: 8pt; text-align: center'>-</td>
		</tr>
		<tr>
			<td style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Total</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($saldoAwal['nominal']+$sumA+$sumLastA, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumB+$sumLastB, 0, ",", ".") ?></td>
		</tr>
		<tr>
			<td style='font-size: 8pt; text-align: center'></td>
			<td style='font-size: 8pt;'><strong>Saldo Akhir</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format(($saldoAwal['nominal']+$sumLastA+$sumA)-($sumLastB+$sumB),0,",",".") ?></td>
			<td style='font-size: 8pt; text-align: center'> </td>
			<td style='font-size: 8pt; text-align: center'>-</td>
		</tr>
	</table>
	<br>
	<br>
	<table cellpadding="0" cellspacing="0" style="width: 190mm">
		<tr>
			<td colspan="4" align='right' style='width: 140mm; font-size: 8pt;'></td>
			<td colspan="3" style='font-size: 8pt;' align='center'><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
		</tr>
		<tr>
			<td colspan="4" style='font-size: 8pt;'><br><br></td>
			<td colspan="3" style='font-size: 8pt;' align='right'><br><br></td>
		</tr>
		<tr>
			<td colspan="4" align='right' style='font-size: 8pt;'><br><br></td>
			<td colspan="3" style='font-size: 8pt;' align='right'><br><br></td>
		</tr>
		<tr>
			<td colspan="4" style='font-size: 8pt;'></td>
			<td colspan="3" style='font-size: 8pt;' align='center'>
			    <?php 
			        echo ucfirst($setting_nama_bendahara['setting_value']);
			    ?><br>
			    <?php 
			        echo 'NIP. '.ucfirst($setting_nip_bendahara['setting_value']);
			    ?>
			</td>
		</tr>
	</table>
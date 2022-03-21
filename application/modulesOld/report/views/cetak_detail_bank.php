<!DOCTYPE html>
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
?>
<html>
<head>
	<title><?php echo 'Laporan per Jenis Anggaran (Kas Bank) per Tanggal '.pretty_date($ds, 'd/m/Y', FALSE).' Sampai '.pretty_date($de, 'd/m/Y', FALSE) ?></title>
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
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<td style='width: 24mm; font-size: 8pt; text-align: left'>Unit Sekolah</td>
				<td style='width: 1mm; font-size: 8pt; text-align: center'>:</td>
				<td style='width: 165mm; font-size: 8pt; text-align: left'><?php echo $unit ?></td>
			</tr>
		</table>
		<br>
		<table style='width: 190mm;'>
			<tr>
			    <td style='width: 20mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td style='width: 150mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Laporan per Jenis Anggaran (Kas Bank) per Tanggal '.pretty_date($ds, 'd F Y', FALSE).' Sampai '.pretty_date($de, 'd F Y', FALSE) ?></b></td>
				<td style='width: 20mm; font-size: 8pt;' align='right'></td>
			</tr>
			<tr>
			    <td style='width: 20mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td style='width: 150mm; font-size: 8pt; text-align: center' valign='top' align='center'>Tahun Ajaran <?php echo $dataPeriod['period_start'].'/'.$dataPeriod['period_end'] ?></td>
				<td style='width: 20mm; font-size: 8pt;' align='right'></td>
			</tr>
		</table>
		<br>
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
				';
			//$no       = 1;
			$sumBulan = 0;
		    foreach ($bulan as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: left; width: 190mm">'.$row['account_code'].'-'.$row['account_description'];
                        $paramBulan = $row['account_code'];
                        $kasBulan = $row['kas_account_id'];
                        $detailBulan = $this->Detail_jurnal_model->get_bulan($ds, $de, $period_id, $majors_id, $paramBulan, $kasBulan);
                    echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                			<tr>
                				<th align="center" style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                				<th align="center" style="font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                				<th align="center" style="font-size: 8pt; width: 15mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                				<th align="center" style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Kelas</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Penerimaan</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Pengeluaran</th>
                			</tr>';
						$sumBln = 0;
					    $no = 1;
					    foreach($detailBulan as $res){
				        echo '<tr>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($res['bulan_date_pay'], 'd/m/Y', FALSE).'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.wordwrap($res['pos_name'].' - T.A '.$res['period_start'].'/'.$res['period_end'].'-'.$res['month_name'],30,"<br>\n").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$res['student_nis'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$res['student_full_name'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$res['class_name'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($res['bulan_bill'], 0, ",", ".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
						    </tr>';
						    $sumBln += $res['bulan_bill'];
					    }
					   echo '<tr style="background-color: #f0f0f0">
				                <td colspan="6" style="padding: 1px; font-size: 8pt; text-align: center"> <b>Total</b> </td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($sumBln, 0, ",", ".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center"></td>
						    </tr>';
				echo '</table><br>';  
			echo '</td></tr>';
			    $sumBulan += $row['total_bulan_bill'];
		    } 
		    $sumFree = 0;
		    foreach ($free as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: left; width: 190mm">'.$row['account_code'].'-'.$row['account_description'];
                        $paramFree = $row['account_code'];
                        $kasFree = $row['kas_account_id'];
                        $detailFree = $this->Detail_jurnal_model->get_free($ds, $de, $period_id, $majors_id, $paramFree, $kasFree);
                        echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                			<tr>
                			    <th align="center" style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                				<th align="center" style="font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                				<th align="center" style="font-size: 8pt; width: 15mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                				<th align="center" style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Kelas</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Penerimaan</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Pengeluaran</th>
                			</tr>';
						$sumBebas = 0;
					    $no = 1;
					    foreach($detailFree as $res){
				        echo '<tr>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($res['bebas_pay_input_date'], 'd/m/Y', FALSE).'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.wordwrap($res['pos_name'].' - T.A '.$res['period_start'].'/'.$res['period_end'],30,"<br>\n").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$res['student_nis'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$res['student_full_name'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$res['class_name'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($res['bebas_pay_bill'],0,",",".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
						    </tr>';
						    $sumBebas += $res['bebas_pay_bill'];
					    }
					    echo '<tr style="background-color: #f0f0f0">
				                <td colspan="6" style="padding: 1px; font-size: 8pt; text-align: center"> <b>Total</b> </td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($sumBebas, 0, ",", ".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center"></td>
						    </tr>';
				echo '</table><br>';
			echo '</td></tr>';
			    $sumFree += $row['total_bebas_pay_bill'];
		    }
		    $sumDebit = 0;
		    foreach ($debit as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: left; width: 190mm">'.$row['account_code'].'-'.$row['account_description'];
                        $paramDebit = $row['account_code'];
                        $kasDebit = $row['kas_account_id'];
                        $detailDebit = $this->Detail_jurnal_model->get_debit($ds, $de, $period_id, $majors_id, $paramDebit, $kasDebit);
                        echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                			<tr>
                				<th align="center" style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                				<th align="center" style="font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                				<th align="center" style="font-size: 8pt; width: 15mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                				<th align="center" style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Kelas</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Penerimaan</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Pengeluaran</th>
                			</tr>';
						$sumDeb = 0;
					    $no = 1;
					    foreach($detailDebit as $res){
				        echo '<tr>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($res['debit_date'], 'd/m/Y', FALSE).'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$res['debit_desc'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($res['debit_value'],0,",",".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
						    </tr>';
						    $sumDeb += $res['debit_value'];
					    }
					   echo '<tr style="background-color: #f0f0f0">
				                <td colspan="6" style="padding: 1px; font-size: 8pt; text-align: center"> <b>Total</b> </td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($sumDeb, 0, ",", ".").'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center"></td>
						    </tr>';
				echo '</table><br>';
			echo '</td></tr>';
			    $sumDebit += $row['total_debit_value'];
		    }
	echo '</table><br>';
	?>
	<?php 
	    echo '<b><font size="10px">Pengeluaran</font></b>
	          <table cellpadding="0" cellspacing="0" style="width: 190mm;">
				';
			$no       = 1;
			$sumKredit = 0;
		    foreach ($kredit as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: left; width: 190mm">'.$row['account_code'].'-'.$row['account_description'];
                        $paramKredit = $row['account_code'];
                        $kasKredit = $row['kas_account_id'];
                        $detailKredit = $this->Detail_jurnal_model->get_kredit($ds, $de, $period_id, $majors_id, $paramKredit, $kasKredit);
                        echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                			<tr>
                			    <th align="center" style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                				<th align="center" style="font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                				<th align="center" style="font-size: 8pt; width: 15mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                				<th align="center" style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Kelas</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Penerimaan</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Pengeluaran</th>
                			</tr>';
						$sumKre = 0;
					    $no = 1;
					    foreach($detailKredit as $res){
				        echo '<tr>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($res['kredit_date'], 'd/m/Y', FALSE).'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$res['kredit_desc'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($res['kredit_value'],0,",",".").'</td>
						    </tr>';
						    $sumKre += $res['kredit_value'];
					    }
					   echo '<tr style="background-color: #f0f0f0">
				                <td colspan="6" style="padding: 1px; font-size: 8pt; text-align: center"> <b>Total</b> </td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center"></td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($sumKre, 0, ",", ".").'</td>
						    </tr>';
				echo '</table><br>';
			echo '</td></tr>';
			    $sumKredit += $row['total_kredit_value'];
		    }
		    $sumGaji = 0;
		    foreach ($gaji as $row) {
	        echo '<tr>
	                <td style="padding: 1px; font-size: 8pt; text-align: left; width: 190mm">'.$row['account_code'].'-'.$row['account_description'];
                        $paramGaji = $row['account_code'];
                        $kasGaji = $row['kas_account_id'];
                        $detailGaji = $this->Detail_jurnal_model->get_kredit($ds, $de, $period_id, $majors_id, $paramGaji, $kasGaji);
                        echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                			<tr>
                			    <th align="center" style="font-size: 8pt; width: 5mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                				<th align="center" style="font-size: 8pt; width: 50mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                				<th align="center" style="font-size: 8pt; width: 15mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                				<th align="center" style="font-size: 8pt; width: 40mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Kelas</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Penerimaan</th>
                				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Pengeluaran</th>
                			</tr>';
						$sumGj = 0;
					    $no = 1;
					    foreach($detailGaji as $res){
				        echo '<tr>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($res['kredit_date'], 'd/m/Y', FALSE).'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$res['kredit_desc'].'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'-'.'</td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($res['kredit_value'],0,",",".").'</td>
						    </tr>';
						    $sumGj += $res['kredit_value'];
					    }
					   echo '<tr style="background-color: #f0f0f0">
				                <td colspan="6" style="padding: 1px; font-size: 8pt; text-align: center"> <b>Total</b> </td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center"></td>
				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.number_format($sumGj, 0, ",", ".").'</td>
						    </tr>';
				echo '</table><br>';
			echo '</td></tr>';
			    $sumGaji += $row['total_kredit_value'];
		    }
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
			<td colspan = "2" style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'></td>
			<td style='font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'></td>
			<td style='font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'><b>Debit</b></td>
			<td style='font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'></td>
			<td style='font-size: 8pt; border-bottom: 1px solid #999999; border-top: 1px solid #999999; text-align: center'><b>Kredit</b></td>
		</tr>
		<tr>
			<td colspan = "2" style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Sub Total</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumA, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumB, 0, ",", ".") ?></td>
		</tr>
		<tr>
			<td colspan = "2" style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Saldo Awal</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($saldoAwal['nominal']+$sumLastA-$sumLastB, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'> </td>
			<td style='font-size: 8pt; text-align: center'>-</td>
		</tr>
		<tr>
			<td colspan = "2" style='font-size: 8pt;'></td>
			<td style='font-size: 8pt;'><strong>Total</strong></td>
			<td style='font-size: 8pt; text-align: center'>:</td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($saldoAwal['nominal']+$sumA+$sumLastA, 0, ",", ".") ?></td>
			<td style='font-size: 8pt; text-align: center'>Rp </td>
			<td style='font-size: 8pt; text-align: center'><?php echo number_format($sumB+$sumLastB, 0, ",", ".") ?></td>
		</tr>
		<tr>
			<td colspan = "2" style='font-size: 8pt; text-align: center'></td>
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
			<td colspan = "5" align='right' style='width: 140mm; font-size: 8pt;'></td>
			<td colspan = "3"  style='width: 50mm; font-size: 8pt;' align='center'><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
		</tr>
		<tr>
			<td colspan = "5" style='font-size: 8pt;'><br><br></td>
			<td colspan = "3" style='font-size: 8pt;' align='right'><br><br></td>
		</tr>
		<tr>
			<td colspan = "5" align='right' style='font-size: 8pt;'><br><br></td>
			<td colspan = "3" style='font-size: 8pt;' align='right'><br><br></td>
		</tr>
		<tr>
			<td colspan = "5" style='font-size: 8pt;'></td>
			<td colspan = "3" style='font-size: 8pt;' align='center'>
			    <?php 
			        echo ucfirst($setting_nama_bendahara['setting_value']);
			    ?><br>
			    <?php 
			        echo 'NIP. '.ucfirst($setting_nip_bendahara['setting_value']);
			    ?>
			</td>
		</tr>
	</table>
</body>
</html>
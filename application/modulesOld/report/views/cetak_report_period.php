<!DOCTYPE html>
<?php 
    $ds         = $this->uri->segment('4');
    $de         = $this->uri->segment('5');
	$id_periode = $this->uri->segment('6');
    $id_tagihan = $this->uri->segment('7');
    $id_kelas   = $this->uri->segment('8');
    
    if($this->uri->segment('8') != '0'){
        $kelas = $dataClass['class_name'];
    } else {
        $kelas = 'Semua Kelas';
    }
?>
<html>
<head>
	<title><?php echo 'Laporan Pembayaran Kelas '.$kelas.' T.A.'.$dataPeriod['period_start'].'/'.$dataPeriod['period_end'].' Tanggal '.pretty_date($ds,"d/m/Y",FALSE).' Sampai '.pretty_date($de,"d/m/Y",FALSE) ?></title>
</head>
<body>
    <table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 190mm;'>
        	<tr valign='top'>
        		<td style='width: 187mm;' valign='middle'>
        			<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><font face="arial"><?php echo $setting_school['setting_value'] ?></font>
        			</div>
        			<span style='font-size: 8pt;'><?php echo $setting_address['setting_value'] ?>, Telp. 
        	<?php echo $setting_phone['setting_value'] ?></span>
        		</td>
        	</tr>
        </table>
		<br>
		<table style='width: 190mm;'>
			<tr>
			    <td style='width: 50mm; font-size: 8pt; text-align: center' valign='center'></td>
				<td style='width: 90mm; font-size: 8pt; text-align: center' valign='top' align='center'><b><?php echo 'Laporan Pembayaran Tanggal '.pretty_date($ds,"d F Y",FALSE).' Sampai '.pretty_date($de,"d F Y",FALSE) ?></b></td>
				<td style='width: 50mm; font-size: 8pt;' align='right'></td>
			</tr>
		</table>
		<br>
		<table cellpadding='0' cellspacing='0' style='width: 190mm;'>
			<tr>
				<td style='width: 35mm; font-size: 8pt;'>Tahun Ajaran</td>
				<td style='width: 5mm; font-size: 8pt;'>:</td>
				<td style='width: 150mm; font-size: 8pt;'><?php echo $dataPeriod['period_start'].'/'.$dataPeriod['period_end'] ?></td>
			</tr>
			<tr valign='top'>
				<td style='font-size: 8pt;'>Kelas</td>
				<td style='font-size: 8pt;'>:</td>
				<td style='font-size: 8pt;'><?php echo $kelas ?></td>
			</tr>
		</table>
		<br>
<?php echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
			    <tr>
			    <td colspan="6" style="padding: 1px; font-size: 8pt;">';
    			foreach($dataPayment as $result){
    			    echo '<b>'.$result['pos_name'].' - T.A '.$result['period_start'].'/'.$result['period_end'].'</b>';
    			    
                    $paymentID      = $result['payment_id'];
                    $paymentType    = $result['payment_type'];
                    if($paymentType == 'BULAN'){
                        $data = $this->Report_model->get_bulan($paymentID, $id_kelas, $ds, $de);
                        $dataSum = $this->Report_model->get_sum_bulan($id_kelas, $ds, $de);
                        $grandBulan = $dataSum['total'];
		                        
		              echo '<table cellpadding="0" cellspacing="0" style="width: 190mm;">
                    			<tr>
                    				<th align="center" style="font-size: 8pt; width: 10mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                    				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                    				<th align="center" style="font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;"></th>
                    				<th align="center" style="font-size: 8pt; width: 10mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nominal</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                    			</tr>';
    						$sumBulan = 0;
    					    $no = 1;
    					    foreach($data as $row){
    				        echo '<tr>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$no++.'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.pretty_date($row['bulan_date_pay'],"d/m/Y",FALSE).'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['student_nis'].'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: left">'.$row['student_full_name'].'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.'Rp '.'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.number_format($row['bulan_bill'],0,",",".").'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center">'.$row['month_name'].'</td>
    						    </tr>';
    						    $sumBulan += $row['bulan_bill'];
    					    }
    						echo '<tr style="background-color: #d6d4d4">
    						        <td colspan="4" style="padding: 1px; font-size: 8pt; text-align: left;"><b>Total Pembayaran</b>
    						        </td>
    						        <td style="padding: 1px; font-size: 8pt; text-align: center;"><b>Rp </b>
    						        </td>
    						        <td style="padding: 1px; font-size: 8pt; text-align: center;">'.'<b>'.number_format($sumBulan,0,",",".").'</b></td><td>
    						        </td>
    						      </tr>';
    				echo '</table><br>';
		                    } else {
		                        $data = $this->Report_model->get_bebas($paymentID, $id_kelas, $ds, $de);
                                $dataSum = $this->Report_model->get_sum_bebas($id_kelas, $ds, $de);
                                $grandBebas = $dataSum['total'];
		                        echo '
		                  <table cellpadding="0" cellspacing="0" style="width: 190mm;">
                    			<tr>
                    				<th align="center" style="font-size: 8pt; width: 10mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">No.</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Tanggal</th>
                    				<th align="center" style="font-size: 8pt; width: 20mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">NIS</th>
                    				<th align="center" style="font-size: 8pt; width: 45mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nama</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;"></th>
                    				<th align="center" style="font-size: 8pt; width: 10mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Nominal</th>
                    				<th align="center" style="font-size: 8pt; width: 35mm; padding: 1px 0px 1px 0px; border-top: 1px solid #999999; border-bottom: 1px solid #999999;">Keterangan</th>
                    			</tr>';
    						$sumBebas = 0;
    					    $no = 1;
    					    foreach($data as $row){
    				        echo '<tr>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center;">'.$no++.'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center;">'.pretty_date($row['bebas_pay_input_date'],"d/m/Y",FALSE).'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center;">'.$row['student_nis'].'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: left;">'.$row['student_full_name'].'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center; text-align: center">'.'Rp '.'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center;">'.number_format($row['bebas_pay_bill'],0,",",".").'</td>
    				                <td style="padding: 1px; font-size: 8pt; text-align: center;">'.$row['bebas_pay_desc'].'</td>
    						    </tr>';
    						    $sumBebas += $row['bebas_pay_bill'];
    					    }
    						echo '<tr style="background-color: #d6d4d4">
    						        <td colspan="4" style="padding: 1px; font-size: 8pt; text-align: left;"><b>Total Pembayaran</b>
    						        </td>
    						        <td style="padding: 1px; font-size: 8pt; text-align: center;"><b>Rp </b>
    						        </td>
    						        <td style="padding: 1px; font-size: 8pt; text-align: center;">'.'<b>'.number_format($sumBebas,0,",",".").'</b></td><td>
    						        </td>
    						      </tr>';
    				echo '</table><br>';
		                    }
            			}
            			
    		    echo '</td>
    		          </tr>
    		          </table>
    		          <p></p>'; ?>
    		<table cellpadding="0" cellspacing="0" style="width: 190mm">
			<tr>
				<td style='width: 30mm; font-size: 8pt;' align='left'><b>Total Keseluruhan</b></td>
				<td style='width: 5mm; font-size: 8pt;' align='left'><b>:</b></td>
				<td style='width: 30mm; font-size: 8pt;' align='left'><b><?php echo 'Rp '.number_format($grandBulan+$grandBebas,0,",",".") ?></b></td>
				<td align='right' style='width: 115mm; font-size: 8pt;'></td>
			</tr>
		    </table>
		    <br>
			<table cellpadding="0" cellspacing="0" style="width: 190mm">
			<tr>
				<td align='right' style='width: 140mm; font-size: 8pt;'></td>
				<td style='width: 50mm; font-size: 8pt;' align='center'><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
			</tr>
			<tr>
				<td style='font-size: 8pt;'><br><br></td>
				<td style='font-size: 8pt;' align='right'><br><br></td>
			</tr>
			<tr>
				<td align='right' style='font-size: 8pt;'><br><br></td>
				<td style='font-size: 8pt;' align='right'><br><br></td>
			</tr>
			<tr>
				<td style='font-size: 8pt;'></td>
				<td style='font-size: 8pt;' align='center'>
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
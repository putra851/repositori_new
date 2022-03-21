<!DOCTYPE html>
<html>
<head>
	<title><?php foreach ($siswa as $row):?> <?php echo (base64_decode($f['r']) == $row['student_nis']) ? $row['student_full_name'] : '' ?><?php endforeach; ?></title>
</head>

<style type="text/css">

@page {
	margin-top: 0.5cm;
	/*margin-bottom: 0.1em;*/
	margin-left: 1cm;
	margin-right: 1cm;
	margin-bottom: 0.1cm;
}
.name-school{
	font-size: 12pt;
	font-weight: bold;
	padding-bottom: -15px;
}

.unit{
    font-weight: bold;
	font-size: 8pt;
	margin-bottom: -10px;
}

.alamat{
	font-size: 8pt;
	margin-bottom: 10px;
}
.detail{
	font-size: 8pt;
	font-weight: bold;
	padding-top: -15px;
	padding-bottom: -12px;
}
body {
	font-family: sans-serif;
	/*font-family: dotmatrx;*/
}
table {
	/*font-family: dotmatrx;*/
	font-family: verdana,arial,sans-serif;
	font-size:10px;
	color:#333333;
	border-width: none;
	/*border-color: #666666;*/
	border-collapse: collapse;
	width: 100%;
}

th {
	padding-bottom: 8px;
	padding-top: 8px;
	border-color: #666666;
	background-color: #ffffff;
	/*border-bottom: solid;*/
	text-align: left;
}

td {
	text-align: left;
	border-color: #666666;
	background-color: #ffffff;
}

hr {
	border: none;
	height: 1px;
	/* Set the hr color */
	color: #333; /* old IE */
	background-color: #333; /* Modern Browsers */
}

.container {
	position: relative;
}

.topright {
	position: absolute;
	top: 0;
	right: 0;
	font-size: 8px;
	border-width: thin;
	padding: 5px;
}
.topright2 {
	position: absolute;
	top: 30px;
	right: 50px;
	font-size: 8px;
	border: 1px solid;
	padding: 5px;
	color: red;
}
</style>

<style>
img {
  filter: grayscale(100%);
}
</style>

<body>

	<table>
	    <tr>
	        <td align="center">
            	<p class="name-school"><?php echo $setting_school['setting_value'] ?></p>
                	<?php 
                	$num = count($unit);
                	if($num > 1){
            	echo '<p class="unit">';
                	foreach($unit as $row){
                	    $data  = $row['majors_short_name'];
                	    $Pecah = explode( " ", $data );
                        for ( $i = 0; $i < count( $Pecah ); $i++ ) {
                            echo $Pecah[$i] . " ";
                        } 
                      }
                  echo '</p>';
                  
                    } ?>
              <p class="alamat"><?php echo $setting_address['setting_value'] ?><?php echo ' Telp. '.$setting_phone['setting_value'] ?></p>
        	</td>
	    </tr>
	</table>
		<hr>
		<table style="padding-top: -5px; padding-bottom: 5px">
		        <tr>
					<td style="width: 100px;">No. Referensi</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php echo $bcode['kas_noref']; ?></td>
			    </tr>
			    <tr>
					<td style="width: 100px;">Tahun Ajaran</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php foreach ($period as $row):?> <?php echo (base64_decode($f['n']) == $row['period_id']) ? $row['period_start'].'/'.$row['period_end'] : '' ?><?php endforeach; ?></td>
			    </tr>
				<tr>
					<td style="width: 100px;">Tanggal Pembayaran</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php echo pretty_date(base64_decode($f['d']),'d F Y',false)?></td>
				</tr>
				<tr>
					<td style="width: 100px;">Akun Kas</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php echo $bcode['account_description']?></td>
				</tr>
				<tr>
					<td style="width: 100px;">NIS</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['student_nis']?></td>
				<?php endforeach ?>
				</tr>
				<tr>
					<td style="width: 100px;">Nama</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['student_full_name']?></td>
					<?php endforeach ?>
				</tr>
				<tr>
					<td style="width: 100px;">Kelas</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['class_name']?></td>
					<?php endforeach ?>
				</tr>
				<tr>
					<td style="width: 100px;">Kamar</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['madin_name']?></td>
					<?php endforeach ?>
				</tr>
			
		</table>
		<table style="border-style: solid;">
			<tr>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">No.</th>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">Pembayaran</th>
				<th colspan="2" style="border-top: 1px solid; border-bottom: 1px solid; text-align: center">Jumlah Pembayaran</th>
			</tr>
			<?php
				$i =1;
				foreach ($bulan as $row) :
					$namePay = $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
					$mont = ($row['month_month_id']<=6) ? $row['period_start'] : $row['period_end'];
				 ?>
			<tr>
				<td style="border-bottom: 1px solid;padding-top: 10px; padding-bottom: 10px;" valign="top"><?php echo $i ?></td>
				<td style="border-bottom: 1px solid;" valign="top"><?php echo $namePay.' - ('.$row['month_name'].' '. $mont.')' ?></td>
				<td style="border-bottom: 1px solid;" valign="top">Rp. </td>
				<td style="border-bottom: 1px solid; text-align: right;" valign="top"><?php echo number_format($row['bulan_bill'], 0, ',', '.') ?></td>
			</tr>
			<?php 
				$i++;
				endforeach ?>

			<?php
				$j =$i;
				foreach ($free as $row) :
					$namePayFree = $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end'];
				 ?>
			<tr>
				<td style="border-bottom: 1px solid;padding-top: 10px; padding-bottom: 10px;" valign="top"><?php echo $j ?></td>
				<td style="border-bottom: 1px solid;" valign="top"><?php echo $namePayFree .' - ('.$row['bebas_pay_desc'].')' ?></td>
				<td style="border-bottom: 1px solid;" valign="top">Rp. </td>
				<td style="border-bottom: 1px solid; text-align: right;" valign="top"><?php echo number_format($row['bebas_pay_bill'], 0, ',', '.') ?></td>
			</tr>
			<?php 
				$j++;
				endforeach ?>
			<tr>
				<td colspan="2" style="background-color: #ffffff; font-weight:bold; border-bottom: 1px solid;">Total Pembayaran</td>
				<td style="background-color: #ffffff;font-weight:bold;border-bottom: 1px solid;">Rp. </td>
				<td style="background-color: #ffffff; font-weight:bold;border-bottom: 1px solid; text-align: right;"><?php echo number_format($summonth+$sumbeb, 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="2" style="background-color: #ffffff; font-weight:bold; border-bottom: 1px solid;">Terbilang</td>
				<td colspan="2" style="background-color: #ffffff; font-weight:bold;border-bottom: 1px solid; text-align: right;"><?php echo $huruf ?></td>
			</tr>
				
			<?php 
			    $user = $this->db->query("SELECT users.user_full_name AS kasir FROM users JOIN kas ON kas.kas_user_id = users.user_id WHERE kas.kas_noref = '" . $bcode['kas_noref'] . "'")->row_array();
			?>
			
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
		    <tr>
		        <td colspan="4" style="text-align: center">
		            <?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?>
		        </td>
		    </tr>
			<tr>
				<td colspan="4" style="text-align: center">Kasir</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center"><b><?php echo ucfirst($user['kasir']); ?></b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="4" style="text-align: center">Simpan Kwitansi Ini Sebagai Bukti Pembayaran yang Sah</td>
			</tr>
		</table>
		<br>
		
		

		

	</body>
	</html>
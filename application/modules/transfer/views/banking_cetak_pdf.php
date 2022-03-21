<!DOCTYPE html>
<html>
<head>
	<title><?php foreach ($siswa as $row):?> <?php echo ($f['r'] == $row['student_nis']) ? $row['student_full_name'] : '' ?><?php endforeach; ?></title>
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
	font-size: 15pt;
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
	margin-bottom: -10px;
}
.detail{
	font-size: 10pt;
	font-weight: bold;
	padding-top: -15px;
	padding-bottom: -12px;
}
body {
	font-family: sans-serif;
}
table {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
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
	background-color: #dedede;
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
	font-size: 18px;
	border-width: thin;
	padding: 5px;
}
.topright2 {
	position: absolute;
	top: 30px;
	right: 50px;
	font-size: 18px;
	border: 1px solid;
	padding: 5px;
	color: red;
}
</style>
<body>

	<div class="container">
		<div class="topright">
		    Bukti Transaksi<br>
		<?php
    $num = count($unit);
	if($num > 1){ ?>
        <font size=12px>
        Unit Sekolah : 
      <?php foreach ($siswa as $row): ?>
        <?php echo $row['majors_short_name'].'<br>' ?>
      <?php endforeach; ?></font>
      <?php } ?>
      <?php
        $tanggal = date_create($f['d']);
        $dformat = date_format($tanggal,'dmYHis');
      ?>
       <?php foreach($siswa as $row){ ?>
       <img style="width:142.56pt;height:18pt;z-index:6;" src="<?php echo media_url().'barcode_transaction/TAB-'.$dformat.$row['student_nis'].'.png' ?>" alt="Image_4_0" /><br>
       <font size="12px"><?php echo 'TAB-'.$dformat.$row['student_nis']; ?></font>
       <?php } ?>
      </div>
	</div>
	<p class="name-school"><?php echo $setting_school['setting_value'] ?></p>
	<p class="unit">
	<?php 
	$num = count($unit);
	if($num > 1){
    	foreach($unit as $row){
    	    $data  = $row['majors_short_name'];
    	    $pecah = explode( " ", $data );
            for ( $i = 0; $i < count( $pecah ); $i++ ) {
                echo $pecah[$i] . " ";
            } 
        }
    } ?>
    </p>
	<p class="alamat"><?php echo $setting_address['setting_value'] ?><br>
		<?php echo $setting_phone['setting_value'] ?></p>
		<hr>
		<table style="padding-top: -5px; padding-bottom: 5px">
			<tbody>
				<tr>
					<td style="width: 100px;">NIS</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['student_nis']?></td>
				<?php endforeach ?>
					<td style="width: 130px;">Tanggal Transaksi</td>
					<td style="width: 5px;">:</td>
					<td style="width: 131px;"><?php echo pretty_date($f['d'],'d F Y',false)?></td>
				</tr>
				<tr>
					<td style="width: 100px;">Nama</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['student_full_name']?></td>
					<?php endforeach ?>
					<td style="width: 130px;">Tahun Ajaran</td>
					<td style="width: 5px;">:</td>
					<td style="width: 131px;"><?php foreach ($period as $row):?> <?php echo ($f['n'] == $row['period_id']) ? $row['period_start'].'/'.$row['period_end'] : '' ?><?php endforeach; ?></td>
				</tr>
				<tr>
					<td style="width: 100px;">Kelas</td>
					<td style="width: 5px;">:</td>
					<?php foreach ($siswa as $row): ?>
					<td style="width: 150px;"><?php echo $row['class_name']?></td>
					<?php endforeach ?>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="detail">Dengan rincian transaksi sebagai berikut:</p>

		<table style="border-style: solid;">
			<tr>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">No.</th>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">Kode</th>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">Catatan</th>
				<th colspan="2" style="border-top: 1px solid; border-bottom: 1px solid;" align="center">Debit</th>
				<th colspan="2" style="border-top: 1px solid; border-bottom: 1px solid;" align="center">Kredit</th>
			</tr>
			<?php
				$i =1;
				foreach ($trx as $row) :
				 ?>
			<tr>
				<td style="border-bottom: 1px solid;padding-top: 10px; padding-bottom: 10px;"><?php echo $i ?></td>
				<td style="border-bottom: 1px solid;"><?php echo ($row['banking_code'] == '1') ? 'DEB' : 'KRD' ?></td>
				<td style="border-bottom: 1px solid"><?php echo $row['banking_note'] ?></td>
				<td style="border-bottom: 1px solid;">Rp. </td>
				<td style="border-bottom: 1px solid; text-align: right;"><?php echo number_format($row['banking_debit'], 0, ',', '.') ?></td>
				<td style="border-bottom: 1px solid;">Rp. </td>
				<td style="border-bottom: 1px solid; text-align: right;"><?php echo number_format($row['banking_kredit'], 0, ',', '.') ?></td>
			</tr>
			<?php 
				$i++;
				endforeach ?>
			<tr>
				<td colspan="2" style="text-align: center;padding-top: 5px; padding-bottom: 5px;"></td>
				<td style="background-color: #dedede; font-weight:bold; border-bottom: 1px solid;">Total Transaksi</td>
				<td style="background-color: #dedede;font-weight:bold;border-bottom: 1px solid;">Rp. </td>
				<td style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: right;"><?php echo number_format($sumDebit, 0, ',', '.') ?></td>
				<td style="background-color: #dedede;font-weight:bold;border-bottom: 1px solid;">Rp. </td>
				<td style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: right;"><?php echo number_format($sumKredit, 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;padding-top: 5px; padding-bottom: 5px;"><?php echo $setting_city['setting_value'] ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false) ?></td>
				<td style="background-color: #dedede; font-weight:bold; border-bottom: 1px solid;">Saldo Sekarang</td>
				<td colspan="2" style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: right;">
				</td>
				<td style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: left;">
				    Rp. 
				</td>
				<td style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: right;">
				    <?php echo number_format($saldo, 0, ',', '.') ?>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" style="text-align: center;"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center">Bendahara</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center"><b><?php echo ucfirst($setting_nama_bendahara['setting_value']); ?></b></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center">NIP. <?php echo ucfirst($setting_nip_bendahara['setting_value']); ?></td>
			</tr>
		</table>
		<br>
		
		

		

	</body>
	</html>
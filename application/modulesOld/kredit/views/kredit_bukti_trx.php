<!DOCTYPE html>
<html>
<head>
	<title><?php echo ($bcode['kas_noref'] != '') ? $bcode['kas_noref'] : '' ?></title>
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
	padding-top: -15px;
}

.unit{
    font-weight: bold;
	font-size: 10pt;
	margin-bottom: 10px;
}

.alamat{
	font-size: 10pt;
	margin-bottom: 10px;
	padding-top: -10px;
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
		    Bukti Kas Keluar<br>
		<?php
    $num = count($unit);
	if($num > 1){ ?>
        <font size=12px>
        Unit Sekolah : 
        <?php echo $sumKredit['majors_short_name'].'<br>' ?>
      <?php } ?>
       <img style="width:100.5pt;height:15pt;z-index:6;" src="<?php echo 'media/barcode_transaction/'.$bcode['kas_noref'].'.png' ?>" alt="Image_4_0" /><br>
       <font size="8px"><?php echo $bcode['kas_noref']; ?></font>
      </div>
	</div>
	<table>
	    <tr>
	        <td width="6%">
	            <img src="<?php echo upload_url('school/' . logo()) ?>" style="height: 48px;">
	        </td>
	        <td>
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
	<!--<p class="name-school"><?php echo $setting_school['setting_value'] ?></p>
	<p class="unit">
	<?php 
	$num = count($unit);
	if($num > 1){
	foreach($unit as $row){
	    $data  = $row['majors_short_name'];
	    $Pecah = explode( " ", $data );
        for ( $i = 0; $i < count( $Pecah ); $i++ ) {
            echo $Pecah[$i] . " ";
        } 
      }
    } ?></p>
	<p class="alamat"><?php echo $setting_address['setting_value'] ?><br>
		<?php echo $setting_phone['setting_value'] ?></p>-->
		<hr>
		<table style="padding-top: -5px; padding-bottom: 5px">
			<tbody>
				<tr>
					<td style="width: 100px;">No. Referensi</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php echo $bcode['kas_noref'] ?></td>
					<td style="width: 130px;">Tanggal Pengeluaran</td>
					<td style="width: 5px;">:</td>
					<td style="width: 131px;">
					    <?php echo pretty_date($bcode['kas_date'],'d F Y',false) ?>
				    </td>
				</tr>
				<tr>
					<td style="width: 100px;">Akun Kas</td>
					<td style="width: 5px;">:</td>
					<td style="width: 150px;"><?php echo $bcode['account_description']?></td>
					<td style="width: 100px;"></td>
					<td style="width: 5px;"></td>
					<td style="width: 150px;"></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="detail">Dengan rincian pengeluaran sebagai berikut:</p>

		<table style="border-style: solid;">
			<tr>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">No.</th>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">Akun</th>
				<th style="border-top: 1px solid; border-bottom: 1px solid;">Keterangan</th>
				<th colspan="2" style="border-top: 1px solid; border-bottom: 1px solid; text-align: center">Jumlah Pengeluaran</th>
			</tr>
			<?php
				$i =1;
				foreach ($kredit as $row) :
				 ?>
			<tr>
				<td style="border-bottom: 1px solid;padding-top: 10px; padding-bottom: 10px;"><?php echo $i ?></td>
				<td style="border-bottom: 1px solid;"><?php echo $row['account_code'].'-'.$row['account_description'] ?></td>
				<td style="border-bottom: 1px solid"><?php echo $row['kredit_desc'] ?></td>
				<td style="border-bottom: 1px solid;">Rp. </td>
				<td style="border-bottom: 1px solid; text-align: right;"><?php echo number_format($row['kredit_value'], 0, ',', '.') ?></td>
			</tr>
			<?php 
				$i++;
				endforeach ?>
			<tr>
				<td colspan="2" style="text-align: center;padding-top: 5px; padding-bottom: 5px;"></td>
				<td style="background-color: #dedede; font-weight:bold; border-bottom: 1px solid;">Total Pengeluaran</td>
				<td style="background-color: #dedede;font-weight:bold;border-bottom: 1px solid;">Rp. </td>
				<td style="background-color: #dedede; font-weight:bold;border-bottom: 1px solid; text-align: right;"><?php echo number_format($sumKredit['total'], 0, ',', '.') ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold;">Terbilang</td>
				<td colspan="2" style="font-weight:bold; text-align: left;"><?php echo $huruf ?></td>
				<td colspan="2" style="text-align: center;padding-top: 5px; padding-bottom: 5px;"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<table border="1">
		    <tr>
		        <td style="width: 100px; text-align: center">Disetujui</td>
				<td style="width: 100px; text-align: center">Kasir</td>
				<td style="width: 100px; text-align: center">Penerima</td>
				<td style="width: 220px; text-align: center">Catatan</td>
		    </tr>
		    <tr>
		        <td style="width: 100px;"><br><br><br></td>
				<td style="width: 100px;"><br><br><br></td>
				<td style="width: 100px;"><br><br><br></td>
				<td style="width: 220px;"><br><br><br></td>
		    </tr>
		</table>
	</body>
	</html>
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
	text-align: center;
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
	text-align: center;
	font-size: 8pt;
	margin-bottom: -10px;
}

.alamat2{
	text-align: center;
	font-size: 10pt;
	margin-bottom: -10px;
}
.detail{
	font-size: 10pt;
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
	padding-bottom: 10px;
	padding-top: 10px;
	font-weight: bold;
	border-color: #666666;
	background-color: #dedede;
	/*border-bottom: solid;*/
	text-align: left;
}

td {
	text-align: left;
	font-size: 10pt;
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
	<table>
	    <tr>
	        <td width="15%">
	            <img src="<?php echo 'uploads/school/' . logo() ?>" style="height: 100px;">
	        </td>
	        <td>
            	<p class="name-school"><?php echo "PUSAT KEAMANAN " . strtoupper($setting_school['setting_value']) ?></p>
                  <p class="alamat2"><?php echo $setting_address['setting_value'] ?><?php echo ' Telp. '.$setting_phone['setting_value'] ?></p>
        	</td>
	        <td width="15%">
	        </td>
	    </tr>
	</table>
		<hr>
		<table style="padding-top: -5px; padding-bottom: 5px">
		    <tr>
		    <td><p class="name-school"><u><?php echo "SURAT PERIZINAN PULANG" ?></u></p>
		    </td>
		    </tr>
		</table>
		<table style="padding-top: -5px; padding-bottom: 5px">
		    <tr>
		    <td><p class="detail">Yang bertanda tangan di bawah ini kami Pusat Keamanan pondok pesantren , menerangkan bahwa</p>
		    </td>
		    </tr>
		</table>
		<strong>    
		<table style="padding-top: -5px; padding-bottom: 5px">
			<tbody>
				<tr>
					<td style="width: 150px;">Nomor Induk Santri</td>
					<td style="width: 5px;">:</td>
					<td><?php echo $pulang['student_nis']?></td>
				</tr>
				<tr>
					<td style="width: 150px;">Nama</td>
					<td style="width: 5px;">:</td>
					<td><?php echo $pulang['student_full_name']?></td>
				</tr>
				<tr>
					<td style="width: 150px;">Kelas</td>
					<td style="width: 5px;">:</td>
					<td><?php echo $pulang['class_name']?></td>
				</tr>
				<tr>
					<td style="width: 150px;">Kamar</td>
					<td style="width: 5px;">:</td>
					<td><?php echo $pulang['madin_name']?></td>
				</tr>
			</tbody>
		</table>
		</strong>
		<br>
		<p class="detail">Untuk kembali kerumah dalam jangka waktu <?php echo $pulang['pulang_days'] ?> hari, dari tanggal <?php echo pretty_date($pulang['pulang_date'], 'd F Y', false) ?>  dengan keterangan <?php echo $pulang['pulang_note'] ?> </p>
        <br>
		<p class="detail">Demikian surat izin ini kami keluarkan, untuk dapat di gunakan sebagai mana <b>mestinya.</b></p>
		<table>
				
			<?php 
			    $user = $this->db->query("SELECT users.user_full_name AS petugas FROM users JOIN pulang ON pulang.pulang_id = users.user_id WHERE pulang.pulang_id = '" . $pulang['pulang_id'] . "'")->row_array();
			?>
			
			<tr>
				<td colspan="2" style="text-align: center;">Pusat Keamanan <?php echo $setting_school['setting_value'] ?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center">Pemberi Izin</td>
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
				<td colspan="2" style="text-align: center"><b><?php echo ucfirst($user['petugas']); ?></b></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<br>
		<table>
			<tbody>
				<tr>
					<td style="width: 100px;">Cap Legalisir</td>
					<td style="width: 50px;"></td>
				</tr>
				<tr>
					<td style="width: 100px;">1. Dewan Pembimbing Asrama</td>
					<td style="width: 50px;">(………)</td>
				</tr>
				<tr>
					<td style="width: 100px;">2. Dewan Pengasuhan</td><td style="width: 50px;">(………)</td>
				</tr>
			</tbody>
		</table>
		<br>
		<br>
		<br>
		<br>
		<table>
			<tbody>
				<tr>
					<td>Tembusan :</td>
				</tr>
				<tr>
					<td>1. Pengasuh <?php echo $setting_school['setting_value'] ?></td>
				</tr>
				<tr>
					<td>2. Wali Kelas</td>
				</tr>
				<tr>
					<td>3. Wali Santri</td>
				</tr>
			</tbody>
		</table>
	</body>
	</html>
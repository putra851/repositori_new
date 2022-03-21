<!DOCTYPE html>
<html>
<head>
	<title><?php echo 'Tiket_Kunjungan_Santri_' . $row['student_full_name'] ?></title>
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
	font-size:15px;
	color:#000000;
	border-width: none;
	/*border-color: #ffffff;*/
	border-collapse: collapse;
	width: 100%;
	text-align: center;
}

th {
	text-align: center;
	padding-bottom: 2px;
	padding-top: 2px;
	border-color: #ffffff;
	background-color: #ffffff;
	/*border-bottom: solid;*/
}

td {
	text-align: center;
	padding-bottom: 2px;
	padding-top: 2px;
	border-color: #ffffff;
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
		<table style="padding-top: 0px; padding-bottom: 0px">
        	    <tr>
        	        <td>
        	            <p class="name-address" align="center">Tiket Kunjungan Santri</p>
        	        </td>
        	    </tr>
				<tr>
					<th style="width: 100%;">NIS</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo $visit['student_nis'] ?></td>
				</tr>
				<tr>
					<th style="width: 100%;">Nama</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo $visit['student_full_name'] ?></td>
				</tr>
				<tr>
					<th style="width: 100%;">Kelas</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo $visit['class_name'] ?></td>
				</tr>
				<tr>
					<th style="width: 100%;">Kamar</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo $visit['madin_name'] ?></td>
				</tr>
				<tr>
					<th style="width: 100%;">Tanggal</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo pretty_date($visit['guest_list_date'], 'd F Y', false) ?></td>
				</tr>
				<tr>
					<th style="width: 100%;">Jam</th>
				</tr>
				<tr>
					<td style="width: 100%;"><?php echo $visit['guest_list_time'] ?></td>
				</tr>
				<tr>
				    <th style="width: 100%;">Daftar Pengujung</th>
				</tr>
			    <?php
		        $tamu = $this->Visit_model->get_tamu(array('list_tamu_kode' => $visit['guest_list_code']));
			        foreach ($tamu as $baris) :
			            echo '<tr><td style="width: 100%;">';
			            echo $baris['guest_name'] . ' (' . $baris['mahram_note'] . ')<br>';
			            echo '</td></tr>';
			        endforeach;
			    ?>
			
		</table>
		<table style="border-style: solid;">
			<?php 
			    $user = $this->db->query("SELECT users.user_full_name AS petugas FROM users JOIN guest_list ON guest_list.guest_list_user_id = users.user_id WHERE guest_list_id = '" . $visit['guest_list_id'] . "'")->row_array();
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
				<td colspan="4" style="text-align: center">Petugas</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center"><b><?php echo ucfirst($user['petugas']); ?></b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="4" style="text-align: center">Wajib diberikan kepada petugas sebelum masuk ke pesantren</td>
			</tr>
		</table>
		<br>
		
		

		

	</body>
	</html>
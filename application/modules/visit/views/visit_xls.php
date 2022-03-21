<?php

$period = $_GET['p'];
$unit   = $_GET['k'];
$kelas  = $_GET['c'];

if ($period == 0) {
    $periode = 'Semua';    
} else {
    $qPeriod = $this->db->query("SELECT period_start, period_end FROM period WHERE period_id = '$period'")->row_array();
    $periode = $qPeriod['period_start'].'/'.$qPeriod['period_end'];
}

if ($unit == 0) {
    $majors = 'Semua';    
} else {
    $qUnit = $this->db->query("SELECT majors_name, majors_short_name FROM majors WHERE majors_id = '$unit'")->row_array();
    $majors = $qUnit['majors_short_name'];
}

if ($kelas == 0) {
    $class = 'Semua';    
} else {
    $qKelas = $this->db->query("SELECT class_name FROM class WHERE class_id = '$kelas'")->row_array();
    $class = $qKelas['class_name'];
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekap_Kunjungan_T.A._".$periode."_Unit_".$majors."_Kelas_".$class.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table style='border-bottom: 1px solid #999999; padding-bottom: 10px; width: 277mm;'>
	<tr valign='top'>
		<td colspan="7" style='width: 55mm;' valign='middle'>
			<div style='font-weight: bold; padding-bottom: 5px; font-size: 14pt;'><?php echo $setting_school['setting_value']; ?>
			</div>
			<span style='font-size: 10pt;'><?php echo $setting_address['setting_value']; ?>, Telp. 
	<?php echo $setting_phone['setting_value']; ?></span>
		</td>
	</tr>
</table>
<br>
<table style='width: 277mm;'>
	<tr>
	    <td colspan="2" style='width: 92mm; font-size: 10pt; text-align: center' valign='center'></td>
		<td colspan="3" style='width: 93mm; font-size: 10pt; text-align: center' valign='top' align='center'><b><?php echo 'Rekap Kunjungan' ?></b></td>
		<td colspan="2" style='width: 92mm; font-size: 10pt;' align='right'></td>
	</tr>
</table>
<br>
<table cellpadding='0' cellspacing='0' style='width: 277mm;'>
	<tr>
		<td style='width: 35mm; font-size: 10pt;'>Tahun Ajaran</td>
		<td colspan='2' style='width: 45mm; font-size: 10pt;'> : <?php echo $periode; ?></td>
		<td colspan="4" style='width: 110mm; font-size: 10pt;'> </td>
	</tr>
	<tr valign='top'>
		<td style='font-size: 10pt;'>Unit</td>
		<td colspan="2" style='font-size: 10pt;'> : <?php echo $majors ?></td>
		<td colspan="4" style='font-size: 10pt;'> </td>
	</tr>
	<tr valign='top'>
		<td style='font-size: 10pt;'>Kelas</td>
		<td colspan="2" style='font-size: 10pt;'> : <?php echo $class ?></td>
		<td colspan="4" style='font-size: 10pt;'> </td>
	</tr>
</table>
<table border="1">
    <thead>
	    <tr>
			<th>No. </th> 
			<th>NIS</th> 
			<th>Nama</th>
			<th>Kelas</th>
			<th>Unit</th>
			<th>Total </th>
		</tr>
		</thead>
		<tbody>
		<?php 
		
		    $no = 1;
		    foreach ($visit as $row) : 
		?>
		<tr>
		    <td><?php echo $no++ ?></td>
			<td><?php echo $row['student_nis']?></td> 
			<td><?php echo $row['student_full_name']?></td>
			<td><?php echo $row['class_name']?></td>
			<td><?php echo $row['majors_short_name'] ?></td>
			<td><?php echo $row['guestlistSum'] . ' Kali' ?></td>
		</tr>
		<?php endforeach ?>
    </tbody>
</table>
<br>
<table>
<tr>
	<td colspan='3' align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
	<td colspan='2' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php echo $setting_city['setting_value']; ?>, <?php echo pretty_date(date('Y-m-d'),'d F Y',false); ?></td>
	<td align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
</tr>
<tr>
	<td colspan='3' align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
	<td colspan='3' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
	<td align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
</tr>
<tr>
	<td colspan='3' align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
	<td colspan='3' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='right'><br><br></td>
	<td align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'><br><br></td>
</tr>
<tr>
	<td colspan='3' align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
	<td colspan='2' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;' align='center'><?php 
	        echo ucfirst($setting_nama_bendahara['setting_value']).'<p></p>NIP. '.ucfirst($setting_nip_bendahara['setting_value']);?></td>
	<td align='right' style='font-size: 10pt; padding: 1px; border-top: 0px solid #999999; border-bottom: 0px solid #999999;'></td>
</tr>
</table>
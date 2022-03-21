<?php
$kls = str_replace(" ","-", $dataKelas->class_name);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Rekapitulasi_Pembayaran_Kelas_".$kls."_TA_".$dataHead->period_start."-".$dataHead->period_end."_".date('d-m-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");;
?>
<h2><?php echo $setting_school['setting_value']; ?></h2>
<p></p>
<h4></span><?php echo $setting_address['setting_value']; ?>, Telp. 
        	<?php echo $setting_phone['setting_value']; ?></span></h2>
<hr>
<h3><?php echo 'Rekapitulasi Pembayaran Kelas '.$dataKelas->class_name.' Tahun Ajaran '.$dataHead->period_start.'/'.$dataHead->period_end ?></h3>
<p></p>
<h5>Dibuat pada Tanggal : <?php echo date('d-m-Y') ?></h3>
<p></p>
<table border="1">
	<tr>
		<th rowspan="2">Kelas</th> 
		<th rowspan="2">Nama</th>
		<?php foreach ($py as $row) : ?>
			<th colspan="<?php echo count($month) ?>"><center><?php echo $row['pos_name'].' - T.A '.$row['period_start'].'/'.$row['period_end']; ?></center></th>
		<?php endforeach ?>
		<?php foreach ($bebas as $key) : ?>
			<th rowspan="2"><?php echo $key['pos_name'].' - T.A '.$key['period_start'].'/'.$key['period_end']; ?></th>
		<?php endforeach ?>
	</tr>
	<tr>
		<?php 
		    for($a=1; $a<=$looping['jml']; $a++) {
		    foreach ($month as $key) { 
		?>
			<th><?php echo $key['month_name'] ?></th>
		<?php 
		        } 
		    } 
		?>
	</tr>
	
	<?php foreach ($student as $row) : ?>
		<tr>
			<td><?php echo $row['class_name']?></td> 
			<td><?php echo $row['student_full_name']?></td>
			<?php foreach ($bulan as $key) { ?>
				<?php if ($key['student_student_id']==$row['student_student_id']) { ?>
				<td style="color:<?php echo ($key['bulan_status']==1) ? '#00000' : '#00000' ?>"><?php echo ($key['bulan_status']==1) ? 'Lunas' : number_format($key['bulan_bill'], 0, ',', '.') ?></td>
				<?php } ?>
			<?php } ?>
			<?php foreach ($free as $key) : ?>
				<?php if ($key['student_student_id']==$row['student_student_id']) { ?>
				<td style="text-align:center;color:<?php echo ($key['bebas_bill']==$key['bebas_total_pay']) ? '#00000' : '#00000' ?> "><?php echo ($key['bebas_bill']==$key['bebas_total_pay'])? 'Lunas' : number_format($key['bebas_bill']-$key['bebas_total_pay'],0,',','.') ?></td>
				<?php } ?>
			<?php endforeach ?>
		</tr>
	<?php endforeach ?>

</table>